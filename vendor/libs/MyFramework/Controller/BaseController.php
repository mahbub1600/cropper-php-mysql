<?php

namespace MyFramework\Controller;

use MyFramework\Http\Request;
use MyFramework\MVC\App;

class BaseController
{
    protected $params=array();
    protected $request;
    protected $sm;

    function __construct(App $app, $request, $params=null){
        $this->myFrameworkApp = $app;
        $this->sm = $app->getAppService();
        $this->request= new Request($request);
        $this->params= $params;
        return;
    }
    protected function getParam(){
        if(!$this->params) return array();
        return $this->params;
    }
    protected function redirect($location){
        header('Location: '.PROJECT_PATH.$location);
        return $this;
    }
    /**
     * @return Request
     */
    protected function getRequest(){
        return $this->request;
    }
}