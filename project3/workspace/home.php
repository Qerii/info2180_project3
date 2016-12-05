<?php
  require_once('inc/core/init.php');

  $user = new User();
  $messages = '';
  if(!$user->isLoggedIn()) {

    var_dump($user->isLoggedIn());
    header('Location: index.php');
  }

  if(Input::exists()) {
		if(Token::check(Input::get('token'))) {
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username' => array('required' => true),
				'password' => array('required' => true)
			));

			if($validation->passed()) {
				//log user in

				$login = $user->login(Input::get('username'), Input::get('password'));
				if($login)
				{

					//Session::flash('success', 'Login successsful');
					//Redirect::to('admin.php');
				}
				else {
            //Session::flash('failure', 'username or password invalid');
            header('Location : index.php');
				}
			}
			else {
          echo 'Username and password is required';
          //Session::flash('failure', 'username or password invalid');
          //Redirect::to('index.php');
				}
			}

		}

?>


<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>CheapoMail-Home</title>
  <link rel="stylesheet" href="css/reset.css" />
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css" />
  <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>


</head>

<body>
  <div class=".container-fluid">
    <header>
      <ul>
        <li>CheapoMail</li>
        <li><a href="logout.php">Log out</a></li>
      </ul>
    </header>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
      <li role="presentation"><a href="#add_message" aria-controls="add_message" role="tab" data-toggle="tab">Add Message</a></li>
      <?php
        if($user->data()['username'] === 'Admin') {
          echo "<li role='presentation'><a href='#create_user' aria-controls='create_user' role='tab' data-toggle='tab'>Create user</a></li>";
        }
      ?>
    </ul>

    <div class="tab-content container-fluid">
      <div role="tabpanel" class="tab-pane fade in active" id="home">
        <div class="center">
          <div>

          <table class="table table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Sender</th>
                <th>Subject</th>
              </tr>
            </thead>
            <tbody id="messages">
              <?php
              if($user->isLoggedIn()) {
                $message = new Message();
                $count = 1;
                $row = $message->get('Message');
                if($row) {
                  foreach($row->_results as $result) {
                    $recipient = new User();
                    if ($recipient->find($result['user_id'])) {
                      $sender = $recipient->data()['username'];
                    } else {
                      $sender = 'unknown';
                    }

                    echo '<tr>'. '<td class="unread">'. $count .'</td>' .'<td class="unread">'. $sender. '</td>' . '<td class="unread">'. $result['subject'] .'</td>'.'<td>
                    <button class="view_message" type=button value ='.$result['id'].'>view</button>
                    </td></tr>';
                    $count++;
                  }
                }
              }
              ?>
            </tbody>

          </table>
          <button id='refresh'>Show/Refresh</button>
        </div>

          <div id="message">

          </div>
        </div>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="add_message">
        <div class="center container-fluid">
          <h1>New Message</h1>
          <form class"col-md-5" method="post" action="addMessage.php">
            <div class="form-group" id="add_sms_result">

            </div>
            <div class="form-group">
              <label for="subject">Subject</label>
              <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required="true">
            </div>
            <div class="form-group">
              <label for="subject">Recipient</label>
              <input type="text" class="form-control" id="recipient" name="recipient" placeholder="Enter recipient username" required="true">
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea class="form-control" rows="5" id="message" name="message" placeholder="Message body" required="true"></textarea>
            </div>
            <input  type="hidden" name="user_id" id="user_id" value="<?php echo $user->data()['id'] ?>" />
            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input type="submit" value"Submit" id="add_sms" class="btn btn-default col-md-2">
          </form>
        </div>
      </div>

      <div role="tabpanel" class="tab-pane fade" id="create_user">
        <div class="center container-fluid">
          <h1>Add User</h1>
          <form class=col-md-5" method="post" action="Register.php">
            <div class="form-group">
              <label for="firstname">Firstname</label>
              <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname">
            </div>
            <div class="form-group">
              <label for="lastname">Lastname</label>
              <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname">
            </div>
            <div class="form-group">
              <label for="username">username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <div class="form-group">
              <label for="confirm_pass">Confirm - Password</label>
              <input type="password" class="form-control" id="confirm_pass" name="confirm_pass" placeholder="Confirm - Password">
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
          </form>
      </div>
    </div>

  </div>
</body>
<script type="text/javascript" src="js/main.js"></script>
</html>
