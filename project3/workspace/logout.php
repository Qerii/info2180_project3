<?php
  require_once('inc/core/init.php');

  $user = new User();
  $user->logout();

  header('Location: /home/ubuntu/workspace/index.php');
?>
