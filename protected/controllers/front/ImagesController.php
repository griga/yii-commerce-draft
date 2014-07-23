<?php

class ImagesController extends CController
{
    /**
     *
     */
    public function actionIndex()
    {
        $filePath = 'images/' . $_GET['model'] . '/' . $_GET['filename'];
        $file = Upload::model()->filePathFromName($filePath);
        if(file_exists($file)){
            $this->redirect('/' . $filePath);
        } else {
            throw new CHttpException(404, Yii::t('app', 'Запрашиваемая страница не существует.'));
        }
    }
}