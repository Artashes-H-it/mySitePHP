<?php

namespace aplication\controllers;

use aplication\core\Controller;
use aplication\lib\Pagination;
use aplication\models\Admin;
//use aplication\lib\Db;

class MainController extends Controller{

    public function indexAction(){
    $pagination = new Pagination($this->route, $this->model->postsCount());
    $vars = [
       'pagination' => $pagination->get(),
       'list' => $this->model->postsList($this->route),
    ];
    $this->view->render('main page',  $vars);
   
    }
    
    public function aboutAction(){
      $this->view->render('about page');
      }

      public function contactAction(){
        if(!empty($_POST)){
          if(!$this->model->contactValidate($_POST)){
            $this->view->massage('error', $this->model->error);
          }
          mail('bmarth@mail.ru', 'Massage from blog', $_POST['name'] .'|'. $_POST['email'].'|'.$_POST['text']);
           $this->view->massage('success', 'Massage sent to administrate:');
        }
        $this->view->render('contact page');
       
        }
        public function postAction(){
          $adminModels = new Admin;
          if(!$adminModels->isPostExists($this->route['id'])){
             $this->view->errorCode(404);
          }
          $vars = [
            'data' => $adminModels->postData($this->route['id'])[0],
          ];
          $this->view->render('post page', $vars);
          }
}