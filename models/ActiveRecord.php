<?php

namespace Model;

class ActiveRecord {
    protected static $DB;
    protected static $table = '';
    protected static $rowsDB = [];
    protected static $alerts = [];

    // Connection to DB
    public static function setDB($database) {
        self::$DB = $database;
    }
    public static function setAlert($type, $message) {
        static::$alerts[$type][] = $message;
    }
    // Validation
    public static function getAlerts() {
        return static::$alerts;
    }
    public function validate() {
        static::$alerts = [];
        return static::$alerts;
    }
    // CRUD Registres
    public function save() {
        $result = '';
        if(!is_null($this->ID)) {
            // Update
            $result = $this->update();
        } else {
            // Create a new register
            $result = $this->create();
        }
        return $result;
    }
    public static function all() {
        $query = "SELECT * FROM " . static::$table;
        $result = self::consultingSQL($query);
        return $result;
    }
    // Search a register by ID
    public static function find($ID) {
        $query = "SELECT * FROM " . static::$table  ." WHERE ID = {$ID}";
        $result = self::consultingSQL($query);
        return array_shift( $result ) ;
    }
    // Get Register
    public static function get($limit) {
        $query = "SELECT * FROM " . static::$table . " LIMIT {$limit}";
        $result = self::consultingSQL($query);
        return array_shift( $result ) ;
    }
    public static function where($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE {$column} = '{$value}'";
        $result = self::consultingSQL($query);
        return array_shift( $result ) ;
    }
    public static function belongsTo($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE {$column} = '{$value}'";
        $result = self::consultingSQL($query);
        return $result;
    }
    // SQL for advanced consults
    public static function SQL($consult) {
        $query = $consult;
        $result = self::consultingSQL($query);
        return $result;
    }
    // Create a new register
    public function create() {
        // Sanitize data
        $atributtes = $this->sanitizeAtributtes();

        // Database insert
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($atributtes));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($atributtes));
        $query .= " ') ";
        // Consult result
        $result = self::$DB->query($query);
        return [
            'result' =>  $result,
            'ID' => self::$DB->insert_id
        ];
    }
    public function update() {
        // Sanitize data
        $atributtes = $this->sanitizeAtributtes();

        // Itiration in DB 
        $values = [];
        foreach($atributtes as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$table ." SET ";
        $query .=  join(', ', $values );
        $query .= " WHERE ID = '" . self::$DB->escape_string($this->ID) . "' ";
        $query .= " LIMIT 1 "; 

        // debuguear($query);

        $result = self::$DB->query($query);
        return $result;
    }
    // Delete register, get the ID of Active Record
    public function delete() {
        $query = "DELETE FROM "  . static::$table . " WHERE ID = " . self::$DB->escape_string($this->ID) . " LIMIT 1";
        $result = self::$DB->query($query);
        return $result;
    }
    public static function consultingSQL($query) {
        // Consult database
        $result = self::$DB->query($query);

        // Iterate data
        $array = [];
        while($register = $result->fetch_assoc()) {
            $array[] = static::createObject($register);
        }

        // Realese memory
        $result->free();

        // Return result
        return $array;
    }
    protected static function createObject($register) {
        $object = new static;

        foreach($register as $key => $value ) {
            if(property_exists( $object, $key  )) {
                $object->$key = $value;
            }
        }
        return $object;
    }
    public function atributtes() {
        $atributtes = [];
        foreach(static::$rowsDB as $column) {
            if($column === 'ID') continue;
            $atributtes[$column] = $this->$column;
        }
        return $atributtes;
    }
    public function sanitizEAtributtes() {
        $atributtes = $this->atributtes();
        $sanitize = [];
        foreach($atributtes as $key => $value ) {
            $sanitize[$key] = self::$DB->escape_string($value);
        }
        return $sanitize;
    }
    public function sync($args=[]) { 
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
            }
        }
    }
}