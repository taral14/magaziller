<?php
class MzSlider extends CWidget {

    public $template='{navigation}{content}{arrows}';

    public $width;
    public $height;
    public $htmlOptions=array();

    public $options=array();
    public $attribute;
    public $itemView;
    public $viewData;
    public $itemCssClass='';

    public $data;

    public function run() {
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$id=$this->htmlOptions['id']=$this->getId();

        echo CHtml::openTag('div', $this->htmlOptions);

        $data['{content}']=$this->renderContent();

        echo strtr($this->template, $data);

        echo CHtml::closeTag('div');
    }

    public function renderContent() {
        $itemWidth=$this->width.'px';
        $itemHeight=$this->height.'px';
        $totalWidth=count($this->data)*$this->width;

        $content=CHtml::openTag('div', array('style'=>"width:$itemWidth;height:$itemHeight;overflow:hidden"));

        $content.=CHtml::openTag('ul', array('style'=>"width:{$totalWidth}px;height:{$this->height}px;"))."\n";
        if($this->attribute) {
            foreach($this->data as $item)
                $content.=CHtml::tag('li', array('class'=>$this->itemCssClass), $item[$this->attribute]);
        } else {
            $owner=$this->getOwner();
			$render=$owner instanceof CController ? 'renderPartial' : 'render';
            foreach($this->data as $i=>$item) {
                $data=$this->viewData;
				$data['index']=$i;
				$data['data']=$item;
				$data['widget']=$this;
                $content.=CHtml::openTag('li', array('class'=>$this->itemCssClass));
			    $owner->$render($this->itemView,$data);
                $content.=CHtml::closeTag('li');
            }
        }
        $content.=CHtml::closeTag('ul');
        $content.=CHtml::closeTag('div');
        return $content;
    }

}