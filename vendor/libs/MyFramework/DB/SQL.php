<?php

namespace MyFramework\DB;


class SQL {
    protected static function getCallerModel(){
        $trace = debug_backtrace();
        // Get the file that is asking for who awoke it
        $module=null; $controller=null;
        if(count($trace)>1){
            $trace = current($trace);
            return new $trace['object'];
        }
        throw new \Exception('You must specify table name');
    }

    protected function commitPdo(){
        $publicProperties = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        $processingArray = array();
        foreach($publicProperties as $property){
            if($property->name == 'created' || $property->name == 'updated'){
                if(!($this->id && $property->name == 'created')) {
                    $this->{$property->name} = date('Y-m-d H:i:s');
                }
            }
            $processingArray[$property->name] = $this->{$property->name};
        }
        #die('<pre>'.print_r($processingArray, true));
        $primaryId = $processingArray['id'];
        unset($processingArray['id']);
        $table = get_class($this);
        $table = explode('\\', $table);
        $table = end($table);
        #echo ('<pre>'.print_r($processingArray, true));
        $processingArray = array_map(function ($value){
            if(!$value) return "NULL";
            if(gettype($value) == 'string'){
                return '"'.$value.'"';
            }
        }, $processingArray);

        if($primaryId){
            $innerSql = '';
            foreach($processingArray as $key=>$value){
                if($innerSql) $innerSql .= ", ";
                $innerSql .= "$key=$value";
            }
            //update
            $sql = "UPDATE $table SET $innerSql WHERE id=$primaryId";
        } else{
            //save
            $sql = "INSERT INTO " . $table . " (".implode(',', array_keys($processingArray)).") VALUES (".implode(',', $processingArray).")";
        }
        #die($sql);
        try{
            // use exec() because no results are returned
            $this->getDbAdapter()->exec($sql);
        } catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    protected function removePdo(){
        $publicProperties = (new \ReflectionObject($this))->getProperties(\ReflectionProperty::IS_PUBLIC);
        $processingArray = array();
        foreach($publicProperties as $property){
            $processingArray[$property->name] = $this->{$property->name};
        }
        $primaryId = $processingArray['id'];
        unset($processingArray['id']);
        $table = get_class($this);
        $table = explode('\\', $table);
        $table = end($table);
        #echo ('<pre>'.print_r($processingArray, true));
        if($primaryId){
            $innerSql = '';
            foreach($processingArray as $key=>$value){
                if($innerSql) $innerSql .= ", ";
                $innerSql .= "$key=$value";
            }
            //update
            $sql = "DELETE FROM $table WHERE id=$primaryId";
        }
        #die($sql);
        try{
            // use exec() because no results are returned
            $this->getDbAdapter()->exec($sql);
        } catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    protected static function get($dbAdapter, $id){
        #$publicProperties = (new \ReflectionObject(self::getCallerModel()))->getProperties(\ReflectionProperty::IS_PUBLIC);
        /*$processingArray = array();
        foreach($publicProperties as $property){
            $processingArray[$property->name] = $this->{$property->name};
        }*/
        $tableClass = static::class;
        if(!$id) return new $tableClass($dbAdapter);
        $table = explode('\\', $tableClass);
        $table = end($table);
        $sql = "SELECT * FROM ".$table. " WHERE id=$id";
        $sth = $dbAdapter->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_CLASS, $tableClass, array($dbAdapter));
        if(count($result)){
            return current($result);
        }
        return new $tableClass($dbAdapter);
    }
    protected static function getAll($dbAdapter){
        $tableClass = static::class;
        $table = explode('\\', $tableClass);
        $table = end($table);
        $sql = "SELECT * FROM ".$table. " WHERE 1";
        #$result = $dbAdapter->query($sql);
        $sth = $dbAdapter->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_CLASS, $tableClass, array($dbAdapter));
        return $result;
    }
}