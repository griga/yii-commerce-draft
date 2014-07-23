<?php

/** Created by griga at 03.05.14 | 21:42.
 *
 */
class BackendController extends CController
{
    public $layout = '//layouts/main';

    public $breadcrumbs = array();

    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'expression' => 'app()->user->role=="admin"',
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function renderJson($data)
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        echo CJavaScript::jsonEncode($data);
        Yii::app()->end();
    }

    public function inputJson()
    {
        $request_body = file_get_contents('php://input');
        return CJSON::decode($request_body, true);
    }

} 