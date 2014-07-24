<?php

/**
 * Redactor widget image upload action.
 *
 * @param string $attr Model attribute
 * @throws CHttpException
 */

class ImageUpload extends CAction
{
	public $uploadPath;
	public $uploadUrl;
	public $uploadCreate=false;
	public $permissions=0774;

	public function run()
	{
		if ($this->uploadPath===null) {
			$path=Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads';
			$this->uploadPath=realpath($path);
		} else {
            $path=Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.$this->uploadPath;
            $this->uploadPath=realpath($path);
        }
        if ($this->uploadPath===false && $this->uploadCreate===true) {
            if (!mkdir($path,$this->permissions,true)) {
                throw new CHttpException(500,CJSON::encode(
                    array('error'=>'Could not create upload folder "'.$path.'".')
                ));
            }
        }
		if ($this->uploadUrl===null) {
			$this->uploadUrl=Yii::app()->request->baseUrl .'/uploads';
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

			$path=$this->uploadPath.DIRECTORY_SEPARATOR.$fileName;
			if (file_exists($path) || !$file->saveAs($path)) {
				throw new CHttpException(500,CJSON::encode(
					array('error'=>'Could not save file or file exists: "'.$path.'".')
				));
			}
			$data = array(
				'filelink'=>$this->uploadUrl . $fileName,
			);
			echo CJSON::encode($data);
			exit;
		} else {
			throw new CHttpException(500,CJSON::encode(
				array('error'=>'Could not upload file.')
			));
		}
	}
}