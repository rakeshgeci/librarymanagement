<?php 
session_start();
if($_SESSION['user']!='admin')
{
    echo 'You are not authorized to view this page';
    die();
} 
include_once 'classes/objects/class.book_master.php';
include_once "classes/objects/class.category.php";
require_once "classes/objects/class.book_trans.php";
include_once('classes/objects/class.database.php');

?> 
<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/table2.css" />
        <link rel="stylesheet" type="text/css" href="../css/request.css" />
        <script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
        <script type="text/javascript">
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes');
}
</script>

     </head>
     <body>

<?php
     	
    	if(isset($_POST['searchbox'])) 
    	{
    		SearchBook($_POST['searchbox']);
    	}
    	elseif (isset($_POST['serialno']))  //issue book
    	{
    		$serialno=str_replace('CSED-', '', $_POST['serialno']);
    		$name='';
    		$type='';
    		$max_books='';
    		//echo '111';
    		$name='';
    		$type=0;
    		$connection = Database::Connect();
    		$query="select * from user where userid='".$_POST['userid']."'";
    		//echo $query;
    		$cursor = Database::Reader($query, $connection);
					while ($row = Database::Read($cursor))
					{
						$name=$row['name'];
						$type=$row['type'];

					}
				
    				if($name=='')
    				{
    					echo 'Invalid UserID';
    					displayAgain($_POST);
    				}
    				else
    				{
    					$connection = Database::Connect();
    					$query="SELECT value from adminsettings where type='$type' and field='due_days'";
    					//echo $query;
    					$cursor = Database::Reader($query, $connection);
    					while ($row = Database::Read($cursor))
												$due_days=$row['value'];
						$query="SELECT value from adminsettings where type='$type' and field='books'";
						//echo $query;
						$cursor = Database::Reader($query, $connection);
    					while ($row = Database::Read($cursor))
    										$max_books=$row['value'];
						$query="SELECT count(*) from `issues` where `userid`='".$_POST['userid']."' and `returndate`='00000000'";
						//echo $query;
						$cursor = Database::Reader($query, $connection);
						$row=mysql_fetch_row($cursor);
						if($max_books>$row[0])
						{
							$d = date('Y-m-d');		
							$duedate = date('Y-m-d', strtotime($d. ' + '.$due_days.' days'));
    						$query="INSERT INTO `issues` (`sno` ,`userid` ,`serialno` ,`issuedate` ,`duedate`) VALUES (NULL , '".$_POST['userid']."', '$serialno',  '$d',  '$duedate')";
    						//echo $query;
    						Database::InsertOrUpdate($query, $connection);
    						$query="UPDATE book_trans set status='3' where serialno='".$serialno."'";
    						//echo $query;
    						Database::InsertOrUpdate($query, $connection);
    						$query="SELECT * FROM reservation where serialno='".$serialno."'";
    						//echo $query;
    						$cursor2 = Database::Reader($query, $connection);
							while($row2 = Database::Read($cursor2))
							{

							$userid=$row2['userid'];
							$slno=$row2['slno'];
							if($userid==$_POST['userid']){
							$query="delete from reservation where slno='".$slno."'";
							mysql_query($query, $connection);}
							//notify user
							}
    						echo 'Book Issued';
						}
						else
						{
							//echo $row[0];
							echo 'User Exceeds Limit';
						}

    				}

    			}
    	


    elseif (isset($_POST['serialno2']))  //Remove Book
    	{
    		$connection = Database::Connect();
    		$serialno=str_replace('CSED-', '', $_POST['serialno2']);
    		$query="UPDATE book_trans set status='4' where serialno='".$serialno."'";
    		Database::InsertOrUpdate($query, $connection);
    		echo 'Book Removed';
    	}
     elseif (isset($_POST['serialno5'])) //Make available
    	{
    		$connection = Database::Connect();
    		$serialno=str_replace('CSED-', '', $_POST['serialno5']);
    		$query="UPDATE book_trans set status='1' where serialno='".$serialno."'";
    		Database::InsertOrUpdate($query, $connection);
    		echo 'Book Added';
    	}
    elseif (isset($_POST['serialno3'])) //return book
    	{
    		$connection = Database::Connect();
    		$serialno=str_replace('CSED-', '', $_POST['serialno3']);
    		$d = date('Y-m-d');
    		$query="UPDATE book_trans set status='1' where serialno='".$serialno."'";
    		Database::InsertOrUpdate($query, $connection);
    		$query2="UPDATE issues set returndate='".$d."', fine='".$_POST['fine']."' where sno='".$_POST['slno']."'";
    		Database::InsertOrUpdate($query2, $connection);
    		$query="SELECT * FROM reservation where serialno='".$serialno."'";
    		//echo $query;
    		$cursor2 = Database::Reader($query, $connection);
			while($row2 = Database::Read($cursor2))
			{

				
				$userid=$row2['userid'];
				$slno=$row2['slno'];
				$d=date('Y-m-d');
				$query="update reservation set reservedon='".$d."' where slno='".$slno."'";
				Database::InsertOrUpdate($query, $connection);
				$query="UPDATE book_trans set status='2' where serialno='".$serialno."'";
    			
				Database::InsertOrUpdate($query, $connection);
				//notify user
				$msg="Book ".$_POST['title3']." has been returned and is reserved for you. Please take the book within 7 days";
				$query="insert into notifications (userid, message) values ('".$userid."','".$msg."')";
				//echo $query;
				Database::InsertOrUpdate($query, $connection);
			}

    		echo 'Book Returned  Fine = '.$_POST['fine'];
    		
    	}
    elseif($_SERVER['REQUEST_METHOD']=='GET')
    {
    	if(isset($_GET['fun']))
    	{
    		switch ($_GET['fun']) {
    			case 'issue':
    				issuebook($_GET['serialno']);
    				break;
    			
    			case 'remove':
    				removebook($_GET['serialno']);
    				break;
				case 'return':
					returnbook($_GET['serialno']);
					break;
				case 'add':
					makeavailablebook($_GET['serialno']);
					break;
				case 'delete':
					deleteBook($_GET['serialno'],$_GET['status']);
    			default:
    				# code...
    				break;
    		}
    	}
    }


function SearchBook($bookid)
{
		?>
		<div class="CSSTableGenerator" >
                <table >
                    <tr>
                        <td>
                            Serial No
                        </td>
                        <td >
                            Title
                        </td>
                        <td>
                            Author
                        </td>
                        <td>
                            Isbn
                        </td>
                        <td>
                            Rack No
                        </td>
                        <td>
                            Perform
                        </td>
                    </tr>
         <?php
		$serialno='';
		$orgbookid=str_replace('CSED-', '', $bookid);
		$connection = Database::Connect();
		$query = "select * from `book_master` a, `book_trans` b where a.isbn=b.isbn and (a.isbn like '%$bookid%' or b.serialno like '$orgbookid%' or a.title like '%$bookid%' or a.author like '%$bookid%') order by b.serialno";
		$cursor = Database::Reader($query, $connection);
		$flag=0;
		while ($row = Database::Read($cursor))
		{
            $serialno = $row['serialno'];
			$isbn = $row['isbn'];
			$author = $row['author'];
			$title = $row['title'];
			$publisher = $row['publisher'];
			$status = $row['status'];
			$rackno=$row['rackno'];
			$re_serialno='<b>'.$bookid.'</b>';
            $re_isbn='<b>'.$bookid.'</b>';
            $re_author='<b>'.$bookid.'</b>';
            $re_title='<b>'.$bookid.'</b>';
            $final_serialno = str_ireplace($bookid, $re_serialno, $serialno);
            $final_isbn = str_ireplace($bookid, $re_isbn, $isbn);
            $final_author = str_ireplace($bookid, $re_author, $author);
            $final_title = str_ireplace($bookid, $re_title, $title);
			$param="'".$serialno."'";
			$flag=1;

			?>
			
  			<tr>
                        <td >
                            <?php echo 'CSED-'.$final_serialno; ?> 
                        </td>
                        <td>
                            <?php echo $final_title; ?>
                        </td>
                        <td>
                            <?php echo $final_author; ?>
                        </td>
                        <td>
                            <?php echo $final_isbn; ?>
                        </td>
                        <td>
                            <?php echo $rackno; ?>
                        </td>
                        <td>
                        	<?php
                        	if($status==1)
                        	{
                        		?>
                        		<a href="searchbook.php?serialno=<?php echo $serialno;?>&fun=issue">Issue Book</a>
                        		<a href="searchbook.php?serialno=<?php echo $serialno;?>&fun=remove">Remove</a>
                        		<a href="searchbook.php?serialno=<?php echo $serialno;?>&fun=delete&status=1">Delete</a>
                        		<?php
                        	}
                        	elseif($status==2)
                        	{
                        		?>
                        		<a href="searchbook.php?serialno=<?php echo $serialno;?>&fun=issue">Issue Reserved Book</a>
                        		<a href="searchbook.php?serialno=<?php echo $serialno;?>&fun=delete&status=2">Delete</a>
                        		<?php
                        	}
                        	elseif ($status==3) {?>
                        		<a href="searchbook.php?serialno=<?php echo $serialno;?>&fun=return"> Return Book</a><?php
                        	}
                        	else
                        		{?>
                        		<a href="searchbook.php?serialno=<?php echo $serialno;?>&fun=add">make it available</a>
                        		<a href="searchbook.php?serialno=<?php echo $serialno;?>&fun=delete&status=1">Delete</a><?php
                        		}
                            ?>
                            
                            
                        </td>
                    </tr>

                        <?php
		}
		if($flag==0)
		{
			?>
			<tr>
				<td colspan="5" style="text-align:center; color:red">No Items Found</td>
			</tr>
			<?php
		}
		?>

		 </table>
         </div>
		<?php
}


function issuebook($bookid)
{
		$connection = Database::Connect();
		$query = "select * from `book_master` a, `book_trans` b where a.isbn=b.isbn and b.serialno = '$bookid' LIMIT 1";
		//echo $query."issuebook 321";
		$cursor = Database::Reader($query, $connection);
		while ($row = Database::Read($cursor))
		{
            $userid='';
            $serialno = $row['serialno'];
			$isbn = $row['isbn'];
			$author = $row['author'];
			$title = $row['title'];
			$status = $row['status'];
			$query="select * from reservation where serialno='$serialno' LIMIT 1";
			//echo $query."issuebook 332";
			$cursor2 = Database::Reader($query, $connection);
			while($row2 = Database::Read($cursor2))
			{

				$userid=$row2['userid'];
			}
			?>
			<form method="POST" action="searchbook.php" onsubmit="return confirm('Do you want to issue book to '+document.getElementById('userid').value)">
				<table>
					<tr>
						<td>Serial No</td>
						<td><input type="text" name="serialno" readonly="readonly" value="<?php echo 'CSED-'.$serialno; ?>"></td>
					</tr>
					<tr>
						<td>Title</td>
						<td><input type="text" name="title" readonly="readonly"  value="<?php echo $title; ?>"></td>
					</tr>
					<tr>
						<td>Isbn</td>
						<td><input type="text" name="isbn" readonly="readonly"  value="<?php echo $isbn; ?>"></td>
					</tr>
					<tr>
						<td>Author</td>
						<td><input type="text" name="author" readonly="readonly"  value="<?php echo $author; ?>"></td>
					</tr>
					<tr>
						<td>UserID</td>
						<td><input type="text" id="userid" name="userid" <?php if($userid!='') { ?>readonly="readonly" <?php } ?> required="required" value="<?php echo $userid; ?>"></td>
					</tr>
					<?php 
						if($userid!='')
						{
							$query="select * from user where userid='$userid' LIMIT 1";
							//echo $query."issuebook 366";
							$cursor3 = Database::Reader($query, $connection);
							while($row3 = Database::Read($cursor3))
							{
							$name=$row3['name'];
							?>
							<tr>
							<td>Name</td>
							<td><input type="text" name="name" readonly="readonly" value="<?php echo $name; ?>"></td>
							</tr>
							<?php
							}
						
						}
						?>
						<tr>
							<td></td>
							<td><input type="submit" value="Issue Book"></td>
						</tr>
				</table>
			</form>


				<?php
		}
}
	
function displayAgain($r)
{
			?>
				<form method="POST" action="" onsubmit="return confirm('Do you want to issue book to'+document.getElementById('userid').value)">
				<table>
					<tr>
						<td>Serial No</td>
						<td><input type="text" name="serialno" readonly="readonly" value="<?php echo $r['serialno']; ?>"></td>
					</tr>
					<tr>
						<td>Title</td>
						<td><input type="text" name="title" readonly="readonly"  value="<?php echo $r['title']; ?>"></td>
					</tr>
					<tr>
						<td>Isbn</td>
						<td><input type="text" name="isbn" readonly="readonly"  value="<?php echo $r['isbn']; ?>"></td>
					</tr>
					<tr>
						<td>Author</td>
						<td><input type="text" name="author" readonly="readonly"  value="<?php echo $r['author']; ?>"></td>
					</tr>
					<tr>
						<td>UserID</td>
						<td><input type="text" name="userid" required="required" value="<?php echo $r['userid']; ?>"></td>
					</tr>
					<tr>
							<td></td>
							<td><input type="submit" value="Issue Book"></td>
						</tr>
				</table>
			</form>
			<?php
}

function removebook($bookid)
{
	$connection = Database::Connect();
		$query = "select * from `book_master` a, `book_trans` b where a.isbn=b.isbn and b.serialno = '$bookid' LIMIT 1";
		$cursor = Database::Reader($query, $connection);
		while ($row = Database::Read($cursor))
		{
            $userid='';
            $serialno = $row['serialno'];
			$isbn = $row['isbn'];
			$author = $row['author'];
			$title = $row['title'];
		}

	?>
	<h3>Do you want to remove this book from the shelf*</h3><br />
	<p>*For permenent deleteion use Delete Book</p>
	<form method='POST' action="searchbook.php">
	<table>
					<tr>
						<td>Serial No</td>
						<td><input type="text" name="serialno2" readonly="readonly" value="<?php echo 'CSED-'.$serialno; ?>"></td>
					</tr>
					<tr>
						<td>Title</td>
						<td><input type="text" name="title2" readonly="readonly"  value="<?php echo $title; ?>"></td>
					</tr>
					<tr>
						<td>Isbn</td>
						<td><input type="text" name="isbn2" readonly="readonly"  value="<?php echo $isbn; ?>"></td>
					</tr>
					<tr>
						<td>Author</td>
						<td><input type="text" name="author2" readonly="readonly"  value="<?php echo $author; ?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="Remove" name="removebook"></td>
					</tr>
	</table>
	</form>
	<?php
}


function makeavailablebook($bookid)
{
	$connection = Database::Connect();
		$query = "select * from `book_master` a, `book_trans` b where a.isbn=b.isbn and b.serialno = '$bookid' LIMIT 1";
		$cursor = Database::Reader($query, $connection);
		while ($row = Database::Read($cursor))
		{
            $userid='';
            $serialno = $row['serialno'];
			$isbn = $row['isbn'];
			$author = $row['author'];
			$title = $row['title'];
		}

	?>
	<h3>Do you want to add this book back to shelf*</h3><br />
	<form method='POST' action="searchbook.php">
	<table>
					<tr>
						<td>Serial No</td>
						<td><input type="text" name="serialno5" readonly="readonly" value="<?php echo 'CSED-'.$serialno; ?>"></td>
					</tr>
					<tr>
						<td>Title</td>
						<td><input type="text" name="title5" readonly="readonly"  value="<?php echo $title; ?>"></td>
					</tr>
					<tr>
						<td>Isbn</td>
						<td><input type="text" name="isbn5" readonly="readonly"  value="<?php echo $isbn; ?>"></td>
					</tr>
					<tr>
						<td>Author</td>
						<td><input type="text" name="author5" readonly="readonly"  value="<?php echo $author; ?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="add" name="Make Book Available"></td>
					</tr>
	</table>
	</form>
	<?php
}


function returnbook($bookid)
{
	$fine=0;
	$connection = Database::Connect();
	$query = "select * from `book_master` a, `book_trans` b where a.isbn=b.isbn and b.serialno = '$bookid' LIMIT 1";
	$cursor = Database::Reader($query, $connection);
	while ($row = Database::Read($cursor))
		{
            $duedate='';
            $userid='';
            $serialno = $row['serialno'];
			$isbn = $row['isbn'];
			$author = $row['author'];
			$title = $row['title'];
			$status = $row['status'];
			$query="select * from issues where serialno='$serialno' and returndate='0000-00-00' LIMIT 1   ";
			$slno=0;
			$cursor2 = Database::Reader($query, $connection);
			while($row2 = Database::Read($cursor2))
			{

				$slno=$row2['sno'];
				$userid=$row2['userid'];
				$duedate=$row2['duedate'];
				$issuedate=$row2['issuedate'];
			}
			$d = date('Y-m-d');
			//echo $d;
			$time1 = strtotime($d);
			$time2 = strtotime($duedate);
			$diff = $time1-$time2;
			$diff=$diff/86400;
			if($diff<1) $fine=0;
			else
			{
				$type=0;
				$query="select type from user where userid='".$userid."'";
				//echo $query.' query1';
				$cursor2 = Database::Reader($query, $connection);
				while($row2 = Database::Read($cursor2))
					{
						$type=$row2['type'];
					}
				$query="SELECT value from adminsettings where type='$type' and field='fine'";
				//echo $query.' query3';
				$cursor = Database::Reader($query, $connection);
    			while ($row = Database::Read($cursor))
								$fine=$row['value'];
				$fine=$fine*$diff;

			}
			?>
			<form method="POST" action="searchbook.php" onsubmit="return confirm('Do you want to return book)">
				<table>
					<tr>
						<td>Serial No</td>
						<input type="hidden" name="slno" value="<?php echo $slno; ?>">
						<td><input type="text" name="serialno3" readonly="readonly" value="<?php echo 'CSED-'.$serialno; ?>"></td>
					</tr>
					<tr>
						<td>Title</td>
						<td><input type="text" name="title3" readonly="readonly"  value="<?php echo $title; ?>"></td>
					</tr>
					<tr>
						<td>Isbn</td>
						<td><input type="text" name="isbn3" readonly="readonly"  value="<?php echo $isbn; ?>"></td>
					</tr>
					<tr>
						<td>Author</td>
						<td><input type="text" name="author3" readonly="readonly"  value="<?php echo $author; ?>"></td>
					</tr>
					<tr>
						<td>UserID</td>
						<td><input type="text" id="userid3" name="userid3" readonly="readonly" value="<?php echo $userid; ?>"></td>
					</tr>
					<tr>
						<td>Issue Date</td>
						<td><input type="text" name="issuedate" readonly="readonly" value="<?php echo $issuedate; ?>"></td>
					</tr>
					<tr>
						<td>Due Date</td>
						<td><input type="text" readonly="readonly" value="<?php echo $duedate; ?>"></td>
					</tr>
					<tr>
						<td>Fine</td>
						<td><input type="text" name='fine' readonly="readonly" value="<?php echo $fine; ?>"></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="Return Book"></td>
					</tr>
				</table>
			</form>


				<?php
		}
}


function deleteBook($serialno,$status)
{
	$connection = Database::Connect();
	switch ($status) {
		case 1:
			$stock=0;
			$isbn='';
			$query="delete from issues where serialno='".$serialno."'";
			//echo $query.' 1';
			mysql_query($query,$connection);
			$query="select isbn from book_trans where serialno='".$serialno."'";
			//echo $query.' 2';
			$cursor = Database::Reader($query, $connection);
			while ($row = Database::Read($cursor))
				{
					$isbn=$row['isbn'];
				}
			$query="delete from book_trans where serialno='".$serialno."'";
			//echo $query.' 3';
			mysql_query($query,$connection);
			$query="select stock from book_master where isbn='".$isbn."'";
			//echo $query.' 4';
			$cursor = Database::Reader($query, $connection);
			while ($row = Database::Read($cursor))
				{
					$stock=$row['stock'];
				}
			$query="update book_master set stock='".($stock-1)."' where isbn='".$isbn."'";
			//echo $query.' 5';
			Database::InsertOrUpdate($query, $connection);
			echo 'Book Successfully Deleted';
			break;
		case 2: 
			$stock=0;
			$isbn='';
			$query="delete from issues where serialno='".$serialno."'";
			//echo $query.' 1';
			mysql_query($query,$connection);
			$query="select isbn from book_trans where serialno='".$serialno."'";
			//echo $query.' 2';
			$cursor = Database::Reader($query, $connection);
			while ($row = Database::Read($cursor))
				{
					$isbn=$row['isbn'];
				}
			$query="select userid from reservation where serialno='".$serialno."'";
			$cursor = Database::Reader($query, $connection);
			while ($row = Database::Read($cursor))
				{
					$userid=$row['userid'];
				}
			$query="delete from reservation where serialno='".$serialno."'";
			mysql_query($query,$connection);
			$msg="Book ".$serialno." has been deleted. Inconvinence regreted.";
			$query="insert into notifications (userid, message) values ('".$userid."','".$msg."')";
			//echo $query;
			Database::InsertOrUpdate($query, $connection);
			$query="delete from book_trans where serialno='".$serialno."'";
			//echo $query.' 3';
			mysql_query($query,$connection);
			$query="select stock from book_master where isbn='".$isbn."'";
			//echo $query.' 4';
			$cursor = Database::Reader($query, $connection);
			while ($row = Database::Read($cursor))
				{
					$stock=$row['stock'];
				}
			$query="update book_master set stock='".($stock-1)."' where isbn='".$isbn."'";
			//echo $query.' 5';
			Database::InsertOrUpdate($query, $connection);
			echo 'Book Successfully Deleted';
			break;
		default:
			# code...
			break;
	}

}

?>

