<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<?php include 'head.php'?>
<style>
body
	
{
		background-image: url("backgroud.jpg");
}
	
</style>
	
</head>

<body>
	
<?php

$servername = "localhost";
$username = "belle";
$password = "12345";
$databaseName ="3_isabelle_pessdb";


$conn = mysqli_connect($servername,$username,$password,$databaseName);
mysqli_select_db($conn,"3_isabelle_pessdb");

	



if(isset($_POST['login'] )){
		$uname = $_POST["uname"];
		$pword = $_POST["pword"];
		$sql = "SELECT * FROM users WHERE username='$uname' and password='$pword' LIMIT 1";	
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result);

	if($row['username'] == $uname && $row['password'] == $pword){
		echo "Welcome back ,";

		session_start();
		$_SESSION['username'] = $uname;
		echo $_SESSION['username'];
		header("location: logcall.php");

}
	else{
		echo "Failed Incorrect Password / Username";
}
}
								  
?>
	
<form method="post" action="#">
<fieldset>
<legend>Sign in</legend>
	<table align="center">

<tr>
	<td>Username:</td>
	<td><p><input type="text" name="uname" required/></p></td>
</tr>
<tr>
	<td>Password:</td>
	<td><p><input type="password"  name="pword" required><input type="submit" name="login" value="login"/></p></td> 
</tr>
</table>
</fieldset>
</form>
</body>
</html>