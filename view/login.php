<!DOCTYPE html>
<html>
<head>
	<title>OAM</title>
	<link rel="stylesheet" type="text/css" href=<?php echo(BASE_URL); ?>/public/styles/my_style.css />
   <script type="text/javascript" src=<?php echo(BASE_URL); ?>/public/scripts/my_script.js></script>
</head>
<body>
   <div class="page_messages">
      <?php
      if (isset($this->page_message) && count($this->page_message)>0)
         foreach ($this->page_message as $key => $value) {
            echo('<p>' . $key . ' - ' .$value. '</p>');
         }
      ?>
   </div>
   <div class="log_reg">
      <div class="buttons">
         <span onclick="changeLogReg(0)">Log in</span>
         <span onclick="changeLogReg(1)">Register</span>
      </div>
      <div class="login">
         <form action= <?php echo(BASE_URL); ?>/home/login method="post">
            <label for="email">E-mail</label></br>
            <input type="email" name="email" placeholder="e-mail" value="alexandruasaftei86@gmail.com" required/><br />
            <label for="password">Password</label></br>
            <input type="password" name="password" placeholder="Password" required/><br />
            Remember me<input type="checkbox" name="remember" /><br />
            <input type="submit" name="login_send" value="Log in"/>
         </form>
      </div>
      <div class="register">
         <form action= <?php echo(BASE_URL); ?>/home/register method="post" >
            <!-- onsubmit="return register_validation();" -->
            <label for="fname">First name</label></br>
            <input type="text" name="fname" placeholder="First name" id="fname"/><br />
            <label for="lname">Last name</label></br>
            <input type="text" name="lname" placeholder="Last name" id="lname"/><br />
            <label for="email">E-mail</label></br>
            <input type="email" name="email" placeholder="E-mail" value="alexandruasaftei86@gmail.com" id="email"/><br />
            <label for="password">Password</label></br>
            <input type="password" name="password" placeholder="Password" id="password"/><br />
            <label for="rpassword">Confirm password</label></br>
            <input type="password" name="rpassword" placeholder="Repeat password" id="rpassword"/><br />
            <label for="user_type">User type</label></br>
            <?php
            $user_type = array(
               1=>'Student',
               2=>'Assistent',
               3=>'Teacher',
               );
            foreach ($user_type as $key => $value) {
               echo('<input type="radio" name="user_type" value="'.$key.'"'.(($key==1)?("checked"):("")).
                  ' onchange="changeUserType('.$key.')">'.$value.'<br />');
            }
            $years = array(
                  1=>'I',
                  2=>'II',
                  3=>'III',
                  4=>'trainee' 
                  );
               echo ('<label for="year">Year</label>');
               echo('<br/>');
               echo ('<select name="year">');
               foreach ($years as $key => $value) {
                  echo ('<option value="'.$key.'">'.$value.'</option>');
               }
               echo ('</select>');
               echo('<br/>');
            ?>
            <div class="student_details">
               <?php
               echo ('<label for="group">Group</label></br>');
               echo ('<select name="group">');
               for ($i=1; $i<7; $i++) {
                  echo ('<option value="'.$i.'">'.$i.'</option>');
               }
               echo ('</select>');
               ?>
               <select name="semian">
                  <option value="A">A</option>
                  <option value="B">B</option>
               </select>
               <br />
            </div>
            <div class="teacher_details">
               <?php
               $groups = array('1A', '2A', '3A', '4A', '5A', '6A',
                              '1B', '2B', '3B', '4B', '5B', '6B'); 
               echo ('<label for="groups">Groups</label></br>');
               echo ('<select name="groups[]" multiple>');
               foreach ($groups as $val) {
                  echo ('<option value="'.$val.'">'.$val.'</option>');
               }
               echo ('</select>');
               ?>
               <br />
            </div>
            <input type="submit" name="register_send" value="Register" onclick="register_validation()"/>
         </form>
      </div>
   </div>
</body>
</html>