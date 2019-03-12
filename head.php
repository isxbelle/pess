<style>
ul 
{
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #001f4d;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #001433;
}
	
.topbar
{
	background-color: #001f4d;
}

	
</style>
<?php

								  
$servername = "localhost";
$username = "Isabelle";
$password = "12345";
$databaseName ="3_isabelle_pessdb";
$conn = mysqli_connect($servername,$username,$password,$databaseName);
mysqli_select_db($conn,"3_isabelle_pessdb");


								 
?>
<div class="topbar">
	<img src="logo.png" alt="logo">
</div>

<ul>
  <li><a class="active" href="logcall.php">Log Call</a></li>
  <li><a href="update1.php">Update</a></li>
  <li><a href="login.php">Sign In</a></li>
  <li><a href="logout.php">Sign Out</a></li> 
</ul>
