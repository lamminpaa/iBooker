<?php

class LoginController extends Zend_Controller_Action {

    public function init() {
        $this->usersTable = new Application_Model_DbTable_Users();
    }

    public function authenticateAction() {

        $loginForm = new Application_Form_Login();
        $request = $this->getRequest();
        if ($request->isPost()) {
            if ($loginForm->isValid($request->getPost())) {
                if ($this->usersTable->authenticate($loginForm->getValues())) {
                    $get_url = $_SESSION['get_url'];
                    unset($_SESSION['get_url']);
                    $this->_redirect($get_url);
                } else {
                    $loginForm->setDescription("Password and username dont match");
                }
            }
        }
        // $loginForm->setDescription("No values given");
        $this->view->loginForm = $loginForm;
        $this->render('index');
    }

    public function indexAction() {
        
        $loginForm = new Application_Form_Login();
        $this->view->loginForm = $loginForm;
    }

    public function registerAction() {
        $registerForm = new Application_Form_Register();
        $this->view->registerForm = $registerForm;
    }

    public function createAction() {
        $registerForm = new Application_Form_Register();
        $request = $this->getRequest();
        if ($registerForm->isValid($request->getPost())) {
            if ($this->usersTable->register($registerForm->getValues())) {
                $this->_redirect('/');
            } else {
                $registerForm->setDescription('Email Reserved');
            }
        } else {
            
        }
        $this->view->registerForm = $registerForm;
        $this->render('register');
    }

    public function logoutAction() {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('login');
    }

}
