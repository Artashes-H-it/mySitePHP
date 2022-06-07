<?php

namespace aplication\models;

use aplication\core\Model;

class Main extends Model{

  public $error;
  
public function contactValidate($post){

  $nameLen = iconv_strlen($post['name']);
  $textLen = iconv_strlen($post['text']);
     if($nameLen < 3 or $nameLen > 20){
       $this->error = 'name have to contain 3 to 20 symbols;';
        return false;
     }elseif(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
      $this->error = 'wrong Email adress;';
         return false; 
     }elseif($textLen < 10 or $textLen > 500){
      $this->error = 'text have to contain 10 to 500 symbols;';
      return false; 
  }
     return true;
}

public function postsCount() {
  return $this->db->countPosts('SELECT COUNT(id) FROM posts');
}

public function postsList($route) {

  $max = 10;
  $params = [
    'max' => $max,
    'start' => (((isset($route['page']) ? $route['page'] : 1) - 1) * $max),
  ];
  //return $params['start'];
  return $this->db->row('SELECT * FROM posts ORDER BY id DESC LIMIT '.$params['start'].','.$params['max'].'');
}

}