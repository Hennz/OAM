var BASE_URL = "http://www.myprograming.esy.es";
document.addEventListener("DOMContentLoaded", function(event) { 
 	

});

function changeLogReg(x){
	var temp = document.getElementsByClassName("buttons")[0].getElementsByTagName("span");
	if (x==0){
		document.getElementsByClassName("login")[0].style.display = "block";
		document.getElementsByClassName("register")[0].style.display = "none";
	} else {
		document.getElementsByClassName("login")[0].style.display = "none";
		document.getElementsByClassName("register")[0].style.display = "block";
	}
}

function register_validation() {
	var result = true;
	document.getElementById('username').style.borderColor = "#fff";
	document.getElementById('email').style.borderColor = "#fff";
	document.getElementById('password').style.borderColor = "#fff";
	document.getElementById('rpassword').style.borderColor = "#fff";
	document.getElementsByClassName('page_messages')[0].innerHTML=""
	document.querySelector('.page_messages').innerHTML = "";
	var email = document.querySelector('#email').value;
	if ((email == "undefined") || (email.length == 0)) {
		document.querySelector('#email').style.borderColor = "#f00";
		var temp = document.createElement('p');
		temp.innerHTML = '<p>error - E-mail is required!</p>';
		document.querySelector('.page_messages').appendChild(temp);
		result = false;
	}
	if (!validateEmail(email)) {
		document.querySelector('#email').style.borderColor = "#f00";
		var temp = document.createElement('p');
		temp.innerHTML = '<p>error - E-mail must be valide!</p>';
		document.querySelector('.page_messages').appendChild(temp);
		result = false;
	}
	var username = document.querySelector('#username').value;
	if ((username == "undefined") || (username.length == 0)) {
		document.querySelector('#username').style.borderColor = "#f00";
		var temp = document.createElement('p');
		temp.innerHTML = '<p>error - Username is required!</p>';
		document.querySelector('.page_messages').appendChild(temp);
		result = false;
	}
	var password = document.querySelector('#password').value;
	if ((password == "undefined") || (password.length == 0)) {
		document.querySelector('#password').style.borderColor = "#f00";
		var temp = document.createElement('p');
		temp.innerHTML = '<p>error - Password is required!</p>';
		document.querySelector('.page_messages').appendChild(temp);
		result = false;
	}
	if ((password.length < 4) || (password.length > 20)) {
		document.querySelector('#password').style.borderColor = "#f00";
		var temp = document.createElement('p');
		temp.innerHTML = '<p>error - Password must be between 4 and 20 caharacters!</p>';
		document.querySelector('.page_messages').appendChild(temp);
		result = false;
	}
	var rpassword = document.querySelector('#rpassword').value;
	if ((rpassword == "undefined") || (rpassword.length == 0)) {
		document.querySelector('#rpassword').style.borderColor = "#f00";
		var temp = document.createElement('p');
		temp.innerHTML = '<p>error - Confirm password is required!</p>';
		document.querySelector('.page_messages').appendChild(temp);
		result = false;
	}
	if (password !== rpassword) {
		document.querySelector('#password').style.borderColor = "#f00";
		document.querySelector('#rpassword').style.borderColor = "#f00";
		var temp = document.createElement('p');
		temp.innerHTML = '<p>error - Password does not match the confirm password!</p>';
		document.querySelector('.page_messages').appendChild(temp);
		result = false;
	}
	// if (result) {
	// 	var params="email="+email;
	// 	xmlhttp=new XMLHttpRequest();
	// 	xmlhttp.open("POST",BASE_URL+"/ajax/alreadyExist",true);
	// 	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	// 	xmlhttp.onreadystatechange=function() {
	//   		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	// 	    	var response = xmlhttp.responseText;
	// 	    	if (response=='true') {
	// 	    		document.querySelector('#email').style.borderColor = "#f00";
	// 	    		var temp = document.createElement('p');
	// 				temp.innerHTML = '<p>error - E-mail already exist.</p>';
	// 				document.querySelector('.page_messages').appendChild(temp);
	// 				return false;
	// 	    	} 
	// 	    	else {
	// 	    		console.log("OK");
	// 	    		return true;
	// 	    	}		
	// 	    }
	//   	}
	// 	xmlhttp.send(params);
	// }
	return result;
}

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function changeUserType(val) {
	if (val==1){
		document.getElementsByClassName("student_details")[0].style.display = "block";
		document.getElementsByClassName("teacher_details")[0].style.display = "none";
	} else {
		document.getElementsByClassName("student_details")[0].style.display = "none";
		document.getElementsByClassName("teacher_details")[0].style.display = "block";
	}
}

