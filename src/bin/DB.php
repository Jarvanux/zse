<?php

/*
 * @author = Starlly Software - https://starlly.com.
 * @licence = GNU
 * @description = Este archivo es propiedad de Deplyn Framework (https://deplyn.com) 
 * recuerda que para usarlo debes incluir en tu proyecto la licencia del framework.
 */

class DB {

    private $cogs;
    private $table;
    private $wheres;
    private $others;
    private $action;
    private $sql;
    private $query;
    public static $con;

    const NULLED = "NULLED";

    public function __construct($table = null) {
        $this->table = (isset($table)) ? $table : "";
        if (DB::$con == null) {
            $this->init($table);
        }
    }

    public function init($table = null) {
        $this->cogs = require PATH_CONFIG . 'database.php';
        $this->sql = "";
        $this->others = "";
        $this->table = (isset($table)) ? $table : "";
        $this->wheres = "";
        $this->action = "";
        $connection = $this->cogs["connections"][$this->cogs["default"]];
        $DB_TYPE = $connection["driver"];
        $DB_HOST = $connection["host"];
        $DB_NAME = $connection["database"];
        $DB_PORT = $connection["port"];
        $DB_USER = $connection["username"];
        $DB_PASS = $connection["password"];
        $array = [];
        if (!defined("STDIN")) {
            $array = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");
        }
        DB::$con = new PDO($DB_TYPE . ':host=' . $DB_HOST . ":" . $DB_PORT
                . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASS, $array);
        DB::$con->setAttribute(PDO::ATTR_PERSISTENT, true);
    }

    public static $db;

    /**
     *
     * @param type $table
     * @return DB $this
     */
    public static function table($table) {
        if (self::$db == null) {
            self::$db = new DB();
        }
        $db = self::$db;
        $db->sql = "";
        $db->table = $table;
        return $db;
    }

    /**
     *
     * @param ...string $params
     * @return DB $this
     */
    public function select(...$params) {
        if (empty($this->table)) {
            //Haga la consulta directamente...
            $this->sql = $params[0];
            $this->wheres = "";
        } else {
            //Agregue los parámetros que se van a seleccionar a la consulta.
            $this->sql .= "SELECT ";
            $max = count($params);
            for ($i = 0; $i < $max; $i++) {
                $param = $params[$i];
                $this->sql .= "$param" . (($i < ($max - 1)) ? ", " : " ");
            }
            $this->sql .= "FROM " . $this->table . " ";
        }
        return $this;
    }

    /**
     * INNER JOIN $tablereference ON $field $condition $field2.
     * @param type $tablereference
     * @param type $field
     * @param type $condition
     * @param type $field2
     */
    public function join($tablereference, $field, $condition, $field2) {
        $this->wheres .= " INNER JOIN $tablereference ON $field $condition $field2 ";
        return $this;
    }

    public function isNull($key) {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " OR " : " WHERE ";
        $this->wheres .= "$key is NULL";
        return $this;
    }

    public function isNotNull($key) {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " OR " : " WHERE ";
        $this->wheres .= "$key is NOT NULL";
        return $this;
    }

    public function where($key, $condition, $value) {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " AND " : " WHERE ";
        $this->wheres .= "$key $condition " . ((is_string($value)) ? "\"$value\"" : $value) . " ";
        return $this;
    }

    /**
     *
     * @param type $key
     * @param type $value1
     * @param type $value2
     * @return $this
     */
    public function between($key, $value1, $value2) {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " AND " : " WHERE ";
        $this->wheres .= "$key BETWEEN \"$value1\" AND \"$value2\" ";
        return $this;
    }

    /**
     *
     * @param type $key
     * @param type $value
     * @return $this
     */
    public function like($key, $value) {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " AND " : " WHERE ";
        $this->wheres .= "$key LIKE \"$value1\" ";
        return $this;
    }

    /** @example $wheres = ["key_name_db = 1", "key_name_db2 = 2","OR" => ["key_name = 1","key_name2 < 3"]]; */
    public function wheres($wheres) {
        foreach ($wheres as $key => $value) {
            if ($key == "OR") {
                $this->wheres .= (strpos($this->wheres, "WHERE")) ? " OR " : " WHERE ";
                foreach ($wrs as $query) {
                    $this->wheres .= " $query ";
                }
            } else {
                $this->wheres .= (strpos($this->wheres, "WHERE")) ? " AND " : " WHERE ";
                $this->wheres .= " $value ";
            }
        }
    }

    public function orWhere($key, $condition, $value) {
        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " OR " : " WHERE ";
        $this->wheres .= "$key $condition \"$value\" ";
        return $this;
    }

    public function limit($limit = 0, $limit2 = 0) {
        $this->others .= " LIMIT $limit" . (($limit2 > 0) ? ", $limit2" : "");
        return $this;
    }

    public function orderBy($key, $order) {
        $this->others .= " ORDER BY `$key` $order";
        return $this;
    }

    public function groupBy($key) {
        $this->others .= " GROUP BY `$key` ";
        return $this;
    }

    public function get($fech = null) {
        try {
            if ($this->sql == "") {
                $this->sql = "SELECT * FROM $this->table";
            }
            $this->sql .= " " . $this->wheres;
            $this->sql .= " " . $this->others;
            $sth = DB::$con->prepare($this->sql);
            $this->query = $this->sql;
            $sth->execute();
            return $sth->fetchAll(($fech != null) ? $fech : PDO::FETCH_OBJ);
        } catch (Exception $ex) {
            throw (new DeplynException(EMessages::ERROR_QUERY))
                    ->setOriginalMessage($exc->getMessage());
        }
    }

    public function first() {
        $this->limit(1);
        $obj = $this->get();
        if (!is_array($obj)) {
            return null;
        }
        if (count($obj) == 0) {
            return null;
        }
        return $obj[0];
    }

    public function count() {
        $res = $this->get();
        if (is_array($res)) {
            return count($res);
        }
    }

    public function insert($obj) {
        try {
            if (trim($this->table) == "") {
                return (new DeplynException(EMessages::ERROR_INSERT))
                                ->setMessage("Debe invocarse el método table antes que el método insert()");
            }
            $fieldNames = implode('`, `', array_keys($obj));
            $fieldValues = ':' . implode(', :', array_keys($obj));
            $this->sql = "INSERT INTO $this->table (`$fieldNames`) VALUES ($fieldValues)";
            $this->run($obj);
            $id = DB::$con->lastInsertId();
            return $id;
        } catch (Exception $exc) {
            throw (new DeplynException(EMessages::ERROR_INSERT))
                    ->setOriginalMessage($exc->getMessage());
        }
    }

    public function update($obj) {
        try {
            if (trim($this->table) == "") {
                throw (new DeplynException(EMessages::ERROR_UPDATE))
                        ->setMessage("Debe invocarse el método table antes que el método insert()");
            }
            $fieldDetails = null;
            foreach ($obj as $key => $value) {
                $fieldDetails .= "`$key`=:$key,";
            }
            $fieldDetails = rtrim($fieldDetails, ',');
            $this->sql = "UPDATE $this->table SET $fieldDetails $this->wheres";
            $rowsAffected = $this->run($obj);
            return $rowsAffected;
        } catch (Exception $exc) {
            throw (new DeplynException(EMessages::ERROR_UPDATE))
                    ->setOriginalMessage($exc->getMessage());
        }
    }

    public function delete() {
        try {
            if (trim($this->table) == "") {
                return (new DeplynException(EMessages::ERROR_DELETE))
                                ->setMessage("Debe invocarse el método table antes que el método insert()");
            }
            $this->sql = "DELETE FROM $this->table $this->wheres";
            $sth = DB::$con->prepare($this->sql);
            $sth->execute();
            return $sth->rowCount();
        } catch (Exception $exc) {
            throw (new DeplynException(EMessages::ERROR_DELETE))
                    ->setOriginalMessage($exc->getMessage());
        }
    }

    private function run($obj) {
        $sth = DB::$con->prepare($this->sql);
        $this->query = $this->sql;
        foreach ($obj as $key => $value) {
            if ($value === DB::NULLED) {
                $value = NULL;
            }
            $this->query = str_replace(":$key", (($value === NULL) ? "NULL" : "\"$value\""), $this->query);
            $sth->bindValue(":$key", $value);
        }
        $sth->execute();
        return $sth->rowCount();
    }

    static function runSQL($sql) {
        $db = new DB();
        $db->runSQLPrivate($sql);
    }

    private function runSQLPrivate($sql) {
        $this->sql = $sql;
        $sth = $this->prepare($this->sql);
        $this->query = $this->sql;
        $sth->execute();
    }

    function getSql() {
        return $this->query;
    }

    function setSql($sql) {
        $this->sql = $sql;
    }

    public function setWheres($wheres) {
        $this->wheres = $wheres;
        return $this;
    }

}
