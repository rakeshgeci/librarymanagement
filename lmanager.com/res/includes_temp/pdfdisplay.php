<?php
session_start();
if($_SESSION['user']!='admin')
{
    echo 'You are not authorized to view this page';
    die();
} 
?>
<head><link rel="stylesheet" type="text/css" href="../css/table2.css" />
<link href="../css/style.css" media="screen" rel="stylesheet" type="text/css" />
<style type="text/css">
	
table {
    border-collapse: collapse;
}

table, th, td {
    border: 1px solid black;
}


</style>
</head>
<img src="header.png" height="100px" width="420px" /><br/>
<?php
include_once('classes/objects/class.database.php');
$connection=Database::connect();
if(isset($_GET['user']))
{
	$type=$_GET['type'];
	$due=$_GET['f'];
	if($type==0)
	{
		switch ($due) {
			case '1':

				$query="select a.userid, b.email, b.name, b.phone, a.serialno, b.name, c.title, a.duedate from
				issues a, user b, book_master c, book_trans d where
				a.duedate <= now() and b.userid=a.userid and a.serialno=d.serialno and d.isbn=c.isbn";
				$cursor = Database::Reader($query, $connection);
				$no=1;
				?>
				<h3>List of users with dues</h3>
                <table border=1>
                    <tr>
                        <td>
                            User Id
                        </td>
                        <td >
                            Name
                        </td>
                        <td>
                            Email
                        </td>
                        <td>
                            Phone
                        </td>
                        <td>
                            Book Id
                        </td>
                        <td>
                            Title
                        </td>
                        <td>
                            Duedate
                        </td>
                    </tr>
                    <?php
					while ($row = Database::Read($cursor))
					{
						$userid=$row['userid'];
						$email=$row['email'];
						$phone=$row['phone'];
						$serialno=$row['serialno'];
						$name=$row['name'];
						$title=$row['title'];
						$duedate=$row['duedate'];
						?>
					<tr>
                        <td >
                            <?php echo $userid; ?>
                        </td>
                        <td>
                            <?php echo $name; ?>
                        </td>
                        <td>
                            <?php echo $email; ?>
                        </td>
                        <td>
                            <?php echo $phone; ?>
                        </td>
                        <td>
                            <?php echo $serialno; ?>
                        </td>
                        <td>
                            <?php echo $title; ?>
                        </td>
                        <td>
                            <?php echo $duedate; ?>
                        </td>
                    
						<?php
					}
				break;
			
			default:
				# code...
				break;
		}
	}
}




?>


               
                </table>
            
