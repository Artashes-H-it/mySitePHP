<?php

namespace aplication\controllers;

use aplication\core\Controller;
use aplication\models\Main;
use aplication\lib\Pagination;
//use aplication\lib\Db;

class AdminController extends Controller{

    public function __construct($route){
       parent::__construct($route);
       $this->view->layout = 'admin';
      
        }

    public function loginAction(){
        if(isset($_SESSION['admin'])){
            $this->view->redirect('admin/add');
    
        }
        if(!empty($_POST)){
            if(!$this->model->loginValidate($_POST)){
              $this->view->massage('error', $this->model->error);
            }
            $_SESSION['admin'] = true;
            $this->view->location('admin/add');
          }
      $this->view->render('Enter');
    }

    public function addAction(){
        if(!empty($_POST)){
            if(!$this->model->postValidate($_POST, 'add')){
              $this->view->massage('error', $this->model->error);
            }
            $id = $this->model->postAdd($_POST);
            if(!$id){
              $this->view->massage('success', 'error request operation:');
            }
        
            $this->model->postUploadImage($_FILES['img']['tmp_name'], $id, 1080, 600, 'jpeg', $this->route['action']);
            $this->view->massage('success', 'post added');
          }
        $this->view->render('Add post');
        }
    
        public function editAction(){
          if(!$this->model->isPostExists($this->route['id'])){
            $this->view->errorCode(404);
          }
            if(!empty($_POST)){
            if(!$this->model->postValidate($_POST, 'edit')){
                $this->view->massage('error', $this->model->error);
              }
              $this->model->postEdit($_POST, $this->route['id']);
              if($_FILES['img']['tmp_name']){
                $this->model->postUploadImage($_FILES['img']['tmp_name'], $this->route['id'], 1080, 600, 'jpeg');
              }
              $this->view->massage('success', 'saved');
            }

            $vars =[
            'data' => $this->model->postData($this->route['id']),
            ];
            $this->view->render('Edit post', $vars);
        }

        public function deleteAction(){
            if(!$this->model->isPostExists($this->route['id'])){
                $this->view->errorCode(404);
              }
                $this->model->postDelete($this->route['id']);
                $this->view->redirect('admin/posts');
        }

        public function logoutAction(){
            unset($_SESSION['admin']);
            $this->view->redirect('admin/login');
             // $this->view->render('logout');
        }

        public function postsAction(){
          $mainModel = new Main;
	      	$pagination = new Pagination($this->route, $mainModel->postsCount());
		      $vars = [
		     	'pagination' => $pagination->get(),
		    	'list' => $mainModel->postsList($this->route),
	      	];
		      $this->view->render('Посты', $vars);
	       }
                   
}