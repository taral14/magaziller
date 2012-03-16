<?php
class MarketController extends Controller {

    public $layout=false;

    public function actionView($name) {
        $model=$this->loadModel($name);

        header('Content-Type: text/xml; charset=windows-1251');

        $dom=new DOMDocument('1.0', 'windows-1251');

        $yml_catalog=$dom->createElement('yml_catalog');
        $yml_catalog->setAttribute('date', date('Y-m-d H:i'));

        $shop=$dom->createElement('shop');
        $shop->appendChild($dom->createElement('name', Yii::app()->config['shop_name']));
        $shop->appendChild($dom->createElement('company', Yii::app()->config['company']));
        $shop->appendChild($dom->createElement('url', Yii::app()->request->hostInfo.Yii::app()->baseUrl));
        $shop->appendChild($dom->createElement('platform', Yii::app()->name));
        $shop->appendChild($dom->createElement('agency', 'Brainstorm'));
        $shop->appendChild($dom->createElement('email', 'info@brainstorm.com.ua'));

        $currencies=$dom->createElement('currencies');
        foreach(Currency::model()->findAll() as $currency_model) {
            $currency=$dom->createElement('currency');
            $currency->setAttribute('id', $currency_model->code);
            $currency->setAttribute('rate', round($currency_model->ratio_from/$currency_model->ratio_to, 3));
            $currencies->appendChild($currency);
        }
        $shop->appendChild($currencies);

        $categories=$dom->createElement('categories');
        foreach(Category::model()->findAll() as $category_model) {
            $category=$dom->createElement('category', $category_model->name);
            $category->setAttribute('id', $category_model->id);
            if($category_model->parent_id)
                $category->setAttribute('parentId', $category_model->parent_id);
            $categories->appendChild($category);
        }
        $shop->appendChild($categories);

        $offers=$dom->createElement('offers');
        foreach($model->products as $product_model) {
            $offer=$dom->createElement('offer');
            $offer->setAttribute('id', $product_model->id);
            $offer->setAttribute('type', 'vendor.model');
            $offer->appendChild($dom->createElement('url', Yii::app()->request->hostInfo.$product_model->url) );
            $offer->appendChild($dom->createElement('price', $product_model->price) );
            $offer->appendChild($dom->createElement('currencyId', Yii::app()->currency->basic['code']) );
            $offer->appendChild($dom->createElement('categoryId', $product_model->category_id) );
            $offer->appendChild($dom->createElement('picture', Yii::app()->request->hostInfo.$product_model->getImageUrl('large')) );
            $offer->appendChild($dom->createElement('typePrefix', $product_model->category->name) );
            if($product_model->brand)
                $offer->appendChild($dom->createElement('vendor', $product_model->brand->name) );
            $offer->appendChild($dom->createElement('model', $product_model->name) );

            switch($model->description_type) {
                case Market::TYPE_CUSTOM:
                        $offer->appendChild($dom->createElement('description', $model->description) );
                    break;
                case Market::TYPE_DESCRIPTION:
                        $offer->appendChild($dom->createElement('description', $product_model->description) );
                    break;
                case Market::TYPE_SUMMARY:
                        $offer->appendChild($dom->createElement('description', $product_model->summary) );
                    break;
            }

            $offers->appendChild($offer);
        }
        $shop->appendChild($offers);
        
        $yml_catalog->appendChild($shop);
        $dom->appendChild($yml_catalog);
        echo $dom->saveXML();
        exit;
    }

	public function loadModel($name)
	{
		$model=Market::model()->findByAttributes(array('name'=>$name));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

}