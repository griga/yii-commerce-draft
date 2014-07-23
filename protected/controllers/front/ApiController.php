<?php

/** Created by griga at 19.06.2014 | 14:12.
 *
 */
class ApiController extends CController
{

    public function renderJson($data)
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        echo CJavaScript::jsonEncode($data);
        Yii::app()->end();
    }


    public function actionSlide()
    {
        if (isset($_GET['id'])) {
            $model = Slide::model()->enabled()->localized()->findByPk($_GET['id']);
            $this->renderJson($model->frontApiAttributes);
        } else {
            $data = array();
            foreach (Slide::model()->enabled()->localized()->findAll() as $model)
                $data[] = $model->frontApiAttributes;
            $this->renderJson($data);
        }
    }

    public function actionBrand()
    {
        if (isset($_GET['alias'])) {
            $brand = DataSrv::getBrand($_GET['alias']);
            $this->renderJson($brand);
        } else {
            $brands = DataSrv::getBrands();

            $this->renderJson($brands);
        }


    }

    public function actionProduct()
    {
        if (isset($_GET['alias'])) {

            $this->renderJson(DataSrv::getProduct($_GET['alias']));
        }
    }

    public function actionSearch(){
        if(isset($_GET['term']) && strlen($_GET['term'])>1){
            $term = $_GET['term'];
            $criteria= new CDbCriteria();
            $criteria->addSearchCondition('i18nProduct.l_content',$term, true,'OR');
            $criteria->addSearchCondition('i18nProduct.l_short_content',$term, true,'OR');
            $criteria->addSearchCondition('i18nProduct.l_name',$term, true,'OR');
            $products = Product::model()->localized()->with(['manufacturer','defaultUpload'])->findAll($criteria);

            $result = [];

            foreach($products as $product){
                $result[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'alias' => $product->alias,
                    'price' => $product->price,
                    'manufacturer_id' => $product->manufacturer_id,
                    'featured' => $product->featured,
                    'short_content' => $product->short_content,
                    'content' => $product->content,
                    'image' => $product->defaultUpload->filename,
                    'brand'=> [
                        'id'=>$product->manufacturer->id,
                        'name'=>$product->manufacturer->name,
                        'alias'=>$product->manufacturer->alias,
                    ]
                ];
            }

            $this->renderJson($result);
        }
    }

    public function actionPage()
    {
        if (isset($_GET['alias'])) {
            $this->renderJson(DataSrv::getPage($_GET['alias']));
        }
    }
} 