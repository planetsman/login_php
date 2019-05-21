<?php

namespace MyApp\Controller;

class Signup extends \MyApp\Controller {


  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $this->postProcess();
    }
  }

  protected function postProcess(){
 
    try {
     $this->_validate();
   } catch (\MyApp\Exception\InvalidEmail $e) {
    // echo $e->getMessage(); //追加
    // exit; //追加
    $this->setErrors('email', $e->getMessage());
   } catch (\MyApp\Exception\InvalidPassword $e) {
    // echo $e->getMessage(); //追加
    // exit; //追加
    $this->setErrors('password', $e->getMessage());
   }

   $this->setValues('email', $_POST['email']);
   // echo "成功"; //追加
   // exit; //追加
  if ($this->hasError()) {
    return;
  } else {
    //create user
    try {
        $userModel = new \MyApp\Model\User();
        $userModel->create([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch (\MyApp\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
    //redirect to login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }
  }

  private function _validate(){
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "Invalid Token!";
      exit;
    }
    
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new \MyApp\Exception\InvalidEmail();
    }

    if (!preg_match('/\A[a-zA-Z0-9]+\z/', $_POST['password'])) {
      throw new \MyApp\Exception\InvalidPassword();
    }
  }

}