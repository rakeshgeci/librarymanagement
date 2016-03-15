<?php 
include_once '../classes/objects/class.book_master.php';
include_once "../classes/objects/class.category.php";
require_once "../classes/objects/class.book_trans.php";
include_once('../classes/objects/class.database.php');
session_start();
?> 
<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../css/table2.css" />
        <link rel="stylesheet" type="text/css" href="../../css/request.css" />
        <script type="text/javascript" src="../../js/jquery-2.1.1.js"></script>
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
    	
    elseif($_SERVER['REQUEST_METHOD']=='GET')
    {

    	if(isset($_GET['fun']))
    	{

    		switch ($_GET['fun']) {
    			case 'reserve':
    				reservebook($_GET['serialno']);
    				break;
    			case 'resL':
    				//echo 'RRR';
    				reservebookL($_GET['serialno']);
    			default:
    				# code...
    				break;
    		}
    	}
    }

function reservebookL($serialno)
{
	
	switch ($_SESSION['user']) {
		case 'student':
				$maxres=maxresOf(3);
			# code...
			break;
		case 'faculty':
				$maxres=maxresOf(2);
			# code...
			break;
		default:
			# code...
			break;
	}
	$connection=Database::connect();
	
	$query="select count(*) from reservation where userid='".$_SESSION['userid']."'";
	
	$cursor = Database::Reader($query, $connection);
						$row=mysql_fetch_row($cursor);
	if($row[0]>=$maxres)
		echo 'You cannot reserve more';
	else
	{
	$query="select count(*) from reservation where serialno='".$serialno."'";
	
	$cursor = Database::Reader($query, $connection);
						$row=mysql_fetch_row($cursor);
	if($row[0]>0)
	{
		echo 'Sorry someone else were here first';
	}
	else
	{
	$query="select userid from issues where serialno='".$serialno."' and `returndate`='00000000'";
	//echo $query;
	$cursor = Database::Reader($query, $connection);
						$row=mysql_fetch_row($cursor);
	//echo $row[0];
	if($row[0]==$_SESSION['userid'])
	{
		echo 'You cannot reserve a book which is issued to you';
	}
	else
	{
	$query="insert into reservation (userid, serialno) values ('".$_SESSION['userid']."','".$serialno."')";
	Database::InsertOrUpdate($query,$connection);
	echo 'Reserved';
	}
	}
	}
}




function reservebook($serialno)
{
	$d=date('Y-m-d');
	switch ($_SESSION['user']) {
		case 'student':
				$maxres=maxresOf(3);
			# code...
			break;
		case 'faculty':
				$maxres=maxresOf(2);
			# code...
			break;
		default:
			# code...
			break;
	}
	$connection=Database::connect();
	
	$query="select count(*) from reservation where userid='".$_SESSION['userid']."'";
	
	$cursor = Database::Reader($query, $connection);
						$row=mysql_fetch_row($cursor);

	if($row[0]>=$maxres)
		echo 'You cannot reserve more';
	else
	{
	$query="insert into reservation (userid, serialno, reservedon) values ('".$_SESSION['userid']."','".$serialno."','".$d."')";
	Database::InsertOrUpdate($query,$connection);
	$query="update book_trans set status=2 where serialno='".$serialno."'";
	Database::InsertOrUpdate($query,$connection);
	echo 'Reserved';
	}
}

function maxresOf($type)
{
	$connection=Database::connect();
	$query="SELECT value from adminsettings where type='$type' and field='books_res'";
    					$cursor = Database::Reader($query, $connection);
    					while ($row = Database::Read($cursor))
												$max=$row['value'];
	return $max;
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
                            Status
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
                        		Available <a href="searchbook.php?serialno=<?php echo $serialno;?>&fun=reserve">Reserve</a>
                        		<?php
                        	}
                        	elseif($status==2)
                        	{
                        		?>
                        		Already Reserved
                        		<?php
                        	}
                        	elseif ($status==3) {?>
                        		On Loan <a href="searchbook.php?serialno=<?php echo $serialno;?>&fun=resL">Reserve</a><?php
                        	}
                        	else
                        		{?>
                        		Not Available<?php
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


