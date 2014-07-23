<?php

class ApiController extends BackendController
{

    private static $modelsConfig = [
        '{{seo_config}}'=>'id, key, value, value_ru, value_uk, value_en'
    ];

    /** @return CActiveRecord */
    private function getActiveRecord(){

        $modelName = $this->getModelName();
        /** @var CrudActiveRecord $model */
        $model = $modelName::model();
        if($model->hasBehavior('MultilingualBehavior')){
            return $modelName::model()->multilang();
        } else {
            return $modelName::model();
        }

    }

    private function getModelName(){
        $modelName = str_replace(' ', '', ucwords(str_replace('-', ' ', $_GET['model'])));
        return $modelName;
    }
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model= $this->getActiveRecord()->findByPk($id);
        $this->sendResponse(200, CJSON::encode(
            JSONUtil::convertModelToArray($model,
                [$this->getActiveRecord()->tableName()=>self::$modelsConfig[$this->getActiveRecord()->tableName()]]
            )));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $modelName = $this->getModelName();
        /** @var CActiveRecord $model */
        $model = new $modelName;
        $model->attributes = $this->inputJson();

        if (!$model->save()) {
            $this->sendResponse(500, CJSON::encode($model->errors));
        }

        $this->sendResponse(200, CJSON::encode(
            JSONUtil::convertModelToArray($model,
                [$this->getActiveRecord()->tableName()=>self::$modelsConfig[$this->getActiveRecord()->tableName()]]
            )));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->getActiveRecord()->findByPk($id);

        $model->attributes = $this->inputJson();

        if (!$model->save()) {
            $this->sendResponse(500, CJSON::encode($model->errors));
        }

        $this->sendResponse(200);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->getActiveRecord()->findByPk($id);

        if (!$model->delete() && count($model->getErrors())) {
            $this->sendResponse(500, CJSON::encode($model->errors));
        }

        $this->sendResponse(200);
    }

    /**
     * Lists all models.
     */
    public function actionList()
    {
        $models=$this->getActiveRecord()->findAll();
        $this->sendResponse(200, CJSON::encode(
            JSONUtil::convertModelToArray($models,
                [$this->getActiveRecord()->tableName()=>self::$modelsConfig[$this->getActiveRecord()->tableName()]]
            )));
    }



    /**
     * Send raw HTTP response
     * @param int $status HTTP status code
     * @param string $body The body of the HTTP response
     * @param string $contentType Header content-type
     * @return HTTP response
     */
    protected function sendResponse($status = 200, $body = '', $contentType = 'application/json')
    {
        // Set the status
        $statusHeader = 'HTTP/1.1 ' . $status . ' ' . $this->getStatusCodeMessage($status);
        header($statusHeader);
        // Set the content type
        header('Content-type: ' . $contentType);

        echo $body;
        Yii::app()->end();
    }

    /**
     * Return the http status message based on integer status code
     * @param int $status HTTP status code
     * @return string status message
     */
    protected function getStatusCodeMessage($status)
    {
        $codes = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',

        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

}