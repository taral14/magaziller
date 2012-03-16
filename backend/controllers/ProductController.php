<?php

class ProductController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', 'roles'=>array('content')),
			array('deny', 'users'=>array('*')),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Product;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];

			if($model->save()) {
                Yii::app()->user->setFlash('success', "Товар добавлен");
				$this->redirect(array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Товар не добавлен");
            }
		}
        else if(isset($_GET['Product']))
        {
            $model->attributes=$_GET['Product'];
        }

		$this->render('create',array(
			'model'=>$model,
		));
	}

    public function actionCopy($id) {
        $model=$this->loadModel($id);
        $copy=new Product;
        $copy->attributes=$model->attributes;
        foreach($model->features as $feature) {
            $copy->{$feature->attribute}=$feature->value;
        }
        $copy->image=null;
        $name=$model->name.' [копия]';
        while(Product::model()->find('name=?', array($name))!=null) {
            $name.=' [копия]';
        }
        $copy->name = $name;

        if($copy->save()) {
            Yii::app()->user->setFlash('success', "Товар успешно скопирован");
            $this->redirect(array('update','id'=>$copy->id));
        } else {
            Yii::app()->user->setFlash('error', "Товар не удалось скопировать");
            $this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('update','id'=>$model->id));
        }
    }

    public function actionAddVariation($id) {
        $model=$this->loadModel($id);

        $variation=new Product;
        $variation->original_id=$model->id;
        $variation->category_id=$model->category_id;
        $variation->brand_id=$model->brand_id;
        $variation->name=$model->name;
        $variation->price=$model->price;
        $variation->status=Product::STATUS_ENABLED;
        $variation->save(false);

        Yii::app()->user->setFlash('success', "Вариация товара &quot;$model->name&quot; добавлена");
        $this->redirect(array('update','id'=>$variation->id));
    }


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];

			if($model->save()) {
                Yii::app()->user->setFlash('success', "Изменения сохранены");
				$this->redirect(array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Изменения не сохранены");
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    public function actionAutoComplete($term) {
        $criteria=new CDbCriteria;
        $criteria->with=array('category', 'brand');
        if(strpos($term, ',')===false) {
            $criteria->addSearchCondition('t.name', $term);
        } else {
            $terms=array_map("trim", explode(',',$term));
            $criteria->addSearchCondition('t.name', array_pop($terms));
            if(count($terms))
                $criteria->addNotInCondition('t.name', $terms);
        }

        if(array_key_exists('price_list_id',$_GET)) {
            $criteria->addCondition('t.id NOT IN(SELECT product_id FROM {{price_list_row}} WHERE price_list_id=:plid AND product_id!=0 AND product_id IS NOT NULL)');
            $criteria->params[':plid']=$_GET['price_list_id'];
        }

        if(array_key_exists('limit',$_GET))
            $criteria->limit=max(1,$_GET['limit']);
        else
            $criteria->limit=5;

        if(array_key_exists('without',$_GET))
            $criteria->compare('t.id', '<>'.$_GET['without']);

        $products=Product::model()->findAll($criteria);
        $json=array();
        foreach($products as $product) {
            array_push($json, array(
                'id'=>$product->id,
                'value'=>$product->name,
                'label'=>$product->brand->name . ' ' . $product->name,
                'icon'=>$product->getImageUrl('thumb'),
                'category'=>$product->category->name,
            ));
        }
        echo function_exists('json_encode')?json_encode($json):CJSON::encode($json);
        Yii::app()->end();
    }

    public function actionFeatures($category_id) {
		$this->layout=false;
        $category=Category::model()->findByPk($category_id);

		if($category===null)
			throw new CHttpException(404,'The requested page does not exist.');

        $this->render('_features',array(
			'features'=>$category->features,
		));
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model=$this->loadModel($id);
            Yii::app()->user->setFlash('success', "Товар &quot;{$model->name}&quot; удален");
            $model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$model->attributes=$_GET['Product'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$model->attributes=$_GET['Product'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionBindToPricelist($product_id, $price_list_id, $pricelist_id=null) {
        Pricelist::model()->updateAll(array('product_id'=>null), 'product_id=:pid AND price_list_id=:sid', array(':pid'=>$product_id, ':sid'=>$price_list_id));
        if($pricelist_id)
            Pricelist::model()->updateByPk($pricelist_id, array('product_id'=>$product_id));
        Yii::app()->end();
    }

    public function actionDeleteImage($image_id) {
		$model=ProductImage::model()->findByPk((int)$image_id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');

        $model->delete();
        Yii::app()->end();
    }

    public function actionSaveImage() {
		if(isset($_POST['Image_id']))
        {
            $images=ProductImage::model()->findAllByAttributes(array('id'=>$_POST['Image_id']));
            foreach($images as $image) {
                if(isset($_POST['Image'][$image->id]))
                    $image->attributes=$_POST['Image'][$image->id];
                $image->position=array_search($image->id, $_POST['Image_id']);
                $image->save();
            }
            Yii::app()->end();
		}
        else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionUploadImage($id) {
        $this->layout=false;
        $product=$this->loadModel($id);
        $image=new ProductImage;
        $product->addImage($image);

        $this->renderPartial('_image_view', array(
            'model'=>$image,
        ));
        die;
    }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Product::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
