<?php

namespace aplication\lib;

class Db{
   
    protected $db;

    public function __construct(){
       $config = require 'aplication/config/db.php';
       
       $connect=mysql_connect($config['host'], $config['user'], $config['password']) or die ("Mysql Connect Error!"); 
        mysql_select_db($config['name'],$connect);
        mysql_query("SET NAMES utf8");

    }
    public function query($query){
       $response = mysql_query($query);
      // $res = mysql_fetch_assoc($response);
      return $response;
    }

    public function column($query){
      $response = $this->query($query);
      $res = mysql_fetch_assoc($response);
      return $res;
    }

    public function row($query){
      $response = $this->query($query);
      $r = [];
      while($res = mysql_fetch_assoc($response)){
       array_push($r, $res);
      }
      //$res = mysql_fetch_assoc($response);
      return $r;
    }
    public function countPosts($query){
      $response = $this->query($query);
      return $response;
    }
    
    public function lastInsertId(){
       return  mysql_insert_id();
    }
}