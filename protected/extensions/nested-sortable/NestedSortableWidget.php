<?php

/** Created by griga at 20.05.2014 | 11:23.
 *
 */
class NestedSortableWidget extends CWidget
{
    public $selector;
    public $options;

    public function run()
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');
        $assetsUrl = $this->getAssetsUrl();
        $cs->registerScriptFile($assetsUrl.'/js/nested-sortable.js');
        $cs->registerCssFile($assetsUrl.'/css/nested-sortable.css');
    }

    /**
     * Get the assets path.
     * @return string
     */
    public function getAssetsPath()
    {
        return dirname(__FILE__) . '/assets';
    }

    /**
     * Publish assets and return url.
     * @return string
     */
    public function getAssetsUrl()
    {
        if (YII_DEBUG)
            return Yii::app()->assetManager->publish($this->getAssetsPath(), false, -1, true);
        else
            return Yii::app()->assetManager->publish($this->getAssetsPath());
    }


} 