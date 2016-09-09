<?php

class MyPDO {

    private $connection; //connection object
    private $last; //last query
    
    /**
     * constructor to open database connection
     */
    public function __construct() {
        $this->dbconnect();
        $this->Execute('SET NAMES utf8');
    }

    /**
     * Connect to DB
     * @return boolean
     */
    public function dbconnect() {

        try {
            $this->connection = new PDO("mysql:host=".HOSTNAME.";dbname=".DBNAME.";",USERNAME,"");
            if ($this->connection) {
                return TRUE;
            }
        } catch (PDOException $ex) {
            echo 'DB connection failed' . $ex->getMessage();
        }
        return FALSE;
    }

    /**
     * Execute Query
     * @param type $query
     * @return boolean
     */
    public function Execute($query) {
        //$query = $this->connection->real_escape_string($query);
        $stmt = $this->connection->prepare($query);

        if ($stmt->execute()) {
            $this->last = $stmt;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Execute MultiQuery
     * @param type $query
     * @return boolean
     */
    public function Execute_Multi($query) {
        //$query = $this->connection->real_escape_string($query);
        if ($result = $this->connection->multi_query($query)) {
            $this->last = $result;
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Get rows for the last query
     * @return null
     */
    public function GetRows() {
        $result = array();
        $rows = $this->AffectedRows();
        $this->last->setFetchMode(PDO::FETCH_ASSOC);
        for ($i = 0; $i < $rows; $i++) {
            $result[] = $this->last->fetch();
        }
        if (count($result) > 0)
            return $result;

        $this->last->free();

        return NULL;
    }
/**
 * Get one row 
 * @return null
 */
    public function GetRow() {
        $result = array();
        $rows = $this->AffectedRows();
        for ($i = 0; $i < $rows; $i++) {
            $result[] = $this->last->fetch_assoc();
        }
        if (count($result) > 0)
            return $result[0];

        $this->last->free();

        return NULL;
    }

    /**
     * Get the number of affect ed rows
     * @return int
     */
    public function AffectedRows() {
        return $this->last->rowCount();
    }

    /**
     * Count Results in Table
     * @param in $table 
     */
    public function Select_Count($table) {
        $this->Execute("SELECT COUNT(*) FROM `$table`");
        $count = $this->GetRow();
        return $count['COUNT(*)'];
    }

    /**
     * Inserting row into database
     * @param string $table
     * @param array $data
     * @return boolean
     */
    public function Insert($table, $data) {

        // setup some variables for fields and values
        $fields = '';
        $values = '';
        // populate them
        foreach ($data as $f => $v) {
            $fields .= "`$f`,";
            $values .= ( is_numeric($v) && ( intval($v) == $v ) ) ? $v . "," : "'$v',";
        }

        // remove our trailing ,
        $fields = substr($fields, 0, -1);
        // remove our trailing ,
        $values = substr($values, 0, -1);

        $querystring = "INSERT INTO `{$table}` ({$fields}) VALUES({$values})";
        //echo $querystring;
        //Check If Row Inserted
        if ($this->Execute($querystring))
            return TRUE;

        return FALSE;
    }

    /**
     * Delete form table
     * @param string $from
     * @param string $where
     * @return boolean
     */
    public function Delete($from, $where) {
        $query = sprintf('DELETE FROM `%s` %s', $from, $where);
        // echo $query;
        $result = $this->Execute($query);
        if ($result && $this->AffectedRows() > 0)
            return TRUE;

        return FALSE;
    }

    /**
     * Update Table
     * @param string $table
     * @param string $array
     * @return Boolean
     */
    public function Update($table, $data, $where = '') {
        //set $key = $value :)

        $query = '';
        foreach ($data as $f => $v) {
            (is_numeric($v) && intval($v) == $v || is_float($v)) ? $v . "," : "'$v' ,";
            $query .= "`$f` = '{$v}' ,";
        }

        //Remove trailing ,
        $query = substr($query, 0, -1);

        $querystring = "UPDATE `{$table}` SET {$query} {$where}";
        //echo $querystring;
        $update = $this->Execute($querystring);
        if ($update)
            return TRUE;

        return FALSE;
    }

    /**
     * Get the last modified object
     * @return type
     */
    public function Last() {
        return $this->connection->insert_id;
    }

    /**
     * Deconstructor Close Connection
     */
    public function __destruct() {
        $this->connection = NULL;
    }

}

?>
