<?php

namespace aplication\core;

use aplication\lib\Db;

abstract class Model {
    public $db;
    public function __construct(){
        $this->db = new Db;    
    }
}