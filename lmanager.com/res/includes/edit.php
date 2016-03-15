<?php
session_start();
if($_SESSION['user']!='admin')
{
    echo 'You are not authorized to view this page';
    die();
} 
include_once('classes/objects/class.database.php');
if(isset($_POST['pword']))
{
	$query="update user set password='".md5($_POST['pword'])."' where userid='".$_SESSION['userid']."'";
	$con=Database::Connect();
	Database::InsertOrUpdate($query,$con);
	echo 'password changed Successfully';
}
?>
<html>
<head>
<script type="text/javascript">
	function checkPassword()
	{
		$pword=document.getElementById('pword').value;
		$pword2=document.getElementById('pword2').value;
		if($pword!=$pword2)
			{
				alert('Mismatch');
				return false;
			}
		return true;
	}
</script>
<body>
<form method="POST" action="" onsubmit="return checkPassword()">
<table>
<tr>
<td>Enter new password</td>
<td><input type="password" name='pword' id="pword" required="required"></td>
</tr>
<tr>
<td>Repeat password</td>
<td><input type="password" name='pword2' id="pword2" required="required"></td>
</tr>
<tr>
<td></td>
<td><input type="submit" name='change' value="Change Password"></td>
</tr>
</table>