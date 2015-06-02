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

if ((isset($this->data)) && (!empty($this->data))) {
		echo('<div class="project_details">');
			echo('<p><b> Title:</b> '.$this->data[0]['title'].'</p>');
			echo('<p><b> Subject: </b></p>');
			echo('<p>'.$this->data[0]['subject'].'</p>');
			echo('<p><b> Maximum note:</b> '.$this->data[0]['max_note'].'</p>');
			echo('<p><b> Maximum number of users:</b> '.$this->data[0]['max_studs'].'</p>');
			echo('<p><b> Students enrolled: </b></p>');
		echo('</div>');

		echo('<div class="users_list_table">');
			echo('<div class="headRow">');
		        echo('<div class="divCell">Student</div>');
		        echo('<div  class="divCell" >Solution</div>');
		        echo('<div  class="divCell">Note</div>');
		    echo('</div>');
			foreach ($this->data as $val) {
			echo('<div class="divRow">');
				$idd = $val['idd'];
				echo('<input type="hidden" name="idd" value="'.$idd.'">');
				echo('<div class="divCell">'.$val['username'].'</div>');
				$filename = (empty($val['file_name'])) ? "unsolve" : $val['file_name'] ;
		        echo('<div  class="divCell" >'.$filename.'</div>');
		        $user_id = $val['user_id'];
		        $note = '<input type="number" name="note" min="1" max="10" value="'.$val['note'].'" onChange="setNote('.$idd.', this)"/>';
		        echo('<div  class="divCell">'.$note.'</div>');
			echo('</div>');
			}
		echo('</div>');
} else {
	echo ("<h3>No data in database.</h3>");
}
?>

</body>
</html>