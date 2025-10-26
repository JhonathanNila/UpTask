<?php

namespace Model;

#[\AllowDynamicProperties]
class User extends ActiveRecord {
    protected static $table = 'USERS';
    protected static $rowsDB = ['ID', 'NAME', 'EMAIL', 'PASSWORD', 'TOKEN', 'CONFIRMED'];

    public function __construct($args = []) {
        $this->ID = $args['ID'] ?? null;
        $this->NAME = $args['NAME'] ?? '';
        $this->EMAIL = $args['EMAIL'] ?? '';
        $this->PASSWORD = $args['PASSWORD'] ?? '';
        $this->PASSWORD2 = $args['PASSWORD2'] ?? '';
        $this->TOKEN = $args['TOKEN'] ?? '';
        $this->CONFIRMED = $args['CONFIRMED'] ?? 0;
    }
    public function validateNewAccount() {
        if(!$this->NAME) {
            self::$alerts['error'][] = 'The User\'s Name is required';
        }
        if(!$this->EMAIL) {
            self::$alerts['error'][] = 'The User\'s Email is required';
        }
        if(!$this->PASSWORD) {
            self::$alerts['error'][] = 'The Password is required';
        }
        if(strlen($this->PASSWORD) < 6) {
            self::$alerts['error'][] = 'The Password must contain at least 6 characters';
        }
        if($this->PASSWORD !== $this->PASSWORD2) {
            self::$alerts['error'][] = 'The passwords don\'t match';
        }
        return self::$alerts;
    }
    public function hashPassword() {
        $this->PASSWORD = password_hash($this->PASSWORD, PASSWORD_BCRYPT);

    }
    public function generateToken() {
        $this->TOKEN = md5(uniqid(), );
    }
}