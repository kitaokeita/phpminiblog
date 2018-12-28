<?php

class MiniBlogApplication extends Application
{
  proteced $login_action = array('account', 'signin');

  public function getRootDir()
  {
    return dirname(__FILE__);
  }

  proteced function configure()
  {
    $this->db_manager->connect('master', array(
      'dsn' => 'mysql:dbname=mini_blog;host=localhost',

      'user' => 'root';
      'password' => '',
    ));
  }
}
