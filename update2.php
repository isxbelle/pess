<!doctype html>
<html><head>
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
$conn = mysqli_connect("localhost", "$username", "$password",$databaseName);	
	
	$sql = "SELECT * FROM patrolcar WHERE patrolcarId='".$_POST['patrolcarId']."'";
	
	$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	
	
	$patrolcarStatusId;
	$patrolcarId;
	
		
	while($row=mysqli_fetch_array($result))
	{
		
		$patrolcarId = $row['patrolcarStatusId'];
		$patrolcarStatusId = $row['patrolcarStatusId'];
	}
	
	
	$sql = "SELECT * FROM patrolcar_status";
	
	$result=mysqli_query($conn, $sql);
	
	$patrolCarStatusMaster;
	while($row = mysqli_fetch_array($result))
	{
		// statusId, statusDesc
		// Create an associative array of patrol car status master type
		$patrolCarStatusMaster[$row['statusId']] = $row['statusDesc'];
	}
				
//End//
?>
<!-- Display a form to update patrol car status also update incident status when patrol car status is FREE -->
	
<form name="form2" id="form2" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
<fieldset>
<legend>Update Patrol Car</legend>
<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
<tr>
<td width="25%" class="td_label">Patrol Car ID:</td>
<td width="25%" class="td_Data"><?php echo $_POST["patrolcarId"]?></td>
<input type="hidden" name="patrolcarId" id="patrolcarId" value="<?php echo $_POST["patrolcarId"]?>">
</tr>
	
<tr>
	<td class="td_label">Status:</td>
	<td class="td_Data">
	<select name="patrolcarStatusId" id="patrolcarStatusId">
	<?php foreach($patrolCarStatusMaster as $key => $value){?>
	<option value="<?php echo $key?>"
	<?php if($key == $patrolcarStatusId) {?> selected="selected"
	<?php }?>>
	<?php echo $value ?>
	</option>
	<?php } ?>		
	</select>
	</td>
</tr>
</br>
<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
<tr>
<td width="46%" class="td_label"><input type="reset" onClick="window.location='update1.php'" name="btnCancel" id="btnCancel" value="Reset"></td>	
<td width="54%" class="td_Data"><input type="submit" name="btnUpdate" id="btnUpdate" value="Update">
</td>
</tr>
</table>
</fieldset>
</form>	



<?php

if(isset($_POST["btnUpdate"])){
	// Retrieve patrol car status and patrolcarstatus
	// Connect to a database
	$conn = mysqli_connect("localhost", "$username", "$password",$databaseName);
	if(!$conn)
	{
		die('Cannot connect to database:' .mysqli_error());
	}

	mysqli_select_db($conn,"3_isabelle_pessdb");
	$sql2 = "UPDATE patrolcar SET patrolcarStatusId = '".$_POST['patrolcarStatusId']."' WHERE patrolcarId = '".$_POST['patrolcarId']."'";
	$result2 = mysqli_query($conn,$sql2);;


	 if(!$result2) 
	 {
       die('Could not update data: ' . mysqli_error());
     }
else
	{
       echo "Updated data successfully\n";
	   header("location: update1.php");
	}
	
if(!mysqli_query($conn, $sql))
	{
		die('Error4:' .mysqli_error());
	}
	
	// If patrol car status is on-site(4) then capture the time of arrival 
	
	if($_POST["patrolcarStatusId"] =='4')
	{
	
	$sql="UPDATE dispatch SET timeArrived=NOW() WHERE timeArrived is NULL AND patrolcarId='".$_POST["patrolcarId"]."'";
	}
	if(!mysqli_query($conn, $sql))
	{
		die('Error4:' .mysqli_error());
	}
}

	else if ( $_POST["patrolcarStatusId"] == '3'){
		
	$sql="SELECT incidentId FROM dispatch WHERE timeCompleted IS NULL AND patrolcarId='".$_POST["patrolcarId"]."'";
		
	$result=mysqli_query($conn, $sql);
	
	$incidentId;	
		
	while($row=mysqli_fetch_array($conn,$sql))
	{	$sql="UPDATE incident SET incidentStatusId='3' WHERE incidentId='$incidentId' AND incidentId NOT IN (SELECT incidentId FROM dispatch WHERE timeCompleted IS NULL)";
	
	// patrolcarId, patrolcatStatusId
	echo $incidentId;
		
	//Now then can update dispatch
	$sql="UPDATE dispatch SET timecompleted=NOW() WHERE timeCompleted is NULL AND patrolcarId='".$_POST["patrolcarId"]."'";
		
	if(!mysqli_query($conn, $sql))
	{
		die('Error4:' .mysqli_error());
	}
		
	// Last but not least, update incident in incident table to completed (3) all patrol car attended it are FREE now
		
	$sql="UPDATE incident SET incidentStatusId='3' WHERE incidentId='$incidentId' AND incidentId NOT IN (SELECT incidentId FROM dispatch WHERE timeCompleted IS NULL)";
		
	if(!mysqli_query($conn, $sql))
	{
		die('Error5:' .mysqli_error());
	}
}
	}


mysqli_close($conn);
?>
	


</body>
</html>