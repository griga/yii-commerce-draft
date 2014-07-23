<?php

class FrontendController extends Controller
{

    protected $_ajaxData = array();

    public $categories = array();

    protected function beforeAction($action)
    {
//        $this->categories = ProductCategory::model()->getDataForRecursiveRender();
        return parent::beforeAction($action);
    }


    public $currentCategoryId;
    public $parentCategoryIds = array();

    public function setNavCategoryIds($id)
    {
        $this->currentCategoryId = $id;
        $this->parentCategoryIds[] = $id;
        $this->setParentId($id);
    }

    private function setParentId($id)
    {
        /** @var ProductCategory $category */
        $category = ProductCategory::model()->getCategoryRawData($id);
        if ($category && $category['parent_id']) {
            $this->parentCategoryIds[] = $category['parent_id'];
            $this->setParentId($category['parent_id']);
        }
    }


    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'transparent' => true,
                'testLimit' => 0,
            ),
        );
    }



    public function loginAsId($id)
    {
        Yii::app()->user->logout();
        $identity = new AutoAuthUserIdentity('', '');
        $identity->id = $id;
        Yii::app()->user->login($identity, 3600 * 24 * 30);
    }

    public function ajaxSetJS($js)
    {
        $this->_ajaxData['js'] = $js;
    }

    public function ajaxSetError($error)
    {
        $this->_ajaxData['error'] = $error;
    }

    public function ajaxSetTitle($title)
    {
        $this->_ajaxData['title'] = $title;
    }

    public function ajaxSetHTML($html)
    {
        $this->_ajaxData['html'] = $html;
    }

    public function ajaxSetIsDialog($is_dialog)
    {
        $this->_ajaxData['is_dialog'] = $is_dialog;
    }

    public function ajaxRender()
    {
        if (!isset($this->_ajaxData['success']))
            $this->_ajaxData['success'] = '1';
        if (!isset($this->_ajaxData['is_dialog']))
            $this->_ajaxData['is_dialog'] = true;

        echo json_encode($this->_ajaxData);
        Yii::app()->end();
    }
}