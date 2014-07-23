<?php

/** Created by griga at 18.04.14 | 16:23.
 *
 */
class SiteController extends FrontendController
{

    public $brands = array();

    protected function beforeAction($action)
    {
        $this->brands = DataSrv::getBrands();
        return parent::beforeAction($action);
    }


    /**
     *
     */
    public function actionIndex()
    {
        app()->seo->registerSeo();
        $this->render('index');
    }

    public function actionBrand($alias)
    {
        $brand = DataSrv::getBrand($alias);
        $this->render('//templates/_brand', [
            'brand' => $brand
        ]);
    }

    public function actionProduct($alias)
    {
        app()->seo->registerSeo(Product::model()->find('alias=:alias',[':alias'=>$alias]));
        $product = DataSrv::getProduct($alias);
        $this->render('//templates/_product', [
            'product' => $product
        ]);
    }

    public function actionPage($alias)
    {
        $page = DataSrv::getPage($alias);
        $this->render('//templates/_page', [
            'page' => $page
        ]);
    }

    /**
     *
     */
    public function actionError()
    {

        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->layout = "//layouts/catalog";
                $this->render('error', $error);
            }

        }
    }

}