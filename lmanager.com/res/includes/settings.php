<html>
<style type="text/css">
	td{
		border:1px solid;
		width: 50px;
	}
	th{
		border:2px solid;
		width: 50px;
	}
	table
	{
		border:2px solid;
		border-collapse:collapse;
	}
</style>
<?php
session_start();
if($_SESSION['user']!='admin')
{
    echo 'You are not authorized to view this page';
    die();
} 
include_once('classes/objects/class.database.php');

if($_SERVER['REQUEST_METHOD']=='POST')
{
	$query="select * from adminsettings order by type";
	$connection = Database::Connect();
	$cursor = Database::Reader($query, $connection);
	while($row = Database::Read($cursor))
	{
		$type=$row['type'];
		$field=$row['field'];
		$r=$field.$type;
		if($row['value']!=$_POST[$r])
		{
			$query="update adminsettings set value='".$_POST[$r]."'where type='".$type."' and field='".$field."'";
			Database::InsertOrUpdate($query,$connection);
			$query="select userid from user where type='".$type."'";
			$cursor = Database::Reader($query, $connection);
			while($row3 = Database::Read($cursor))
				{
					$msg="The $field value has been changed from ".$row['value']." to ".$_POST[$r];

					$query="insert into notifications (userid, message) values ('".$row3['userid']."','".$msg."')";
					//echo $query;
					Database::InsertOrUpdate($query, $connection);
				}
				//echo $msg;
		}
	}
	//$ffine=$_POST['fine2'];
	//$sfine=$_POST['fine3'];
	//echo $ffine.$sfine;
}
$query="select * from adminsettings order by type";
$connection = Database::Connect();
$cursor = Database::Reader($query, $connection);
?>
<form action="" method="POST">
<table>
<tr>
<th>Type</th>
<th>Field</th>
<th>Value</th>
</tr>
<?php
while ($row = Database::Read($cursor))
	{
		?>
		<tr>
		<?php
		$type = $row['type'];
		$field = $row['field'];
		$value = $row['value'];
		if($type==2)
			{
				?>
				<td>Faculty</td>
				<?php
			}
		else
			{
				?>
				<td>Student</td>
				<?php
			}
		?>
		<td><?php echo $field; ?></td>
		<td><input type="number" name="<?php echo $field.$type; ?>" value="<?php echo $value; ?>" ></td> 
		</tr>
		<?php
	}

?>
<tr><td></td><td></td><td><input type="submit" value="Update"></tr>
</table>
</form>