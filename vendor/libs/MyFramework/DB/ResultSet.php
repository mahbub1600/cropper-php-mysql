<?php
namespace MyFramework\DB;


use MyFramework\MVC\Service;

class ResultSet {
    private $resultSet;
    private $counter;
    function __construct($result) {
        $this->resultSet = $result;
    }
    public function append($row, $class, $dbAdapter){
        $rowObj = new $class($dbAdapter);
        $rowObj->setData($row);
        $this->resultSet->{$this->counter++}=$row;
    }
}