<?php
/** Created by griga at 14.07.2014 | 14:42.
 * 
 */

class SearchController extends FrontendController{

    /**
     *
     */
    public function actionIndex()
    {
        if(isset($_GET['term']) && strlen($_GET['term'])>1){
            $term = $_GET['term'];
            $criteria= new CDbCriteria();
            $criteria->addSearchCondition('i18nProduct.l_content',$term, true,'OR');
            $criteria->addSearchCondition('i18nProduct.l_short_content',$term, true,'OR');
            $criteria->addSearchCondition('i18nProduct.l_name',$term, true,'OR');
            $products = Product::model()->localized()->with(['manufacturer','defaultUpload'])->findAll($criteria);

            var_dump(count($products));
        }

    }
} 