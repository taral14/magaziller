<?php
class CAdvancedArBehavior extends CActiveRecordBehavior {

	public function afterSave($on)
	{
		foreach($this->owner->relations() as $key => $relation)
		{
            if($relation[0]!=CActiveRecord::MANY_MANY)
            {
                continue;
            }

            preg_match('#(.+)\((.+),(.+)\)#',$relation[2], $matches);
            if(count($matches)!=4)
            {
                continue;
            }

            if(!isset($this->owner->$key))
            {
                continue;
            }

            $this->saveManyMany($matches[1], $matches[2], $matches[3], $this->owner->$key);
        }
		return true;
	}

    protected function saveManyMany($table, $key1, $key2, $data) {
        $ids=array();
        foreach($data as $row) {
            $id=$row->{$row->tableSchema->primaryKey};
            Yii::app()->db->createCommand("INSERT IGNORE INTO $table($key1,$key2) values (:v1, :v2)")->execute(array(
                ':v1'=>$this->ownerKey,
                ':v2'=>$id,
            ));
            array_push($ids, $id);
        }

        if(empty($ids)) {
            Yii::app()->db->createCommand("DELETE IGNORE FROM $table WHERE $key1=:key")->execute(array(
                ':key'=>$this->ownerKey,
            ));
        } else {
            $in=implode(',',$ids);
            Yii::app()->db->createCommand("DELETE IGNORE FROM $table WHERE $key1=:key AND $key2 NOT IN($in)")->execute(array(
                ':key'=>$this->ownerKey,
            ));
        }
    }

    protected function getOwnerKey() {
        return $this->owner->{$this->owner->tableSchema->primaryKey};
    }
}