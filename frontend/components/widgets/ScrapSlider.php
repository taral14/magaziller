<?php
class ScrapSlider extends CWidget {

    public $template='{navigation}{content}{arrows}';

    public $width;
    public $height;
    public $items;

    public $auto=true;

    public function run() {
        echo CHtml::openTag('div', array(
            'id'=>$this->getId()
        ));

        if(strpos($this->template, '{content}')!==false)
            $data['{content}']=$this->renderContent();

        if(strpos($this->template, '{navigation}')!==false)
            $data['{navigation}']=$this->renderNavigation();

        if(strpos($this->template, '{arrows}')!==false)
            $data['{arrows}']=$this->renderArrows();

        echo strtr($this->template, $data);

        echo CHtml::closeTag('div');
    }

    protected function renderContent() {
        $id=$this->getId();
        $content=CHtml::openTag('div', array(
            'style'=>"width:{$this->width}px;height:{$this->height}px;overflow:hidden",
        ));
        $totalWidth=count($this->items)*$this->width;
        $content.=CHtml::openTag('ul', array(
            'class'=>'scrap-content',
            'style'=>"width:{$totalWidth}px;height:{$this->height}px;list-style:none;padding-left:0px;position:relative;"
        ));
        foreach($this->items as $item) {
            $content.=CHtml::tag('li', array(
                'class'=>'scrap-content-item',
                'style'=>"width:{$this->width}px;height:{$this->height}px;overflow:hidden;float:left;",
            ), $item->renderTemplate());
        }
        $content.='</ul>';
        $content.='</div>';
        return $content;
    }

    protected function renderArrows() {
        return 'renderArrows';
    }

    protected function renderNavigation() {
        $id=$this->getId();
        $navigation=CHtml::openTag('div', array(
            'class'=>'scrap-navigation',
        ));
        foreach($this->items as $i=>$item) {
            $navigation.=CHtml::tag('a', array(
                'class'=>'scrap-navigation-item',
                'href'=>'#',
            ), $i+1);
        }
        $navigation.='</div>';

        $cs = Yii::app()->clientScript;
       	$cs->registerCoreScript('jquery');
        $cs->registerScript(__CLASS__.'#Navigation#'.$id, "
            $('#$id a.scrap-navigation-item').click(function(){
                var index =parseInt($(this).index());
                $('#$id a.scrap-navigation-item').removeClass('active');
                $(this).addClass('active');
                $('#$id ul.scrap-content').animate({
                    left:'-'+(index*{$this->width})+'px'
                });
                return false;
            });
        ");

        if($this->auto) {
            $cs = Yii::app()->clientScript;
           	$cs->registerCoreScript('jquery');
            $cs->registerScript(__CLASS__.'#Auto#'.$id, "
                setInterval(function(){
                    if($('#$id').is(':hover')) return;

                    var el=$('.slider_buttons a.cur').next();
                    if(el.length) {
                        el.click();
                    } else {
                        $('.slider_buttons a:first').click();
                    }
                    console.debug(el);
                }, 3000);
            ");
        }

        return $navigation;
    }
}