<?php
class AnalyticController extends Controller {

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column1';

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
			array('allow', 'roles'=>array('content', 'manager')),
			array('deny', 'users'=>array('*')),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
    public function actionIndex() {
        $bestSellingProducts=Yii::app()->db->createCommand()
            ->select('p.name,SUM(op.quantity) as quantity,p.id,p.price')
            ->from('{{product}} as p')
            ->join('{{order_product}} as op', 'op.product_id=p.id')
            ->group('p.id')
            ->limit(10)
            ->queryAll();

        $quantityOrderThisMonth=array();
        $query=Yii::app()->db->createCommand()
            ->select('COUNT(*) as quantity, DAYOFMONTH(t.create_time) as day, MONTH(t.create_time) as month, YEAR(t.create_time) as year')
            ->from('{{order}} as t')
            ->group('DATE_FORMAT(t.create_time, "%c-%e-%Y")')
            ->order('DATE_FORMAT(t.create_time, "%c-%e-%Y")')
            ->where('t.create_time>=:date_from', array(':date_from'=>date('Y-m-d', time()-30.4375*60*60*24)))
            ->queryAll();
        foreach($query as $row) {
            array_push($quantityOrderThisMonth, array('js:Date.UTC('.$row['year'].','.$row['month'].','.$row['day'].')', 'js:'.$row['quantity']));
        }
        $quantityOrderLastMonth=array();
        $query=Yii::app()->db->createCommand()
            ->select('COUNT(*) as quantity, DAYOFMONTH(t.create_time) as day, MONTH(t.create_time) as month, YEAR(t.create_time) as year')
            ->from('{{order}} as t')
            ->group('DATE_FORMAT(t.create_time, "%c-%e-%Y")')
            ->order('DATE_FORMAT(t.create_time, "%c-%e-%Y")')
            ->where('t.create_time>=:date_from AND t.create_time<=:date_to', array(
                ':date_from'=>date('Y-m-d', time()-30.4375*60*60*24*2),
                ':date_to'=>date('Y-m-d', time()-30.4375*60*60*24)
            ))
            ->queryAll();
        foreach($query as $row) {
            array_push($quantityOrderLastMonth, array('js:Date.UTC('.$row['year'].','.$row['month'].','.$row['day'].')', 'js:'.$row['quantity']));
        }

        $bestSearchings=Yii::app()->db->createCommand()
            ->select('COUNT(search_terms) as count, search_terms')
            ->from('{{order}} as o')
            ->group('search_terms')
            ->order('COUNT(search_terms) DESC')
            ->where("search_terms!='' AND search_terms IS NOT NULL")
            ->limit(10)
            ->queryAll();

        $bestReferers=Yii::app()->db->createCommand()
            ->select('COUNT(referer) as count, referer')
            ->from('{{order}} as o')
            ->group('referer')
            ->order('COUNT(referer) DESC')
            ->where("referer!='' AND referer IS NOT NULL")
            ->limit(10)
            ->queryAll();

        $this->render('index', array(
            'bestSellingProducts'=>$bestSellingProducts,
            'quantityOrderThisMonth'=>$quantityOrderThisMonth,
            'quantityOrderLastMonth'=>$quantityOrderLastMonth,
            'bestSearchings'=>$bestSearchings,
            'bestReferers'=>$bestReferers,
        ));
    }
}
