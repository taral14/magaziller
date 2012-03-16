<?php
class TemplateVarRender extends CComponent {

    public function render($content, $data=array()) {
        echo $this->renderTemplate($content, $data);
    }


    protected function renderTemplate($content, $data) {
        /*preg_match_all('#{\$(.+?)(?:\.(.+?))?}#', $content, $matches, PREG_SET_ORDER);
        foreach($matches as $match) {
            if(array_key_exists($match[1], $data)==false)
                continue;

            $key=$match[1];
            $template=isset($match[2])?$match[2]:false;

            $content=strtr($content, array(
                $match[0]=>$this->renderValue($data[$key], $template)
            ));
        }
        print_r($matches);*/

        return $content;
    }

    public function renderValue($val, $data) {
        /*if(strstr($val, '.')) {
            return '['.$val.']';
        } else {
            //return array_key_exists($val, $data)?$data[$val]:'';
        }*/
        return '';
    }
}