<?php
  session_start();

  $GLOBALS["config"] = array(
    'mysql' => array(
      'host' => getenv('IP'),
      'username' => getenv('C9_USER'),
      'password' => '',
      'db' => 'cheapo'
    ),
    'session' => array(
      'session_name' => 'user',
      'token_name' => 'token'
    )
  );

  spl_autoload_register(function($class) {
		require_once('/home/ubuntu/workspace/inc/classes/' . $class . '.php');
	});
?>
