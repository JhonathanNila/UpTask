<?php

namespace Model;
use Model\ActiveRecord;

#[\AllowDynamicProperties]
class Task extends ActiveRecord {
    protected static $table = 'TASKS';
    protected static $rowsDB = ['ID', 'TASK', 'STATUS', 'PROJECT_ID'];

    public function __construct($args = '') {
        $this->ID = $args['ID'] ?? null;
        $this->TASK = $args['TASK'] ?? '';
        $this->STATUS = $args['STATUS'] ?? 0;
        $this->PROJECT_ID = $args['PROJECT_ID'] ?? '';
    }
}