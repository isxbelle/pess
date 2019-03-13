<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dispatch Petrol Car</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>		
<?php include 'head.php'; ?>	
</head>

<body>
<?php 	
session_start();
$uname = $_SESSION['username'];
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
if(!$conn)
{
	die("Cannot connect to database:". mysql_error());
}
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

?>	
	
<fieldset>
<legend>Dispatch Patrol Cars</legend>
<form name="DispatchForm" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
<table align="center">


	<tr>
	<td>Caller Name:</td>
	<td><p><?php echo $_POST["callerName"];?></p></td>
	</tr>

	<tr>
	<td>Contact No:</td>
	<td><p><?php echo $_POST["contactNo"];?></p></td>
	</tr>

	
	<tr>
	<td>Location:</td>
	<td><p><?php echo $_POST["location"];?></p></td>
	</tr>
	

	<tr>
	<td align="right" class="td_label">Incident Type:</td>
	<td class = "td_Date">
	<p name="incidenttype"> <?php echo $_POST["incidenttype"];?></p>
	</td>
	</tr>
	

	<tr>
	<td>Description:</td>
	<td><p><textarea name="incidentDesc" rows="5" cols="50" readonly><?php echo $_POST["callerName"];?></textarea></p></td>
	</tr>
	
	<tr>
	<td colspan="2"></td>
	</tr>
	
	
<?php
	
	$incidentArray;
	$count=0;
	$sql = "SELECT patrolcarId, statusDesc FROM patrolcar JOIN patrolcar_status ON patrolcar.patrolcarStatusId=patrolcar_status.statusId WHERE patrolcar.patrolcarStatusId='2' OR patrolcar.patrolcarStatusId='3'";
	$result = mysqli_query($conn,$sql) or die (mysql_error($sql));
	while($patrolcar = mysqli_fetch_array($result))
	{$patrolcarArray[$count]=$patrolcar;
	 $count++;
	}
	

?>
	
</table>
</form>

<form name="DispatchForm" id="DispatchForm" method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
<table width="40%" border="1" align="center" cellpadding="4" cellspacing="8">
  <tbody>
    <tr>
      <td width="20%">&nbsp;</td>
      <td width="51%">Patrol Car ID</td>
      <td width="29%">Status</td>
    </tr>
	    
<?php $i=0; while($i<$count){ ?>
	  
	  
<tr>
	
	<td class="td_label"><input type="checkbox" name="chkPatrolcar[]" value="<?php echo $patrolcarArray[$i]['patrolcarId'] ?>"></td>	
	<td><?php echo $patrolcarArray[$i]['patrolcarId']?></td>
	<td><?php echo $patrolcarArray[$i]['statusDesc']?></td>
	
<?php $i++; } ?>
</tr>  
</tbody>
</table>

	
<table width="80%" border="0" align="center" cellpadding="4" cellspacing="4">
<td width="46%" class="td_label"><input type="reset" style="margin-left: 530px;" name="btnCancel" id="btnCancel" value="Reset"></d>
<td width="54%" class="td_Data"><input type="submit" id="btnSubmit" name="btnSubmit" value="Submit">
</td>	
</table>	
</form>	
	
	
<?php
	
if(isset($_POST["btnSubmit"]))
{// Update patrolcar status table and dispatch table
	$patrolcarDispatched = $_POST["chkPatrolcar"];
	$c = count($patrolcarDispatched);
	mysqli_select_db($conn,"3_isabelle_pessdb");
	
	// Insert new incident
	$status;
	if($c > 0)
	{
		$status='2';
	}
	else
	{
		$status='1';
	}
	
	// Retrieve new incremental key for incidentId
	 $incidentId = mysqli_insert_id($conn);
	
	   for($i =0; $i < $c; $i++)
	   {
	 	$sql= "UPDATE patrolcar SET patrolcarStatusId ='1' WHERE patrolcarId='$patrolcarDispatched[$i]'";
		
		if(mysqli_query($conn, $sql) == true)
		{
			echo("Record was updated successfully.");
			header("Location: logcall.php");
	       
		}
		  else
		  {
			echo ("ERROR: Could not able to execute.".mysqli_error($conn));  
		  };
		
		$sql= "INSERT INTO dispatch(incidentId, patrolcarId, timeDispatched) VALUES('$incidentId', '$patrolcarDispatched[$i]', NOW())";
		
		if(mysqli_query($conn, $sql) == true)
		{
			echo("Record was updated successfully.");
		}
		   else
		   {
			   echo ("ERROR: Could not able to execute.".mysqli_error($conn));  
		   };
	mysqli_close($conn);}}
	

?>

</fieldset>
</body>
</html>