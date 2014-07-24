<?php

/**
 * Redactor widget image list action.
 *
 * @param string $attr Model attribute
 */

class ImageList extends CAction
{
	public $uploadPath;
	public $uploadUrl;

	public function run()
	{

		if ($this->uploadPath===null) {
			$path=Yii::app()->basePath.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads';
			$this->uploadPath=realpath($path);
			if ($this->uploadPath===false) {
				exit;
			}
		}
		if ($this->uploadUrl===null) {
			$this->uploadUrl=Yii::app()->request->baseUrl .'/uploads';
		}


		$files=CFileHelper::findFiles($this->uploadPath,array('fileTypes'=>array('gif','png','jpg','jpeg')));
		$data=array();
		if ($files) {
			foreach($files as $file) {
				$data[]=array(
					'thumb'=>$this->uploadUrl.basename($file),
					'image'=>$this->uploadUrl.basename($file),
				);
			}
		}
		echo CJSON::encode($data);
		exit;
	}
}