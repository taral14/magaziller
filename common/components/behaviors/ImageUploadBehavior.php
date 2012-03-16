<?php

class ImageUploadBehavior extends CActiveRecordBehavior {

	public $fileAttribute;
	public $nameAttribute;

    private $_images;
    private $oldFileName;
    private $imageFile;

    public function setImages(array $images) {
        $this->_images=is_array(reset($images))?$images:array('default'=>$images);
    }

    public function getImages() {
        return $this->_images;
    }

    public function afterFind($event) {
        $this->oldFileName=$this->getOwner()->{$this->fileAttribute};
    }

    public function setImageFile(CUploadedFile $imageFile) {
        $this->imageFile=$imageFile;
    }

	private function safeFileName($name, $extensionName) {
		return date('dMY_H-i-s').Yii::app()->translitFormatter->formatFileName($name).'.'.$extensionName;
	}

    protected function getFileName() {
        return $this->getOwner()->{$this->fileAttribute};
    }

    protected function getBasePath() {
        return Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;
    }

	public function beforeSave($event) {
		if(!$this->fileAttribute)
			throw new CException('"fileAttribute" должен быть установлен');

		if(!$this->images)
			throw new CException('"images" должен быть установлен');

        if($this->imageFile===null)
		    $this->imageFile = CUploadedFile::getInstance($this->getOwner(), $this->fileAttribute);

		if($this->imageFile===null) {
            unset($this->getOwner()->{$this->fileAttribute});
            return;
        }

        $this->getOwner()->{$this->fileAttribute}=$this->safeFileName(
            ($this->nameAttribute)?$this->getOwner()->{$this->nameAttribute}:$this->imageFile->name,
            $this->imageFile->extensionName
        );

        if(!$this->getOwner()->isNewRecord && $this->oldFileName)
            $this->deleteImages();

	    foreach($this->images as $options){
		    if(!is_array($options))
			    throw new CException('Конфигурацией изображения должен быть массив');

            if(empty($options[0]))
			    throw new CException('Папка для загрузки не установлена');

            if(isset($options['resize']) && $options['resize']==false) {
                $this->modifyImage($options[0], null, null, array_slice($options,1));
            } else {
                if(count($options)<3)
			        throw new CException('Параметры изображения установлены неправильно');

                list($folder, $width, $height)=$options;
                $this->modifyImage($folder, $width, $height, array_slice($options,3));
            }
		}
	}

	private function modifyImage($folder, $width, $height, $options) {
        if ( !file_exists( dirname($this->basePath.$folder) ) ) {
            mkdir(dirname($this->basePath.$folder), 0775, true);
        }
        $image=Yii::app()->image->load($this->imageFile->tempName);

        isset($options['resize']) or $options['resize']='normal';

        switch($options['resize']) {
            case 'fill':
                $image->resize($width, $height, Image::INVERSE)->crop($width, $height);
                break;
            case 'normal':
                $image->resize($width, $height, Image::AUTO);
                break;
            case 'width':
                $image->resize($width, $height, Image::WIDTH);
                break;
            case 'height':
                $image->resize($width, $height, Image::HEIGHT);
                break;
        }

        if(isset($options['quality']))
            $image->quality($options['quality']);

        if(!empty($options['watermark'])) {
            if(!is_array($options['watermark']))
                $options['watermark']=array($options['watermark']);

            list($watermarkFileName, $offsetX, $offsetY)=$options['watermark'];

            if(strpos($watermarkFileName, '/')===false) {
                $watermarkPath=$this->basePath.$folder.DIRECTORY_SEPARATOR.$watermarkFileName;
            } else {
                $watermarkPath=$this->basePath.DIRECTORY_SEPARATOR.$watermarkFileName;
            }

            if(!file_exists($watermarkPath))
                throw new CException('Файл водяного знака отсутсвует');

            $watermark=Yii::app()->image->load($watermarkPath);

            isset($options['watermark']['opacity']) or $options['watermark']['opacity']=100;

            $image->watermark($watermark, $offsetX, $offsetY, $options['watermark']['opacity']);
        }

        $prefix=isset($options['prefix'])?$options['prefix']:'';
        $image->save($this->basePath.$folder.DIRECTORY_SEPARATOR.$prefix.$this->fileName);
	}

	public function getImageUrl($image = 'default'){
        if(array_key_exists($image, $this->images)==false)
            throw new CException('Параметры "'.$image.'" изображения отсутствуют');

        $options=$this->images[$image];

        if(empty($options[0]))
			throw new CException('Папка для загрузки не установлена');

        $folder=$options[0];
        $prefix=isset($options['prefix'])?$options['prefix']:'';
        $imagePath=$this->basePath.$folder.DIRECTORY_SEPARATOR.$prefix.$this->fileName;
        $imageUrl='';
        if($this->fileName && file_exists($imagePath))
        {
            $imageUrl=Yii::app()->baseUrl.'/'.$folder.'/'.$prefix.$this->fileName;
        }
        elseif(isset($options['required']))
        {
            $required=$options['required'];

            if(strpos($required, '/')===false) {
                $imageUrl=Yii::app()->baseUrl.'/'.$folder.'/'.$required;
            } else {
                $imageUrl=Yii::app()->baseUrl.'/'.$required;
            }
        }
        return $imageUrl;
	}

	public function beforeDelete($event){
        if($this->oldFileName) {
		    $this->deleteImages();
        }
	}

	public function deleteImages() {
		foreach($this->images as $options) {
            $prefix=isset($options['prefix'])?$options['prefix']:'';
            $path=$this->basePath.$options[0].DIRECTORY_SEPARATOR.$prefix.$this->oldFileName;
			if(file_exists($path)) unlink($path);
		}
	}
}