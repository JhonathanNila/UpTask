<?php

namespace Model;
use Model\ActiveRecord;

#[\AllowDynamicProperties]
class Project extends ActiveRecord {
    public static $table = 'PROJECTS';
    public static $rowsDB = ['ID', 'PROJECT', 'URL', 'OWNER_ID'];

    public function __construct($args = []) {
        $this->ID = $args['ID'] ?? null;
        $this->PROJECT = $args['PROJECT'] ?? '';
        $this->URL = $args['URL'] ?? '';
        $this->OWNER_ID = $args['OWNER_ID'] ?? '';
    }
    public function validateProject() {
        if(!$this->PROJECT) {
            self::$alerts['error'][] = 'The Project\'s name is required';
        }
        return self::$alerts;
    }
}