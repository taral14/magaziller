<?php

class DumpController extends Controller
{

    protected function sql_encode($str){
        $str=str_replace(array("\t","\r","\n","\\","\"","'"),array('\t','\r','\n','\\','\"',"\'"),$str);
        return $str;
    }

    public function actionIndex() {
        $sql_struct = array();
		$command = Yii::app()->db->createCommand('SHOW TABLES')->queryAll();
        foreach($command as $row) {
            $info = Yii::app()->db->createCommand("SHOW CREATE TABLE `{$row['Tables_in_mycms']}`")->queryRow();
            $sql_struct[ $row['Tables_in_mycms'] ] = $info['Create Table'];
        }

        $dump="set names utf8;\n";

        foreach($sql_struct as $tbl_name=>$crt_str){
            $dump.="DROP TABLE IF EXISTS `".$tbl_name."`;\n";
            $dump.=$crt_str."\n";
            $dump.="LOCK TABLES `".$tbl_name."` WRITE;\n";
            Yii::app()->db->createCommand('LOCK TABLES `'.$tbl_name.'` READ')->query();
            $res=Yii::app()->db->createCommand('SELECT * FROM `'.$tbl_name.'`')->queryAll();
            $insert_str='INSERT INTO `'.$tbl_name.'` VALUES ';
            foreach($res as $item) {
                foreach($item as $k=>$v){
                    $item[$k]=$this->sql_encode($v);
                }
                $dump.=$insert_str.'("'.implode('","',(array)$item).'");'."\n";
            }
            $dump.="UNLOCK TABLES;\n";
            Yii::app()->db->createCommand('UNLOCK TABLES')->query();
        }
        file_put_contents('dump.txt', $dump);
    }

}