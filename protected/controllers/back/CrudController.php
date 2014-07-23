<?php

/** Created by griga at 20.05.2014 | 8:52.
 *
 */
abstract class CrudController extends BackendController
{

    public $model;

    public function init()
    {
        if (!isset($this->model)) {
            throw new CException('You should set $model property in ancestor controller');
        }
        parent::init();
    }

    public function render($view, $data = null, $return = false)
    {
        if (r()->isAjaxRequest || isset($_GET['ajax'])) {
            return $this->renderPartial($view, $data, false, true);
        } else {
            return parent::render($view, $data, $return);
        }
    }

    public function beforeAction($action)
    {
        if ($action->id === 'index') {
            $this->setReturnUrl(Yii::app()->request->requestUri);
        }
        return parent::beforeAction($action);
    }


    public function smartRedirect($redirectTo)
    {
        if (user()->hasState('afterUpdateReturn')) {
            $this->redirect(user()->getState('afterUpdateReturn'));
        } else {
            $this->redirect($redirectTo);
        }
    }

    public function setReturnUrl($url)
    {
        user()->setState('afterUpdateReturn', $url);
    }

    public function actionIndex()
    {
        $className = $this->model;
        $model = new $className('search');
        $model->unsetAttributes();
        if (isset($_GET[$className]))
            $model->attributes = $_GET[$className];

        $this->render('index', array(
            'model' => $model,
        ));

    }

    public function actionCreate()
    {
        $className = $this->model;
        $model = new $className();

        $this->performAjaxValidation($model);

        if (isset($_POST[$className])) {
            $model->attributes = $_POST[$className];
            if ($model->save()) {
                if (r()->isAjaxRequest) {
                    $this->renderJson(array(
                        'success' => t('Successfully created'),
                        'modelId' => $model->id,
                        'modelAttributes' => $model->attributes,
                        'close' => (isset($_POST['form_action']) && $_POST['form_action'] == 'save_and_close'),
                    ));
                } else {
                    if (isset($_POST['save_and_close'])) {
                        $this->smartRedirect('index');
                    } else {
                        $this->redirect(app()->controller->createUrl('update', array('id' => $model->id)));
                    }
                }
            } else {
                if (r()->isAjaxRequest) {
                    $this->renderJson(array(
                        'error' => $model->errors
                    ));
                }
            }
        }

        if (isset($_GET[$className]) && !isset($_POST[$className])) {
            $model->unsetAttributes();
            $model->attributes = $_GET[$className];
        }

        $this->render('form', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id)
    {
        $className = $this->model;
        $model = $this->loadModel($id, true);

        $this->performAjaxValidation($model);

        if (isset($_POST[$className])) {
            $model->attributes = $_POST[$className];
            if ($model->save()) {
                if (r()->isAjaxRequest) {
                    $this->renderJson(array(
                        'success' => t('Successfully updated'),
                        'modelId' => $model->id,
                        'modelAttributes' => $model->attributes,
                        'close' => (isset($_POST['form_action']) && $_POST['form_action'] == 'save_and_close'),
                    ));
                } else {
                    if (isset($_POST['save_and_close'])) {
                        $this->smartRedirect('index');
                    } else {
                        $this->redirect(app()->controller->createUrl('update', array('id' => $model->id)));
                    }
                }
            }
        }

        $this->render('form', array(
            'model' => $model,
        ));

    }


    /**
     * @param $id
     * @param boolean $ml indicates if need load multilingual model
     * @return CrudActiveRecord
     * @throws CHttpException
     */
    public function loadModel($id, $ml = false)
    {
        /** @var CrudActiveRecord $activeRecord */
        $activeRecord = CActiveRecord::model($this->model);
        if ($ml && $activeRecord->hasBehavior('MultilingualBehavior')) {
            $model = $activeRecord->multilang()->findByPk($id);
//            $model->afterMultilang();
        } else {
            $model = $activeRecord->findByPk($id);
        }

        if ($model === null)
            throw new CHttpException(404, Yii::t('app', 'Запрашиваемая страница не существует.'));
        return $model;
    }


    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === uncamelize($this->model, '-') . '-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     *
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if ($model->delete()) {
            if (!r()->isAjaxRequest) {
                $this->smartRedirect(isset($_POST['redirect']) ? [$_POST['redirect']] : ['index']);
            }
        }
        app()->end();
    }

    /**
     *
     */
    public function actionToggle()
    {
        $tableName = CActiveRecord::model($this->model)->tableName();
        db()->createCommand()->update($tableName, [
            'enabled' => ($_POST['value'] == 'true' ? 1 : 0)
        ], 'id=:id', [':id' => $_POST['id']]);
        app()->end();
    }
} 