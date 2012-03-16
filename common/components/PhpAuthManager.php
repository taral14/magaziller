<?php

class PhpAuthManager extends CPhpAuthManager{
    public function init(){
        // Иерархию ролей расположим в файле auth.php в директории config приложения
        if($this->authFile===null){
            $this->authFile=Yii::getPathOfAlias('common.config.auth').'.php';
        }

        parent::init();

        if(!Yii::app()->user->isGuest){
            $this->assign(Yii::app()->user->role, Yii::app()->user->id);
        }
    }
}