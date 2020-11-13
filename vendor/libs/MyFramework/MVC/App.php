<?php
namespace MyFramework\MVC;

use MyFramework\DB\DB;

class App {
    protected $appService;

    function __construct($config = array()) {
        $this->appService = new Service();
        if (array_key_exists('db', $config)) {
            new DB($config['db'], $this->appService);
        }
        return;
    }

    /**
     * @return Service
     */
    public function getAppService(){
        return $this->appService;
    }
}