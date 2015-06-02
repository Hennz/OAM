<?php
$all_groups = array('1A', '2A', '3A', '4A', '5A', '6A',
                    '1B', '2B', '3B', '4B', '5B', '6B'); 
$years = array( 1=>'I',
                2=>'II',
                3=>'III',
                4=>'trainee' 
                );
?>
<!DOCTYPE html>
<html>
<head>
	<title>OAM</title>
	<link rel="stylesheet" type="text/css" href=<?php echo(BASE_URL); ?>/public/styles/my_style.css />
   <script type="text/javascript" src=<?php echo(BASE_URL); ?>/public/scripts/my_script.js></script>
</head>
<body>

<?php
include("menu.php");
echo ('<div class="page_messages">');
	if (isset($this->page_message) && count($this->page_message)>0)
	    foreach ($this->page_message as $key => $value) {
	        echo('<p>' . $key . ' - ' .$value. '</p>');
	    }
echo('</div>');

echo('<fieldset class="profille">');
	echo('<legend>Your profile</legend>');
	echo('<form action="'.BASE_URL.'/home/profile" method="post">');
		echo('<label>Username: </label>');
		echo('<input type="text" name="username" id="username" value="'. $this->data['username'] .'" />');
		echo('<br />');
		echo('<label>First name: </label>');
		echo('<input type="text" name="fname" id="fname" value="'. $this->data['fname'] .'" />');
		echo('<br />');
		echo('<label>Last name: </label>');
		echo('<input type="text" name="lname" id="lname" value="'. $this->data['lname'] .'" />');
		echo('<br />');
		echo('<label>E-mail: </label>');
		echo('<input type="text" name="email" id="email" value="'. $this->data['email'] .'" readonly />');
		echo('<br />');
		echo('<label>University year: </label>');
		echo('<br/>');
       	echo ('<select name="stud_year">');
       	foreach ($years as $key => $value) {
        	echo ('<option value="'.$key.'" '. (($this->data['stud_year']==$key) ? "selected": "") .'>'.$value.'</option>');
       	}
       	echo ('</select>');

		echo('<br />');
		if ($this->data['type'] == 1) {
			echo('<label>Group: </label>');
			echo('<select name="group">');
			foreach ($all_groups as $val) {
				echo('<option value="'.$val.'" '. (($val == $this->data['stud_group']) ? 'selected' : '') .'/>'. $val .'</option>');
			}
			echo('</select>');
			echo('<br />');
		} else if ($this->data['type'] == 2) {
			echo('<label>Your groups: </label><br />');
			if (empty($this->data['groups'])) {
				echo('<select name="groups[]" multiple>');
				foreach ($all_groups as $val) {
					echo('<option value="'.$val.'" selected />'. $val .'</option>');
				}
				echo('</select>');
			} else {
				$groups = str_split($this->data['groups'], 2);
				echo('<select name="groups[]" multiple>');
				foreach ($all_groups as $val) {
					echo('<option value="'.$val.'" '. ((in_array($val, $groups)) ? 'selected' : '') .'/>'. $val .'</option>');
				}
				echo('</select>');
			}
		} else {
			echo('<label>Your groups: </label>');
			echo('<input type="text" name="groups" id="groups" value="all" />');
			echo('<br />');
		}
		echo('<input type="submit" name="update" value="Update" />');
	echo('</form>');
echo('</fieldset>');

echo('<fieldset class="profille">');
	echo('<legend>Change password</legend>');
	echo('<form action="'.BASE_URL.'/home/changePassword" method="post">');
		echo('<label for="oldpassword">Old password: </label>');
		echo('<input type="password" name="oldpassword" />');
		echo('<br />');
		echo('<label for="newpassword">New password: </label>');
		echo('<input type="password" name="newpassword" />');
		echo('<br />');
		echo('<label for="confpassword">Repeat password: </label>');
		echo('<input type="password" name="confpassword" />');
		echo('<br />');
		echo('<input type="submit" name="change" value="Change" />');
	echo('</form>');
echo('</fieldset>');
?>

</body>
</html>