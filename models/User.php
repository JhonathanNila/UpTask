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
        $this->PASSWORD_CURRENT = $args['PASSWORD_CURRENT'] ?? '';
        $this->PASSWORD_NEW = $args['PASSWORD_NEW'] ?? '';
        $this->TOKEN = $args['TOKEN'] ?? '';
        $this->CONFIRMED = $args['CONFIRMED'] ?? 0;
    }
    public function validateLogin() {
        if(!$this->EMAIL) {
            self::$alerts['error'][] = 'The User\'s Email is required';
        }
        if(!filter_var($this->EMAIL, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Invalid Email Format';
        }
        if(!$this->PASSWORD) {
            self::$alerts['error'][] = 'The Password is required';
        }
        return self::$alerts;
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
    public function validatePassword() {
        if(!$this->PASSWORD) {
            self::$alerts['error'][] = 'The Password is required';
        }
        if(strlen($this->PASSWORD) < 6) {
            self::$alerts['error'][] = 'The Password must contain at least 6 characters';
        }
        return self::$alerts;
    }
    public function validateProfile() {
        if(!$this->NAME) {
            self::$alerts['error'][] = 'The Name is required';
        }
        if(!$this->EMAIL) {
            self::$alerts['error'][] = 'The Email is required';
        }
        return self::$alerts;
    }
    public function hashPassword() {
        $this->PASSWORD = password_hash($this->PASSWORD, PASSWORD_BCRYPT);

    }
    public function generateToken() {
        $this->TOKEN = md5(uniqid(), );
    }
    public function validateEmail() {
        if(!$this->EMAIL) {
            self::$alerts['error'][] = 'The User\'s Email is required for reseting Password';
        }
        if(!filter_var($this->EMAIL, FILTER_VALIDATE_EMAIL)) {
            self::$alerts['error'][] = 'Invalid Email Format';
        }
        return self::$alerts;
    }
    public function newPassword() {
        if(!$this->PASSWORD_CURRENT) {
            self::$alerts['error'][] = 'The Current Password is required';
        }
        if(strlen($this->PASSWORD_CURRENT) < 6) {
            self::$alerts['error'][] = 'The Current Password must contain at least 6 characters';
        }
        if(!$this->PASSWORD_NEW) {
            self::$alerts['error'][] = 'The New Password is required';
        }
        if(strlen($this->PASSWORD_NEW) < 6) {
            self::$alerts['error'][] = 'The New Password must contain at least 6 characters';
        }
        return self::$alerts;
    }
    public function passwordVerify() {
        return password_verify($this->PASSWORD_CURRENT, $this->PASSWORD);
    }
}