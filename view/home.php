<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>OAM</title>
	<link rel="stylesheet" type="text/css" href="../public/styles/my_style.css" />
 	<script type="text/javascript" src="../public/scripts/my_script.js"></script>
</head>
<body>
   <div class="page_messages">
   <?php
   if (isset($_SESSION['page_message'])) {
      foreach ($_SESSION['page_message'] as $key => $value) {
         echo('<p>' . $key . ' - ' .$value. '</p>');
      }
   }
   ?>
   </div>
   <div class="hello">
   <?php
   if (isset($_SESSION['user'])) {
      echo ('Hello '.$_SESSION['user']['username'].'<br/>');
      echo('Your e-mail address is '. $_SESSION['user']['email']);
      }  
   ?>
   </div>
   <a href= <?php echo(BASE_URL); ?>/home/logout>Log-out</a>
   <br />
   <a href= <?php echo(BASE_URL); ?>/home/profile>My profille</a>
   <br />
   <a href= <?php echo(BASE_URL); ?>/home/usersList>List of users</a>
   <br />
</body>
</html>