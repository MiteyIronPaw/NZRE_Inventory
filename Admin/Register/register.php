<?php
ob_start();
session_start();
//Check if session is admin.
if(!$_SESSION['admin']){
	header("location:/Ingress");
}else{
	// Connect to server and select databse.
	include "/var/www/Ingress/Tools/database.php";
	include "/var/www/Ingress/Tools/log.php";

	// Define $myusername and $mypassword  and protect againest MYSQL injection
	$myusername=stripslashes(str_replace ("&#65279","",$_POST['TheUserName']));
	$mypassword=md5($_POST['ThePassword3']);
	$mypassword2=md5($_POST['ThePassword2']);
	$level=stripslashes($_POST['Level']);

	//See if passwords match
	if($mypassword==$mypassword2){

		//See if user name is taken
		$sql="SELECT * FROM AgentTable WHERE username='$myusername'";
		$result=mysqli_query($con,$sql);
		$count=mysqli_num_rows($result);

		// If count equals 0 the username isn't taken
		if($count==0){
			if($level!=null){
				//Add password and user to data base
				mysqli_query($con,"insert into AgentTable values('$myusername','$mypassword',false,$level,0,0);");
				mysqli_query($con,"insert into ItemTable values('$myusername',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'Never',0);");
				//Go to tools page
				LogText("User ".$_SESSION['name']." Registered ".$myusername);
				header("location:/Ingress/Admin");
			}else{
				echo "Requies lvl";
			}
		}
		else {
			echo "User name taken";
		}
	}
	else{
		echo "Passwords don't match";
	}
}
?>
