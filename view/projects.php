<?php
	#var_dump($this->data);die();
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

echo('<div class="search_content">');
	echo('<form action="'.BASE_URL.'/home/projects" method="post" >');
	echo('<input type="text" name="text" placeholder="Search" id="text"/>');
	echo('<input type="submit" name="search" value="Search" />');
echo('</div>');

if ((isset($this->data)) && (!empty($this->data))) {
echo('<div class="users_list_table">');
	echo('<div class="headRow">');
        echo('<div class="divCell" id="title">Title</div>');
        echo('<div  class="divCell" id="subject" >Subject</div>');
        echo('<div  class="divCell" id="max_note">Maximum note</div>');
        echo('<div  class="divCell" id="max_studs">Nr of studs</div>');
        echo('<div  class="divCell" id="teacher">Teacher</div>');
        echo('<div  class="divCell" id="action">Delete</div>');
    echo('</div>');
	foreach ($this->data as $row) {
		echo('<div class="divRow">');
			$idd = $row['id'];
			$title='<a href="'.BASE_URL.'/home/project/'.$idd.'">'.$row['title'].'</a>';
			echo('<div class="divCell" id="title">'.$title.'</div>');
			echo('<div class="divCell" id="subject">'.$row['subject'].'</div>');
			echo('<div class="divCell" id="max_note">'.$row['max_note'].'</div>');
			echo('<div class="divCell" id="max_studs">'.$row['max_studs'].'</div>');
			echo('<div class="divCell" id="teacher">'.$row['owner_id'].'</div>');
			if ($this->type == 1) {
				$cell = '<img src="'.BASE_URL.'/public/images/take.png" onClick="select_project('.$idd.', this)"></img>';
			}
			if ($this->type == 2) {
				$cell = '<span>...</span>';
			}
			if ($this->type == 3) {
				$cell = '<img src="'.BASE_URL.'/public/images/delete.png" onClick="delete_row('.$idd.', this)"></img>';
			}
			echo('<div class="divCell" id="action">'.$cell.'</div>');
		echo('</div>');
		}
	echo('</div>');
} else {
	echo ("<h3>No data in database.</h3>");
}
?>
</br></br>
<?php
if ($_SESSION['user']['user_type']==3) {
	echo('<div class="add">');
	   	echo('<form action="'.BASE_URL.'/home/projects" method="post" >');
	        echo('<label for="title">Title</label></br>');
	        echo('<input type="text" name="title" placeholder="Title" id="title"/><br />');
	        echo('<label for="subject">Subject</label></br>');
	        echo('<textarea name="subject" placeholder="Subject" id="subject"></textarea><br />');
	        echo('<label for="max_note">Max note</label></br>');
	        echo('<input type="number" name="max_note" /><br />');
	        echo('<label for="max_studs">Nr. max of studs</label></br>');
	        echo('<input type="number" name="max_studs" /><br />');
	        echo('<input type="submit" name="add_project" value="Add project" />');
	    echo('</form>');
	echo('</div>');
}
?>

</body>
</html>