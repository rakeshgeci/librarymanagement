<?php
include_once('../classes/objects/class.database.php');
session_start();
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../css/table2.css" />
    </head>
<?php
$connection=Database::connect();
$query="select message, time from notifications where userid='".$_SESSION['userid']."' order by time DESC";
//echo $query;
$cursor = Database::Reader($query, $connection);
?>
<div class="CSSTableGenerator" >
                <table >
                    <tr>
                        <td>
                            Time
                        </td>
                        <td >
                            Message
                        </td>
                    </tr>
<?php
while ($row = Database::Read($cursor))
	{
		?>
		<tr>
                        <td>
                            <?php echo $row['time']; ?>
                        </td>
                        <td >
                            <?php echo $row['message']; ?>
                        </td>
                    </tr>
<?php
		
	}
				
?>
