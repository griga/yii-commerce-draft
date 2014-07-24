<?php
/**
 * Author: Yura Griga
 * Email: grigach@gmail.com
 */

require_once('Chosen.php');

/**
 * Class TbChosen
 */
class TbChosen extends Chosen
{
    public $label;
    public $labelColWidth = 2;

    public function run()
    {
        if ($this->multiple) {
            echo $this->bootstrapActiveMultiSelect($this->model, $this->attribute, $this->data, $this->htmlOptions);
        } else {
            echo $this->bootstrapActiveDropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
        }
    }


    /**
     * @param $model
     * @param $attribute
     * @param $data
     * @param array $htmlOptions
     * @return string
     */
    public function bootstrapActiveMultiSelect($model, $attribute, $data, $htmlOptions = array())
    {
        return $this->bootstrapChosenFactory('multi', $model, $attribute, $data, $htmlOptions);
    }


    /**
     * @param CModel $model
     * @param string $attribute
     * @param array $data
     * @param array $htmlOptions
     * @return string
     */
    public function bootstrapActiveDropDownList($model, $attribute, $data, $htmlOptions = array())
    {
        return $this->bootstrapChosenFactory('single', $model, $attribute, $data, $htmlOptions);
    }

    /**
     * @param string $type
     * @param CModel $model
     * @param string $attribute
     * @param array $data
     * @param array $htmlOptions
     * @return string
     */
    private function bootstrapChosenFactory($type, $model, $attribute, $data, $htmlOptions = array())
    {
        $out = '<div class="form-group ' . ($model->hasErrors($attribute) ? 'has-error' : '') . '">';
        if ($this->label) {
            $out .= CHtml::activeLabelEx($model, $attribute, array(
                'label'=>$this->label,
                'class' => 'control-label col-sm-' . $this->labelColWidth
            ));
        } else {
            $out .= CHtml::activeLabelEx($model, $attribute, array('class' => 'control-label col-sm-' . $this->labelColWidth));
        }
        $out .= '<div class="bootstrap-chosen col-sm-' . (12 - $this->labelColWidth) . '">';

        if ($type === 'single') {
            $out .= parent::activeDropDownList($model, $attribute, $data, $htmlOptions);
        } else {
            $out .= parent::activeMultiSelect($model, $attribute, $data, $htmlOptions);
        }

        $out .= CHtml::error($model, $attribute, array(
                'class' => 'label label-danger',
            )) . '</div></div>';
        return $out;
    }

}