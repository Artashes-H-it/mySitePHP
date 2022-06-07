<?php
namespace aplication\controllers;

use aplication\core\Controller;
//use aplication\lib\Db;

class AccountController extends Controller{

    public function loginAction(){
        if(!empty($_POST)){
            $this->view->location('/account/register');
        }
        $this->view->render('Enter');
    }

    public function registerAction(){
        $this->view->render('reg page');
    }
    
}