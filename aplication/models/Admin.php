<?php

namespace aplication\models;

use aplication\core\Model;

class Admin extends Model{

  public $error;
  
public function loginValidate($post){
    $config = require 'aplication/config/admin.php';

    if($config['login'] != $post['login'] or $config['password'] != $post['password']){
        $this->error = 'wrong login or password';
     return false;
    }
    return true;
}
public function postValidate($post, $type){

    $nameLen = iconv_strlen($post['name']);
    $descriptionLen = iconv_strlen($post['description']);
    $textLen = iconv_strlen($post['text']);
     if($nameLen < 3 or $nameLen > 100){
       $this->error = 'name have to contain 3 to 100 symbols;';
        return false;
     }elseif($descriptionLen < 3 or $descriptionLen > 100){
      $this->error = 'description have to contain 3 to 100 symbols;';
         return false; 
     }elseif($textLen < 10 or $textLen > 5000){
      $this->error = 'text have to contain 10 to 5000 symbols;';
      return false; 
  }
  
    if(empty($_FILES['img']['tmp_name']) and $type == 'add'){
       $this->error = 'Dont choise file!!;';
       return false;
   }
     return true;
}

public function postAdd($post){
    $params = [
      'id' => '',
      'name' => $post['name'],
      'description' => $post['description'],
      'text' => $post['text']
    ];

    $this->db->query('INSERT INTO posts VALUES ("'.$params['id'].'", "'.$params['name'].'", "'.$params['description'].'", "'.$params['text'].'")');
    return $this->db->lastInsertId();
}

public function postEdit($post, $id){
  $params = [
    'id' => $id,
    'name' => $post['name'],
    'description' => $post['description'],
    'text' => $post['text']
  ];

  $this->db->query('UPDATE posts SET name="'.$params['name'].'", description="'.$params['description'].'",  text="'.$params['text'].'" WHERE id = "'.$params['id'].'"');
}

public function postUploadImage($src, $id, $width, $height, $ext, $action =null){
    // $img = new imagic($path);
    // $img->cropthumbnailimage(1024, 1024);
    // $img->setImageCompressionQuality(80);
    // $img->writeimage('public/materials/'.$id.'.jpg');
    //move_uploaded_file($path, 'public/materials/'.$id.'.jpg');

    if($action != 'add'){
       unlink('public/materials/'.$id.'.jpg');
    }
   
    $dest = 'public/materials/'.$id.'.jpg';
     
    if(!file_exists($src)) return false;
	$icfunc="imagecreatefrom".$ext;
	if(!function_exists($icfunc)) return false;
	list($imgwidth, $imgheight) = getimagesize($src);
	if($imgwidth > $width || $imgheight > $height)
	{
	$x_ratio=$width/$imgwidth;
	$y_ratio=$height/$imgheight;
	$ratio=min($x_ratio,$y_ratio);
  $use_x_ratio=($x_ratio==$ratio);
  $use_y_ratio = null;
	$new_width=$use_x_ratio?$width:floor($imgwidth*$x_ratio);
	$new_height=!$use_y_ratio?$height:floor($imgheight*$y_ratio);
	}
	else
	{
	$new_width=$imgwidth;
	$new_height=$imgheight;
	}
	$isrc=$icfunc($src);
	$bgc=0xFFFFFF;
	$new_left=($width-$new_width);
    $new_top=($height-$new_height);
	$idest=imagecreatetruecolor($width,$height);
	imagefill($idest,0,0,$bgc);
	imagecopyresampled($idest,$isrc,0,0,0,0,$new_width,$new_height,$imgwidth,$imgheight);
	
		
	if($ext=="gif")imagegif($idest,$dest);
	elseif($ext=="png")imagepng($idest,$dest);
	else imagejpeg($idest,$dest,100);
	imagedestroy($isrc);
	imagedestroy($idest);
	return true;
}

public function isPostExists($id){
  $params = [
    'id' => $id,
  ];
  return $this->db->column('SELECT * FROM posts WHERE id="'.$params['id'].'"');
}
public function postDelete($id){
  $params = [
    'id' => $id,
  ];
  $this->db->column('DELETE FROM posts WHERE id="'.$params['id'].'"');
  unlink('public/materials/'.$params['id'].'.jpg');
}

public function postData($id){
    $params = [
    'id' => $id,
  ];
  return $this->db->row('SELECT * FROM posts WHERE id="'.$params['id'].'"');
}

}