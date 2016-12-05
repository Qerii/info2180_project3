<?php
  require_once('inc/core/init.php');
  if(Input::exists()) {

      $error = '';
      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'subject' => array(
          'required' => true
        ),
        'message' => array(
          'required' => true
        )
      ));

      if($validation->passed()) {
        $message = new Message();
        try {
          $recipient = new User();
          if($recipient->find(Input::get('recipient'))) {
            $message->create('Message',array(
              'id' => 'NULL',
              'recipient_ids' => $recipient->data()['id'],
              'user_id' => Input::get('user_id'),
              'subject' => Input::get('subject'),
              'body' => Input::get('message'),
              'date_sent' => date('Y-m-d H:i:s')
            ));

            header('Location: /home/ubuntu/workspace/home.php');
          } else {
              echo 'recipient not found';
          }
        } catch(Exception $e) {
          die($e->getMessage());
        }



      }
      else {
        foreach ($validation->errors() as $error) {
          echo $error. '<br />';
        }
      }



  }
?>
