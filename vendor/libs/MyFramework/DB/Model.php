<?php

namespace MyFramework\DB;


class Model extends SQL {
    protected $dbAdapter;
    private $vari;
    public function __construct($adapter=null) {
        $this->dbAdapter = $adapter;
        return;
    }
    protected function getDbAdapter(){
        return $this->dbAdapter;
    }

    public function commit(){
        if($this->getDbAdapter() instanceof \PDO) {
            $this->commitPdo();
        }
        return $this;
    }
    public function remove(){
        if($this->getDbAdapter() instanceof \PDO) {
            $this->removePdo();
        }
        return $this;
    }
    public function setData($dataArray=array()){
        $publicProperties = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        foreach($publicProperties as $property){
            if(array_key_exists($property->name, $dataArray)){
                $this->{$property->name} = $dataArray[$property->name];
            }
        }
        return $this;
    }
    /**
     * @param $dbAdapter
     * @param $id
     * @return bool|mixed
     */
    public static function get($dbAdapter, $id){
        if($dbAdapter instanceof \PDO) {
            return parent::get($dbAdapter, $id);
        }
        return false;
    }
    /**
     * @param $dbAdapter
     * @return bool|mixed
     */
    public static function getAll($dbAdapter){
        if($dbAdapter instanceof \PDO) {
            return parent::getAll($dbAdapter);
        }
        return false;
    }

}