<?php
require_once('inc/core/init.php');
if(Input::exists('get')) {
  $user = new User();
    $message = new Message();

    if(!Input::get('all')) {
      $row = $message->get('Message', array('id', '=', Input::get('id')));
      if($row) {
        echo "
        <span><strong>Subject:</strong> ".$row->first()['subject']."</span>
        <span><strong>Message:</strong> ".$row->first()['body']."</span>
        <span><strong>Date sent:</strong> ".$row->first()['date_sent']."</span>";

        try {
          $message->create('Message_read',array(
            'id' => 'NULL',
            'message_id' => $row->first()['id'],
            'reader_id' => $user->data()['id'],
            'date' => date('Y-m-d H:i:s')
          ));

        } catch(Exception $e) {
          echo '<strong>Message already read:</strong><br/>';
          die($e->getMessage());

        }
    }
  } else {
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

        echo '<tr>'. '<td>'. $count .'</td>' .'<td>'. $sender. '</td>' . '<td>'. $result['subject'] .'</td>'.'<td>
        <button class="view_message" type=button value ='.$result['id'].'>view</button>
        </td></tr>';
        $count++;
      }

    }
  }



}
?>
