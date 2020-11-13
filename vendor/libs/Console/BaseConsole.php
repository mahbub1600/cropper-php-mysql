<?php
namespace Console;

use Config\UserMealConfig;

class BaseConsole {
    public static function getConsoleData($argv){
        $consoleArray = array();
        return $consoleArray;
        #throw new \Exception('Console Input Error. At least 3 option are expected except the file name');
    }
}