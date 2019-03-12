<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Log Call</title>
<?php include 'head.php'; ?>
</head>
<style>
body
	
{
		background-image: url("backgroud.jpg");
}
	
</style>
	
<body>
	
<?php
session_start();	
unset($_SESSION['username']);
session_destroy();




	
$servername = "localhost";
$username = "Isabelle";
$password = "12345";
$databaseName ="3_isabelle_pessdb";


	
$conn = mysqli_connect($servername,$username,$password,$databaseName);
mysqli_select_db($conn,"3_isabelle_pessdb");


	
?>
	

<fieldset>
<legend>Sign Out</legend>
<h1 align="center"><a href="login.php">Click here to go back to Sign In</a></h1>
</fieldset>
</body>
</html>