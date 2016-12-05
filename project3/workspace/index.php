<?php
  require_once('inc/core/init.php');
  $user = new User();

?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>CheapoMail-Login</title>
  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css" />
  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>


</head>

<body>
  <div id="wrapper" class=".container-fluid">
      <header class="absolute">
        <ul>
          <li>CheapoMail</li>
        </ul>
      </header>


      <div class="center container-fluid">
        <h1>Log In</h1>
        <form class"col-md-5" action="/home/ubuntu/workspace/home.php" method="post">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required="true">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="true">
          </div>
          <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
          <button type="submit" id="search_btn" class="btn btn-default col-md-2">Submit</button>
        </form>
      </div>
  </div>
</body>


</html>
