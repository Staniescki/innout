<?php
class Model{

    protected static $tableName = '';
    protected static $colums = [];
    protected  $values = [];

    function __construct($arr, $sanitize = true){
        $this->loadFromArray($arr, $sanitize);
    }

    public function loadFromArray($arr, $sanitize = true){
        if ($arr){
            $conn = Database::getConnection();
            foreach ($arr as $key => $value){
                $cleanValue = $value;
                if ($sanitize && isset($cleanValue)){
                    $cleanValue = strip_tags(trim($cleanValue));
                    $cleanValue = htmlentities($cleanValue, ENT_NOQUOTES);
                    //$cleanValue = mysqli_real_escape_string($conn, $cleanValue);
                }
                $this->$key = $cleanValue;
            }
            $conn->close();
        }
    }

    public function __get($key){
        return isset($this->values[$key]) ? $this->values[$key] : null;
    }

    public function __set($key, $value){
        $this->values[$key] = $value;
    }

    public function getValues(){
        return $this->values;
    }

    public static function getOne($filters = [], $colums = '*'){
        $class = get_called_class();
        $result = static::getResultFromSelect($filters, $colums);

        return $result ? new $class($result->fetch_assoc()) : null;
    }

    public static function get($filters = [], $colums = '*'){
        $objects = [];
        $result = static::getResultFromSelect($filters, $colums);
        if ($result){
            $class = get_called_class();
            while ($row = $result->fetch_assoc()){
                array_push($objects, new $class($row));
            }
        }
        return $objects;
    }

    public static function getResultFromSelect($filters = [], $colums = '*'){
        $sql = "SELECT ${colums} FROM "
        . static::$tableName
        . static::getFilters($filters);
        $result = Database::getResultFromQuery($sql);
        if ($result->num_rows === 0) {
            return null;
        }else{
            return $result;
        }
    }

    public function insert() {
        $sql = "INSERT INTO " . static::$tableName . " ("
            . implode(",", static::$colums) . ") VALUES (";
        foreach (static::$colums as $col) {
            $sql .= static::getFormatedValue($this->$col) . ",";
        }
        $sql[strlen($sql) - 1] = ')';
        $id = Database::executeSQL($sql);
        $this->id = $id;
    }

    public function update(){
        $sql = "UPDATE " . static::$tableName . " SET ";
        foreach (static::$colums as $column){
            $sql .= " ${column} = " . static::getFormatedValue($this->$column) . ",";
        }
        $sql[strlen($sql) - 1] = ' ';
        $sql .= "WHERE id = {$this->id}";
        Database::executeSQL($sql);
    }

    public function delete(){
        static::deleteById($this->id);
    }

    public function deleteById($id){
        $sql = "DELETE FROM " . static::$tableName . " WHERE id = '{$id}'";
        Database::executeSQL($sql);
    }

    public static function getCount($filters = []){
        $result = static::getResultFromSelect($filters, 'count(*) as count');
        return $result->fetch_assoc()['count'];
    }

    private static function getFilters($filters){
        $sql = '';
        if (count($filters) > 0){
            $sql .= " WHERE 1 = 1";
            foreach ($filters as $column => $value){
                if ($column == 'raw'){
                    $sql .= " AND ${value}";
                }else {
                    $sql .= " AND ${column} = " . static::getFormatedValue($value);
                }
             }
        }
        return $sql;
    }

    private static function getFormatedValue($value){
        if(is_null($value)){
           return "null";
       }elseif (gettype($value) === 'string'){
            return "'${value}'";
        }else{
            return $value;
        }
    }

}
