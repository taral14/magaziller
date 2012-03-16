<?php
class SitemapController extends Controller {
    public $layout=false;
    public $dom;

    public function init() {
        header('Content-Type: text/xml; charset=UTF-8');
        $this->dom=new DOMDocument('1.0', 'UTF-8');

        parent::init();
    }

    protected function createUrlElement($loc, $lastmod, $changefreq='monthly', $priority=0.5) {
        $url=$this->dom->createElement('url');
        $url->appendChild($this->dom->createElement('loc', $loc));
        $url->appendChild($this->dom->createElement('lastmod', $lastmod));
        $url->appendChild($this->dom->createElement('changefreq', $changefreq));
        $url->appendChild($this->dom->createElement('priority', $priority));
        return $url;
    }

    public function actionIndex() {
        $hostInfo=Yii::app()->request->getHostInfo();

        $urlset=$this->dom->createElement('urlset');
        $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        $urlset->appendChild($this->createUrlElement($hostInfo.Yii::app()->createUrl('site/index'), date('Y-m-d H:i:s'), 'monthly', 0.9));
        $urlset->appendChild($this->createUrlElement($hostInfo.Yii::app()->createUrl('site/contact'), date('Y-m-d H:i:s'), 'monthly', 0.9));

        foreach(Product::model()->findAll() as $product) {
            $url=$this->createUrlElement(
                $hostInfo.$product->url,
                date('Y-m-d H:i:s', $product->update_time),
                'daily',
                round(0.6+$product->priority/125, 2)
            );
            $urlset->appendChild($url);
        }

        foreach(Article::model()->findAll() as $article)
            $urlset->appendChild($this->createUrlElement($hostInfo.$article->url, date('Y-m-d H:i:s', $article->update_time)));

        foreach(News::model()->findAll() as $news_item)
            $urlset->appendChild($this->createUrlElement($hostInfo.$news_item->url, date('Y-m-d H:i:s', $news_item->update_time)));

        foreach(Promotion::model()->findAll() as $promotion)
            $urlset->appendChild($this->createUrlElement($hostInfo.$promotion->url, date('Y-m-d H:i:s', $promotion->update_time)));

        foreach(Category::model()->findAll() as $category)
            $urlset->appendChild($this->createUrlElement($hostInfo.$category->url, date('Y-m-d H:i:s', $category->update_time)));

        foreach(Gallery::model()->findAll() as $gallery)
            $urlset->appendChild($this->createUrlElement($hostInfo.$gallery->url, date('Y-m-d H:i:s', $gallery->update_time)));

        $this->dom->appendChild($urlset);
        echo $this->dom->saveXML();
        exit();
    }
}
