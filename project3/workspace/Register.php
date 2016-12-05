<?php
  require_once('inc/core/init.php');
  $errors = '';
  if(Input::exists()) {
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'username' => array(
					'required' => true,
					'min' => 2,
					'max' => 20,
					'unique' => 'User',
					'characters' => '/^[A-Za-z0-9\-\_\.]+/i'
				),
				'password' => array(
					'required' => true,
          'characters' => '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/'
				),
				'confirm_pass' => array(
					'required' => true,
					'matches' => 'password'
				),
        'firstname' => array(
          'required' => true
        ),
        'lastname' => array(
          'required' => true
        )
			));

			if($validation->passed()) {
				$user = new User();

				try {
					$user->create(array(
						'id' => 'NULL',
            'firstname' => Input::get('firstname'),
            'lastname' => Input::get('lastname'),
						'username' => Input::get('username'),
						'password' => md5(Input::get('password'))
					));
          header('Location: home.php');
				} catch(Exception $e) {
					die($e->getMessage());
				}


			}
			else {
        foreach ($validation->errors() as $error) {
					echo $error. '<br />';
        }

        header('Location: home.php');

			}

  }

?>
