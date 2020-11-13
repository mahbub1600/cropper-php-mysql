<?php
namespace Config;

class BaseConfig {
    public static function getDataUploadLocation(){
        return PROJECT_ROOT.DS.'data'.DS;
    }
}