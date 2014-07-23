<?php
/** Created by griga at 11.11.13 | 19:06.
 * 
 */

class CatalogController extends FrontendController {

    public $layout = "catalog";

    public function actionCategory($alias, $id)
    {

        /** @var ProductCategory $category */
        $category = ProductCategory::model()->multilang()->with(['children', 'parent'])->findByPk($id);

        if(!$category)
            throw new CHttpException(404, 'Страница не найдена');

        $this->pageTitle = app()->name . ' - ' . $category->name;
        $model=new Product('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Product']))
            $model->attributes=$_GET['Product'];
        $model->category_id = $category->id;

        if($model->pageSize)
            r()->cookies['catalogPageSize'] = new CHttpCookie('catalogPageSize', $model->pageSize);
        else
            $model->pageSize = (string)r()->cookies['catalogPageSize'] ?: Config::get('categoryPageSize');

        if (!r()->isAjaxRequest) {
            $this->render('category', array(
                'category' => $category,
                'model'=>$model,
            ));
        } else {
            $this->renderPartial('category', array(
                'category' => $category,
                'model'=>$model,
            ), false, true );
        }
    }

    /**
     *
     */
    public function actionProduct($alias, $id)
    {
        /** @var Product $product */
        $model = Product::model()->multilang()->findByPk($id);
        if(!$model)
            throw new CHttpException(404, "Page not found");

        if ( isset(app()->session['viewedProducts']) ){
            $viewed = app()->session['viewedProducts'];
            if(($key = array_search($model->id, $viewed)) !== false) {
                unset($viewed[$key]);
            }
            app()->session['viewedProducts'] = array_merge($viewed, array($model->id)) ;
        } else {
            app()->session['viewedProducts'] = array($model->id);

        }

        $this->render('product', array(
        	'model' => $model,
        ));

    }

}