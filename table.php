<?php
/*
 * Created by PhpStorm.
 * User: DiniX
 * Date: 27-Jun-17
 * Time: 10:05 AM
 */
abstract class table
{
    protected $id = null;
    protected $tableName = null;

    function __construct()
    {
    }


    protected function buildQuery($task)
    {
        $sql = '';
        if ($task == 'load') {
            $sql = "SELECT * from {$this->tableName} where id = '{$this->id}'";

            return $sql;
        } elseif ($task == 'insert') {
            $keys = "";
            $values = "";
            $classAttributes = get_class_vars(get_class($this));
            $sql .= "INSERT into {$this->tableName} ";
            foreach ($classAttributes as $key => $value) {
                if ($key == "tableName") {
                    continue;
                }
                $keys .= "{$key},";
                $values .= "'{$this->$key}',";
            }
            $sql .= "(" . substr($keys, 0, -1) . ") Values(" . substr($values, 0, -1) . ")";

            return $sql;
        } elseif ($task == 'update') {
            $classAttributes = get_class_vars(get_class($this));
            $sql .= "UPDATE {$this->tableName} set ";
            foreach ($classAttributes as $key => $value) {
                if ($key == "id" || $key == "tableName") {
                    continue;
                }
                $sql .= "{$key} = '{$this->$key}',";
            }
            $sql = substr($sql, 0, -1) . " where id = {$this->id}";
            return $sql;

        }
    }

    function load($dbObj, $id)
    {
        $this->id = $id;
        //$dbObj = database::getInstance();
        $sql = $this->buildQuery('load');
        $dbObj->doQuery($sql);

        if(mysqli_num_rows($dbObj->getResult())>0) {

            $rows = $dbObj->loadObjList();
            foreach ($rows as $key => $value) {
                if ($key == 'id') {
                    continue;
                }
                $this->$key = $value;

            }
            return true;
        }else{
            return false;
        }

    }

    function insert($dbObj)
    {
        //$dbObj = database::getInstance();
        $sql = $this->buildQuery('insert');
        $dbObj->doQuery($sql);
    }

    function update($dbObj)
    {
        //$dbObj = database::getInstance();
        $sql = $this->buildQuery('update');
        $dbObj->doQuery($sql);
    }

    function featuredLoad($dbObj,$sql){
        $result = mysqli_query($dbObj->getConnection(),$sql) or die("Database access failed..!!");
        return $result;
    }

    function bind($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
?>