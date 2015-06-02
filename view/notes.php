<?php
var_dump($this->data);
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

if ((isset($this->data)) && (!empty($this->data))) {
echo('<div class="users_list_table">');
	echo('<div class="headRow">');
        echo('<div class="divCell">Title</div>');
        echo('<div  class="divCell">Subject</div>');
        echo('<div  class="divCell">Teacher</div>');
        echo('<div  class="divCell">Delete</div>');
    echo('</div>');
	foreach ($this->data as $row) {
		echo('<div class="divRow">');
			echo('<div class="divCell">'.$row['id'].'</div>');
			echo('<div class="divCell">'.$row['subject_id'].'</div>');
			echo('<div class="divCell">'.$row['owner_id'].'</div>');
		echo('</div>');
		}
	echo('</div>');
} else {
	echo ("<h3>No data in database.</h3>");
}
?>

</body>
</html>