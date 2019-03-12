<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Update</title>
<?php include 'head.php'; ?>
<style>
body
	
{
		background-image: url("backgroud.jpg");
}
	
</style>
</head>

<body>
	
		
<?php
session_start();
if(isset($_SESSION['username'])) 
{
  echo "Your session is running " . $_SESSION['username'];
 
}

else
{
	header("location: login.php");
}	
	
$servername = "localhost";
$username = "Isabelle";
$password = "12345";
$databaseName ="3_isabelle_pessdb";
	
	
		
$conn = mysqli_connect($servername,$username,$password,$databaseName);
if(!$conn)
{
	die("Cannot connect to database:". mysqli_error());
}
mysqli_select_db($conn,"3_isabelle_pessdb");

//start// 
if(!isset($_POST["btnSearch"]))
{
	
	
?>	
	
<form name="form1" method="post" onSubmit="return validateForm()" action="update2.php">
<fieldset>
<legend>Update Patrol Car</legend>
<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
<tr>
	
<td width="25%" class="td_label">Patrol Car ID:</td>
<td width="25%" class="td_Data"><select name="patrolcarId">
<?php
		$result3 = mysqli_query($conn,"SELECT * FROM patrolcar"); 	
		while($row = mysqli_fetch_array($result3))
	   {
?>
	<option><?php echo $row["patrolcarId"];?></option>";
<?php }
	?>
	
<td class="td_Data"><input type="submit" name="btnSearch" id="btnSearch" value="Search"></td>
</td>
</tr>
</select>
</table>
</fieldset>	
</form>

<?php
}
?>
<!-- Display a form to update patrol car status also update incident status when patrol car status is FREE -->


</body>
</html>