<?php
/** Created by griga at 21.06.2014 | 17:19.
 * 
 */

class ContentController extends FrontendController {
    /**
     *
     */
    public function actionPage($alias)
    {
        /** @var Page $model */
        $model = $this->loadModel('Page', $alias);
        $this->pageTitle = $model->name;
        $this->render('page', [
            'model'=>$model
        ]);
    }

    /**
     * @param $modelClass
     * @param $id
     * @param boolean $ml indicates if need load multilingual model
     * @return CrudActiveRecord
     * @throws CHttpException
     */
    public function loadModel($modelClass, $id, $ml = true)
    {
        /** @var CrudActiveRecord $activeRecord */
        $activeRecord = CActiveRecord::model($modelClass);
        if ($ml && $activeRecord->hasBehavior('MultilingualBehavior')) {
            $model = $activeRecord->multilang()->find('id=:id OR alias=:alias', [
                ':id'=>$id,
                ':alias'=>$id
            ]);
            if($model)
                $model->afterMultilang();
        } else {
            $model = $activeRecord->find('id=:id OR alias=:alias', [
                ':id'=>$id,
                ':alias'=>$id,
            ]);
        }

        if ($model === null)
            throw new CHttpException(404, t('The requested page could not be found.'));
        return $model;
    }
}