<?php
class Menu extends CWidget {

    public $htmlOptions;

    public $template='<a href="{url}">{name}</a>';

    public $nesting = 1;

    public $items;

    public function init() {
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$id=$this->htmlOptions['id']=$this->getId();

        echo CHtml::tag('ul',$this->htmlOptions,false,false)."\n";
        echo $this->saveAsHtml($this->items, 1);
    }

	public function run()
	{
		echo "</ul>";
	}

    protected function saveAsHtml($items, $level) {
        $html='';
        foreach($items as $item) {
            $id=isset($item['id'])?' id="'.$this->htmlOptions['id'].'_item_'.$item['id'].'"':'';
            $css='';

            if($this->nesting>$level && isset($item['hasChildren']) && $item['hasChildren']) {
                if($css!=='')
                    $css.=' ';
                $css.='hasChildren';
            }

            if(isset($item['url']) && strpos(Yii::app()->request->getRequestUri(), $item['url'])!==false) {
                if($css!=='')
                    $css.=' ';
                $css.='current';
            }

			if($css!=='')
				$css=' class="'.$css.'"';

            $html.='<li'.$id.$css.'>'.$this->renderTemplate($item, $level);

            if($this->nesting>$level && isset($item['hasChildren']) && $item['hasChildren']) {
                $html.="\n<ul>\n";
                $html.=$this->saveAsHtml($item['children'], $level+1);
                $html.="</ul>\n";
            }
            $html.="</li>\n";
        }
        return $html;
    }

    protected function renderTemplate($item, $level) {
        $template=$this->getTemplate($level);
        preg_match_all('#{([a-z]+)}#i', $template, $matches);
        foreach($matches[1] as $param) {
            if(isset($item[$param]) && is_string($item[$param])) {
                $template = str_replace('{'.$param.'}', CHtml::encode($item[$param]), $template);
            }
        }
        return $template;
    }

    protected function getTemplate($level) {
        if(is_string($this->template))
            return $this->template;

        if(array_key_exists($level, $this->template))
            return $this->template[$level];

        if(array_key_exists('default', $this->template))
            return $this->template['default'];

        return reset($this->template);
    }
}