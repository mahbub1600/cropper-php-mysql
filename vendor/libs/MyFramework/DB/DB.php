<?php
namespace MyFramework\DB;


use MyFramework\MVC\Service;

class DB {
    protected $myFrameworkApp;
    function __construct($adaptersIndex, Service $service) {
        foreach ($adaptersIndex['adapters'] as $index=>$adapterIndex) {
            if(strtolower($adapterIndex['dsn']) == 'mysql' && strtolower($adapterIndex['driver']) == 'pdo'){
                $servername = $adapterIndex['host'];
                $username = $adapterIndex['username'];
                $password = $adapterIndex['password'];
                $dbname = $adapterIndex['dbname'];
                try {
                    $conn = new \PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                    // set the PDO error mode to exception
                    $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    $service->setService($index, $conn);
                } catch (\PDOException $e) {
                    throw new \Exception($e->getMessage());
                }
            }
        }
    }
}