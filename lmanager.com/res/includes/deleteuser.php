<?php 
session_start();
if($_SESSION['user']!='admin')
{
    echo 'You are not authorized to view this page';
    die();
} 
include_once "classes/objects/class.user.php";
include_once('classes/objects/class.database.php');
if(isset($_GET['userid']))
{
	$flag=0;
	$query="select a.serialno, b.title, b.author, b.isbn, c.duedate from
            issues c, book_trans a, book_master b where a.isbn=b.isbn and
            c.userid='".$_GET['userid']."' and 
            c.serialno=a.serialno and c.returndate='0000-00-00'";
    $connection=Database::connect();
    $cursor = Database::Reader($query, $connection);
	while ($row = Database::Read($cursor))
		{
			$flag=1;
		}
	if($flag==1)
	{
		echo 'Cannot delete user there are pending issues to return';
	}
	else
	{
		$connection = Database::connect();
        $query="select a.serialno, c.slno, a.status from
                     book_trans a, reservation c where 
                     c.userid='".$_GET['userid']."' and c.serialno=a.serialno";
        $cursor = Database::Reader($query, $connection);
					while ($row = Database::Read($cursor))
					{
						$serialno=$row['serialno'];
						if($row['status']==2)
						{
							$query="update book_trans set status='1' where serialno='".$serialno."'";
							Database::Query($query,$connection);
						}
						$query="delete from reservation where slno='".$row['slno']."'";
						Database::Query($query,$connection);
						echo 'Reservation made by the user is deleted <br />';
					}
		$query="delete from user where userid='".$_GET['userid']."'";
		Database::Query($query,$connection);
		echo 'User Deleted Successfully';
	}

}
