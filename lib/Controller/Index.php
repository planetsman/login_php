<?php
namespace MyApp\Controller;
class Index extends \MyApp\Controller {

  public function run() {
    if (!$this->isLoggedIn()) {
      // ログインしていない場合はログイン画面にリダイレクトをかける
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }
    
    // get users info
    $userModel = new \MyApp\Model\User();
    $this->setValues('users', $userModel->findAll());
    }
}