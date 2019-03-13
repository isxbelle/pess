<!doctype html>
<html><head>
<meta charset="utf-8">
<title>Log Call</title>
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
$username = "belle";
$password = "12345";
$databaseName ="3_isabelle_pessdb";


	
$conn = mysqli_connect($servername,$username,$password,$databaseName);
mysqli_select_db($conn,"3_isabelle_pessdb");


	if(isset($_POST['save']))
{	 
	 $callerName = $_POST['callerName'];
	 $phoneNumber = $_POST['contactNo'];
	 $incidentTypeId = $_POST['incidenttype'];
	 $incidentLocation = $_POST['location'];
	 $incidentDesc = $_POST['incidentDesc'];
	 mysqli_query($conn,"INSERT INTO incident(callerName,phoneNumber,incidentTypeId,incidentLocation,incidentDesc) 
	 values ('$callerName','$phoneNumber','$incidentTypeId','$incidentLocation','$incidentDesc')") or die(mysqli_error($conn));
}
	
 		 $result = mysqli_query($conn,"SELECT*FROM incidenttype"); 
         $incidenttype;
         while($row = mysqli_fetch_array($result))
         {
			$incidenttypes[$row['incidentTypeId']] = $row['incidentTypeDesc'];
         }   	
	

	
?>
	
<form name="frmLogCall" method="post" onSubmit="return validateForm()" action="dispatched.php">
<fieldset>
<legend>Log Call</legend>
	<table align="center">

<tr>
	<td>Caller Name:</td>
	<td><p><input type="text" name="callerName" /></p></td>
</tr>
<tr>
	<td>Contact No:</td>
	<td><p><input type="number" name="contactNo" /></p></td>
</tr>
<tr>
	<td>Location:</td>
	<td><p><input type="text" name="location" /></p></td>
</tr>
	
<tr>
	
	<td align="right" class="td_label">Incident Type:</td>
	<td class = "td_Date">
	<p>
	<select name="incidenttype">
	<?php
	$result = mysqli_query($conn,"SELECT * FROM incidenttype"); 	
	foreach($incidenttypes as $key => $value){?>
	<option value="<?php echo $key ?>"
	<?php if($key == $incidenttypes) {?> selected="selected"
	<?php } ?>><?php echo $value ?></option>
	
	<?php
	}
	
	?>
	</select>
	</p>
	</td>
</tr>
<tr>
	<td>Description:</td>
	<td><p><textarea name="incidentDesc" rows="5" cols="50" ></textarea></p></td>
</tr>
<tr>
	<td align="center" colspan="2"><button type="reset" style="margin-right: 50px;">Reset</button>  <button name="save" type="submit" style="margin-left: 50px;">Submit</button></td>
	<td align="center"></td>
</tr>

</table>
</fieldset>
</form>
<script>
function validateForm() {
  var a = document.forms["frmLogCall"]["callerName"].value;
  var b = document.forms["frmLogCall"]["contactNo"].value;
  var c = document.forms["frmLogCall"]["location"].value;
  var d = document.forms["frmLogCall"]["incidentDesc"].value;
 
  if (a == "") 
  {
    alert("Name must be filled out");
    return false;
  }
   
	else if  (b == "")
{
	
	alert("Contact Number must be filled out")
	return false;
}

	else if (c == "")
{	alert("Location must be filled out")
 	return false;
}
	else if (d == "")
	{
		alert("Please describe your incident")
		return false;
	}
else
{
	return true;
}	
}
</script>
</body>
</html>