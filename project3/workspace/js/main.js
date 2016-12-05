
$(document).ready(function() {


 function addListeners() {
   var $messages = $('.view_message');
   var $refresh = $('#refresh');
  // var $add_sms = $('#add_sms');


   $messages.on('click', function() {
     var id = $(this).val();


     var xhr = new XMLHttpRequest();
         xhr.open('POST', 'viewMessage.php?id=' + id+'&all = false' );
         xhr.onload = function() {
             if (xhr.status === 200) {
                 $('#message').html(xhr.responseText);
                 addListeners();
             }
             else {
                 alert(xhr.status);
             }
         };
     	xhr.send();
   });

   $refresh.on('click', function() {

     var xhr = new XMLHttpRequest();
         xhr.open('POST', 'viewMessage.php?id=""&all=true');
         xhr.onload = function() {
             if (xhr.status === 200) {
                 $('#messages').html(xhr.responseText) ;
                 addListeners();
             }
             else {
                 alert(xhr.status);
             }
         };
     	xhr.send();
   });

   /*$add_sms.on('click', function(evt) {
     var $subject = $('#subject');
     var $recipient = $('#recipient');
     var $message = $('#message');
     var $user_id = $('#user_id');
     var params = "subject=" + $subject +"&recipient=" + $recipient + "&message=" + $message + "&user_id=" + $user_id;

     var xhr = new XMLHttpRequest();
         xhr.open('POST', 'addMessage.php');
         xhr.onload = function() {
             if (xhr.status === 200) {
               $('#add_sms_result').html(xhr.responseText);
                 addListeners();
             }
             else {
                 //alert(xhr.status);
             }
         };
     	xhr.send(params);
   });*/

 }

 addListeners();





});
