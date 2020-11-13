<?php
namespace MyFramework\MVC;

class Service {

    function __construct() {
        return;
    }
    public function setService($serviceName, $object){
        #echo $serviceName.PHP_EOL;
        $this->{$serviceName} = $object;
        return;
    }

    public function getService($serviceName){
        return $this->$serviceName;
    }
}