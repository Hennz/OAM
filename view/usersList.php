<?php
$groups = array('1A', '2A', '3A', '4A', '5A', '6A',
              	'1B', '2B', '3B', '4B', '5B', '6B'); 
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
	echo('<div class="buttons">');
		echo('<a class="button" href="'.BASE_URL.'/home/usersList/1">Students</a>');
		echo('<a class="button" href="'.BASE_URL.'/home/usersList/2">Assistents</a>');
	echo('</div>');
	echo ('<div class="page_messages">');
		if (isset($this->page_message) && count($this->page_message)>0)
		    foreach ($this->page_message as $key => $value) {
		        echo('<p>' . $key . ' - ' .$value. '</p>');
		    }
	echo('</div>');
	
	echo('<div class="search_content">');
		echo('<form action="'.BASE_URL.'/home/usersList" method="post" >');
		echo('<input type="text" name="text" placeholder="Search" id="text"/>');
		echo('<input type="submit" name="search" value="Search" />');
	echo('</div>');

	if ((isset($this->data)) && (!empty($this->data))) {
	echo('<div class="users_list_table">');
		echo('<div class="headRow">');
            echo('<div class="divCell">First name</div>');
            echo('<div  class="divCell">Last name</div>');
            echo('<div  class="divCell">E-mail</div>');
            echo('<div  class="divCell">Acaemic year</div>');
            if ($this->type == 1) {
            	echo('<div  class="divCell">Group</div>');
            } else {
            	echo('<div  class="divCell">Groups</div>');
            }
            
        echo('</div>');
		foreach ($this->data as $row) {
			echo('<div class="divRow">');
				echo('<div class="divCell">'.$row['fname'].'</div>');
				echo('<div class="divCell">'.$row['lname'].'</div>');
				echo('<div class="divCell">'.$row['email'].'</div>');
				echo('<div class="divCell">'.$row['stud_year'].'</div>');
				if ($this->type == 1) {
					echo('<div class="divCell">'.$row['stud_group'].'</div>');
				} else {
					if (strlen($row['groups'])>2) {
						$selectedGroups = str_split($row['groups'], 2);
						echo('<div class="divCell">');
						foreach ($selectedGroups as $val) {
							echo ($val.' ');
						}
						echo('</div>');
					} else {
						echo('<div class="divCell">all</div>');
					}
				}
				
				echo('</div>');
		}
	echo('</div>');
	} else {
		echo ("<h3>No data in database.</h3>");
	}
	?>
	</br></br>
	<?php
	$condition1 = ($_SESSION['user']['user_type']==3) ? true : false;
	$condition2 = ($_SESSION['user']['user_type']==2 && $this->type == 1) ? true : false;
	if ($condition1 || $condition2) {
		echo('<div class="add">');
	       	echo('<form action="'.BASE_URL.'/home/usersList method="post" >');
	            echo('<input type="hidden" name="type" value="<?php echo($this->type); ?>" />');
	            echo('<label for="fname">First name</label></br>');
	            echo('<input type="text" name="fname" placeholder="First name" id="fname"/><br />');
	            echo('<label for="lname">Last name</label></br>');
	            echo('<input type="text" name="lname" placeholder="Last name" id="lname"/><br />');
	            echo('<label for="email">E-mail</label></br>');
	            echo('<input type="email" name="email" placeholder="E-mail" value="alexandruasaftei86@gmail.com" id="email"/><br />');
	            echo('<label for="stud_year">Academic year</label></br>');
	         	echo('<input type="number" name="stud_year" min="1" max="3" value="1" />');
	         	echo('</br>');
	            if ($this->type == 1) {
	           		echo ('<label for="group">Group</label></br>');
	           		echo ('<select name="group">');
	           		for ($i=1; $i<7; $i++) {
	            		echo ('<option value="'.$i.'">'.$i.'</option>');
	           		}
		           	echo ('</select>');
		           	echo ('<select name="semian">');
		                echo ('<option value="A">A</option>');
		                echo ('<option value="B">B</option>');
		           	echo ('</select>');
		           	echo ('<br />');
		        } else {
		        	echo ('<label for="groups">Groups</label></br>');
	               	echo ('<select name="groups[]" multiple>');
	               	foreach ($groups as $val) {
	                  	echo ('<option value="'.$val.'">'.$val.'</option>');
	               	}
	               	echo ('</select>');
	               	echo('<br />');
		        }
	            echo('<input type="submit" name="add" value="Add user" />');
	        echo('</form>');
	    echo('</div>');
	}
?>
    
</body>
</html>