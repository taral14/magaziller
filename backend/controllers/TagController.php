<?php
class TagController extends Controller {

    public function actionAutoComplete($term) {
        $criteria=new CDbCriteria;

        if(strpos($term, ',')===false) {
            $criteria->addSearchCondition('t.name', $term);
        } else {
            $terms=array_map("trim", explode(',',$term));
            $criteria->addSearchCondition('t.name', array_pop($terms));
            if(count($terms))
                $criteria->addNotInCondition('t.name', $terms);
        }

        $criteria->limit=10;

        $rows=Tag::model()->findAll($criteria);
        $array=array();
        foreach($rows as $row) {
            array_push($array, array(
                'id'=>$row->id,
                'value'=>$row->name,
                'label'=>$row->name,
            ));
        }
        echo function_exists('json_encode')?json_encode($array):CJSON::encode($array);
        Yii::app()->end();
    }
}