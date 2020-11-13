<?php
require 'autoload.php';
#$url = isset($_SERVER['PATH_INFO']) ? explode('/', $_SERVER['PATH_INFO']) : '/';

$base_folder = explode('/public/', $_SERVER['PHP_SELF']);
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : '/';

$path = explode('/public/', $_SERVER['SCRIPT_NAME']);
if(count($path)>1){
    $path = $path[0];
} else{
    $path ='';
}
define('PROJECT_PATH', $path);

define('DS', '\\');
define('PROJECT_FOLDER', 'user-management');
define('PUBLIC_ROOT', realpath(__DIR__));
define('PROJECT_ROOT', realpath('..'.DS.PROJECT_FOLDER));
$app = new \MyFramework\MVC\App(require PROJECT_ROOT.DS.'config'.DS.'DB.php');
/*$path = explode('/public/', $_SERVER['PHP_SELF']);
if(count($path)>1){
    $path = $path[0];
} else{
    $path ='';
}
$url = $_SERVER['REDIRECT_URL'];
if($path) $url = preg_replace("/".addcslashes($path,'\/')."/",'', $url);
$url = ($url) ? explode('/', ltrim($url, '/')) : '/';*/

if ($url == '/') {
    // This is the home page, render it
    $requestedController = 'User';
    $requestedAction = 'index';
    $requestedParams = array();

} else {
    // This is not home page
// Initiate the appropriate controller and render the required view
//The first element should be a controller
    $requestedController = $url[0];
// If a second part is added in the URI,
// it should be a method
    $requestedAction = isset($url[1]) ? $url[1] : '';
// The remain parts are considered as
// arguments of the method
    $requestedParams = array_slice($url, 2);
}


// Check if controller exists. NB:
// You have to do that for the model and the view too
$controllePath = ucfirst($requestedController). DS . 'Controller'. DS .ucfirst($requestedController) . 'Controller';
$ctrlPath = PROJECT_ROOT . DS .'Modules'. DS .$controllePath. '.php';
if (file_exists($ctrlPath)) {
    #"user-management\\Modules\\$class.php"
    //will load based on routing in future
    $controllePath = preg_replace('/\//','\\',$controllePath);
    $controllerObj = new $controllePath($app, $_REQUEST, $requestedParams);
    $controllerObj->$requestedAction();
} else {
    header('HTTP/1.1 404 Not Found');
    die('404 - The file - ' . $ctrlPath . ' - not found');
    //require the 404 controller and initiate it
    //Display its view
}