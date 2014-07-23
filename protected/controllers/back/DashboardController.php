<?php

/** Created by griga at 18.04.14 | 16:22.
 *
 */
class DashboardController extends BackendController
{

    public function actions()
    {
        return array(
//            'imageUpload' => array(
//                'class' => 'ext.redactor.actions.ImageUpload',
//                'uploadPath' => 'images/redactor',
//                'uploadUrl' => '/images/redactor/',
//                'uploadCreate'=>true,
//            ),
            'imageList' => array(
                'class' => 'ext.redactor.actions.ImageList',
                'uploadPath' => 'images/redactor',
                'uploadUrl' => '/images/redactor/'
            ),
        );
    }

    /**
     *
     */
    public function actionImageUpload()
    {
        $uploadPath = 'images/redactor';
        $uploadUrl = '/images/redactor/';

        $path=Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$uploadPath;
        $uploadPath=realpath($path);


        if(!is_dir($path) ){
            if (!mkdir($path,0755,true)) {
                throw new CHttpException(500,CJSON::encode(
                    array('error'=>'Could not create upload folder "'.$path.'".')
                ));
            }
        }

        // Make Yii think this is a AJAX request.
        $_SERVER['HTTP_X_REQUESTED_WITH']='XMLHttpRequest';

        $file=CUploadedFile::getInstanceByName('file');
        if ($file instanceof CUploadedFile) {

            if (!in_array(strtolower($file->getExtensionName()),array('gif','png','jpg','jpeg'))) {
                throw new CHttpException(500,CJSON::encode(
                    array('error'=>'Invalid file extension '. $file->getExtensionName().'.')
                ));
            }
            $fileName=trim(md5($path.time().uniqid(rand(),true))).'.'.$file->getExtensionName();

            $path=$uploadPath.DIRECTORY_SEPARATOR.$fileName;
            if (file_exists($path) || !$file->saveAs($path)) {
                throw new CHttpException(500,CJSON::encode(
                    array('error'=>'Could not save file or file exists: "'.$path.'".')
                ));
            }
            UploadService::createCopyToDataRoot($uploadUrl.$fileName);

            $data = array(
                'filelink'=>$uploadUrl . $fileName,
            );
            echo CJSON::encode($data);
            exit;
        } else {
            throw new CHttpException(500,CJSON::encode(
                array('error'=>'Could not upload file.')
            ));
        }
    }

    public function actionIndex()
    {

        $this->render('index');
    }

    /**
     *
     */
    public function actionDashboard()
    {
        $this->renderPartial('dashboard');
    }

}