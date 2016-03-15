<?php 
require_once('pdf/fpdf.php');
include_once('classes/objects/class.database.php');

/**
* 
*/
class FPDFONSHELF extends FPDF
{
	
	function Header()
	{
		# code...
		$d=Date('Y/m/d');
		$this->SetFont('Arial','B',15);
		$this->cell(100,10,'NIT CSED LIBRARY - On Shelf Books as on '.$d);
		$this->Ln(25);
		$this->SetFont('Arial','B',10);
		$this->cell(35,10,'Serial No');
		$this->cell(35,10,'Isbn');
		$this->cell(35,10,'Title');
		$this->cell(30,10,'Author');
		$this->Ln();
	}
}


class FPDFUNAVAILABLE extends FPDF
{
	
	function Header()
	{
		# code...
		$d=Date('Y/m/d');
		$this->SetFont('Arial','B',15);
		$this->cell(100,10,'NIT CSED LIBRARY - Removed Books as on '.$d);
		$this->Ln(25);
		$this->SetFont('Arial','B',10);
		$this->cell(35,10,'Serial No');
		$this->cell(35,10,'Isbn');
		$this->cell(35,10,'Title');
		$this->cell(30,10,'Author');
		$this->Ln();
	}
}


/**
* 
*/
class FPDFALLBOOKS extends FPDF
{
	
	function Header()
	{
		# code...
		$d=Date('Y/m/d');
		$this->SetFont('Arial','B',15);
		$this->cell(100,10,'NIT CSED LIBRARY - All Books as on '.$d);
		$this->Ln(25);
		$this->SetFont('Arial','B',10);
		$this->cell(35,10,'Isbn');
		$this->cell(35,10,'Title');
		$this->cell(30,10,'Author');
		$this->cell(20,10,'Publisher');
		$this->cell(35,10,'Category');
		$this->cell(20,10,'Stock');
		$this->Ln();
	}
}


class FPDFONLOAN extends FPDF
{
	
	function Header()
	{
		# code...
		$d=Date('Y/m/d');
		$this->SetFont('Arial','B',15);
		$this->cell(100,10,'NIT CSED LIBRARY - All Books on loan as on '.$d);
		$this->Ln(25);
		$this->SetFont('Arial','B',10);
		$this->cell(35,10,'Serial No');
		$this->cell(35,10,'Isbn');
		$this->cell(35,10,'Title');
		$this->cell(30,10,'Userid');
		$this->cell(30,10,'Name');
		$this->cell(30,10,'Duedate');
		$this->Ln();
	}
}
/**
* 
*/
class FPDFALLUSERS extends FPDF
{
	
	function Header()
	{
		# code...
		$d=Date('Y/m/d');
		$this->SetFont('Arial','B',15);
		$this->cell(100,10,'NIT CSED LIBRARY - All Users as on '.$d);
		$this->Ln(25);
		$this->SetFont('Arial','B',10);
		$this->cell(18,10,'UserId');
		$this->cell(35,10,'Name');
		$this->cell(35,10,'Email');
		$this->cell(30,10,'Phone');
		$this->cell(20,10,'Type');
		$this->Ln();
	}
}

/**
* 
*/
class FPDFWITHFINEUSER extends FPDF
{
	
	function Header()
	{
		# code...
		$d=Date('Y/m/d');
		$this->SetFont('Arial','B',15);
		$this->cell(100,10,'NIT CSED LIBRARY - Users with dues as on '.$d);
		$this->Ln(25);
		$this->SetFont('Arial','B',10);
	
		$this->cell(18,10,'UserId');
		$this->cell(35,10,'Name');
		$this->cell(35,10,'Email');
		$this->cell(15,10,'Type');
		$this->cell(20,10,'Serial No');
		$this->cell(40,10,'Title');
		$this->cell(10,10,'Due Date');
		$this->Ln();
	}
}
if(isset($_GET['usertype']))
{
	switch ($_GET['usertype']) {
		case 'student': $type=3;
			# code...
			break;
		case 'faculty': $type=2;
			# code...
			break;
		default:
			$type=0;
			# code...
			break;
	}
	switch ($_GET['usertype_fine']) {
		case 'withfine': withfineUser($type);
			# code...
			break;
		default:
			allUser($type);
			# code...
			break;
	}
	

}
elseif(isset($_GET['booktype']))
{
	$status=0;
	switch ($_GET['booktype']) {
		case 'onloan': $status=3;
			# code...
			break;
		case 'onshelf': $status=1;
			# code...
			break;
		case 'reserved': $status=2;
			break;
		case 'unv': $status=4;
			break;
		default:
			# code...
			break;
	}

	getBooks($status);
}
else
{
?> 
<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/table2.css" />
        <link rel="stylesheet" type="text/css" href="../css/request.css" />
        <script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
    </head>
    <body>
    		
    			<table style="border:1px solid">
    			<tr style="border:1px solid">
    				
    				<form method="GET" action="">
    				<tr>
    					<td rowspan='3'>User</td>
    					<td><input type="radio" name="usertype" value="student">Student</td>
    					<td><input type="radio" name="usertype_fine" value="withfine">With Dues</td>
    					<td rowspan="3"><input type="submit" value="Generate"></td>
    				</tr>
    				<tr>
    					<td><input type="radio" name="usertype" value="faculty">Faculty</td>
    				</tr>
    				<tr>
    					<td><input type="radio" checked="checked" name="usertype" value="all">All</td>
    					<td><input type="radio" checked="checked" name="usertype_fine" value="all">All</td>
    					<input type="hidden" name="user" value="ok">

    				</tr>
    				<tr><td></td></tr>
    				</form>
    				<form method="GET" action="">
    				<tr>
    					<td rowspan='5'>Book</td>
    					<td colspan="2"><input type="radio" name="booktype" value="onloan">On Loan</td>
    					<td rowspan="5"><input type="submit" value="Generate"></td>
    				</tr>
    				<tr>
    					<td colspan="2"><input type="radio" name="booktype" value="onshelf">On Shelf</td>
    				</tr>
    				<tr>
    					<td colspan="2"><input type="radio"  name="booktype" value="unv">Unavailable</td>
    					
    				</tr>
    				<tr>
    					<td colspan="2"><input type="radio"  name="booktype" value="reserved">Reserved</td>
    					
    				</tr>
    				<tr>

    						<td colspan="2"><input type="radio" checked="checked"  name="booktype" value="all">All</td>
    				</tr>
    				</form>
    			</table>
    		</form>
    </body>
   <?php
}




function withfineUser($type)
{
	$connection=Database::connect();
	if($type==0)
	{
		$query="select a.userid, b.email, b.name, b.type, a.serialno, b.name, c.title, a.duedate from
				issues a, user b, book_master c, book_trans d where
				a.duedate <= now() and a.returndate='0000-00-00' and b.userid=a.userid and a.serialno=d.serialno and d.isbn=c.isbn";
	}
	elseif ($type==2) {
		$query="select a.userid, b.email, b.name, b.type, a.serialno, b.name, c.title, a.duedate from
				issues a, user b, book_master c, book_trans d where
				a.duedate <= now() and a.returndate='0000-00-00' and b.userid=a.userid and a.serialno=d.serialno and d.isbn=c.isbn and b.type='2'";
	}
	else
	{
		$query="select a.userid, b.email, b.name, b.type, a.serialno, b.name, c.title, a.duedate from
				issues a, user b, book_master c, book_trans d where
				a.duedate <= now() and a.returndate='0000-00-00' and b.userid=a.userid and a.serialno=d.serialno and d.isbn=c.isbn and b.type='3'";
	}
		$pdf=new FPDFWITHFINEUSER();
			$pdf->AddPage();
			
		
				$cursor = Database::Reader($query, $connection);
				$no=1;
				$pdf->SetFont('Arial','B',8);
						
				while ($row = Database::Read($cursor))
					{
						$userid=$row['userid'];
						$email=$row['email'];
						$type=$row['type'];
						$serialno=$row['serialno'];
						$name=$row['name'];
						$title=$row['title'];
						$duedate=$row['duedate'];
						// Color and font restoration
    					
					    $pdf->cell(18,10,$userid);
					    $pdf->cell(35,10,$name);
					    $pdf->cell(35,10,$email);
					    if($type==2) $type='Faculty'; elseif ($type==3) {
					    	# code...
					     $type='Student'; } else $type='Admin';
					    $pdf->cell(15,10,$type);
					    $pdf->cell(20,10,'CSED-'.$serialno);
					    $pdf->cell(40,10,$title);
					    $pdf->cell(10,10,$duedate);
					    $pdf->Ln();
					    
				}
		//ob_end_clean();
		$pdf->Output();
	}

function allUser($type)
{
	$connection=Database::connect();
	if($type==0)
	{
		$query="select userid, email, name, phone, type from
				user where type <> 1";
	}
	elseif ($type==2) {
		$query="select userid, email, name, phone, type from
				user where type='2'";
	}
	else
	{
		$query="select userid, email, name, phone, type from
				user where type='3'";
	}
		$pdf=new FPDFALLUSERS();
			$pdf->AddPage();
			
		
				$cursor = Database::Reader($query, $connection);
				$no=1;
				$pdf->SetFont('Arial','B',8);
						
				while ($row = Database::Read($cursor))
					{
						$userid=$row['userid'];
						$email=$row['email'];
						$type=$row['type'];
						$name=$row['name'];
						$phone=$row['phone'];
						// Color and font restoration
    					
					    $pdf->cell(18,10,$userid);
					    $pdf->cell(35,10,$name);
					    $pdf->cell(35,10,$email);
					    $pdf->cell(30,10,$phone);
					    if($type==2) $type='Faculty'; else $type='Student';
					    $pdf->cell(20,10,$type);
					   	$pdf->Ln();
					    
				}
		//ob_end_clean();
		$pdf->Output();
}


function getBooks($status)
{
	switch ($status) {
		case 0:
			getAllBooks();
			break;
		case 1:
			getOnShelfBooks();
			break;
		case 2:
			getReservedBooks();
			break;
		case 3:
			getOnLoanBooks();
			break;
		case 4:
			getUnvBooks();
			break;
		default:
			# code...
			break;
	}
}
function getUnvBooks()
{
	$connection=Database::connect();
	$query="select a.isbn, a.title, a.author, b.serialno from book_master a, book_trans b where b.status=4 and b.isbn=a.isbn";
	$pdf=new FPDFUNAVAILABLE();
			$pdf->AddPage();
			//$pdf->SetFont('Arial','B',10);
		//$pdf->cell(35,10,'Serial No');
		//$pdf->cell(35,10,'Isbn');
		//$pdf->cell(35,10,'Title');
		//$pdf->cell(30,10,'Author');
		//$pdf->Ln();
		
				$cursor = Database::Reader($query, $connection);
				$no=1;
				$pdf->SetFont('Arial','B',8);
						
				while ($row = Database::Read($cursor))
					{
						$isbn=$row['isbn'];
						$title=$row['title'];
						$author=$row['author'];
						$serialno=$row['serialno'];
						// Color and font restoration
    					
					    $pdf->cell(35,10,$serialno);
					    $pdf->cell(35,10,$isbn);
						$pdf->cell(35,10,$title);
						$pdf->cell(30,10,$author);
						$pdf->Ln();
					    
				}
		//ob_end_clean();
		$pdf->Output();
}
function getOnLoanBooks()
{
	$connection=Database::connect();
	$query="select a.isbn, a.title, c.name, b.serialno, d.duedate, d.userid from book_master a, book_trans b, issues d, user c where b.status='3' and b.isbn=a.isbn and b.serialno=d.serialno and c.userid=d.userid";
	$pdf=new FPDFONLOAN();
			$pdf->AddPage();
			//$pdf->SetFont('Arial','B',10);
		//$pdf->cell(35,10,'Serial No');
		//$pdf->cell(35,10,'Isbn');
		//$pdf->cell(35,10,'Title');
		//$pdf->cell(30,10,'Author');
		//$pdf->Ln();
		
				$cursor = Database::Reader($query, $connection);
				$no=1;
				$pdf->SetFont('Arial','B',8);
						
				while ($row = Database::Read($cursor))
					{
						$serialno=$row['serialno'];
						$isbn=$row['isbn'];
						$title=$row['title'];
						$userid=$row['userid'];
						$name=$row['name'];
						$duedate=$row['duedate'];
						
						// Color and font restoration
    					
					    $pdf->cell(35,10,$serialno);
					    $pdf->cell(35,10,$isbn);
						$pdf->cell(35,10,$title);
						$pdf->cell(30,10,$userid);
						$pdf->cell(30,10,$name);
						$pdf->cell(30,10,$duedate);
						$pdf->Ln();
					    
				}
		//ob_end_clean();
		$pdf->Output();
}

function getAllBooks()
{
	$connection=Database::connect();
	$query="select a.isbn, a.title, a.author, a.publisher, b.catname, a.stock from book_master a, category b where a.catid=b.catid";
	$pdf=new FPDFALLBOOKS();
			$pdf->AddPage();
			
		
				$cursor = Database::Reader($query, $connection);
				$no=1;
				$pdf->SetFont('Arial','B',8);
						
				while ($row = Database::Read($cursor))
					{
						$isbn=$row['isbn'];
						$title=$row['title'];
						$author=$row['author'];
						$publisher=$row['publisher'];
						$catname=$row['catname'];
						$stock=$row['stock'];
						// Color and font restoration
    					
					    $pdf->cell(35,10,$isbn);
						$pdf->cell(35,10,$title);
						$pdf->cell(30,10,$author);
						$pdf->cell(20,10,$publisher);
						$pdf->cell(35,10,$catname);
						$pdf->cell(20,10,$stock);
					   	$pdf->Ln();
					    
				}
		//ob_end_clean();
		$pdf->Output();
}


function getOnShelfBooks()
{
	$connection=Database::connect();
	$query="select a.isbn, a.title, a.author, b.serialno from book_master a, book_trans b where b.status=1 and b.isbn=a.isbn";
	$pdf=new FPDFONSHELF();
			$pdf->AddPage();
			//$pdf->SetFont('Arial','B',10);
		//$pdf->cell(35,10,'Serial No');
		//$pdf->cell(35,10,'Isbn');
		//$pdf->cell(35,10,'Title');
		//$pdf->cell(30,10,'Author');
		//$pdf->Ln();
		
				$cursor = Database::Reader($query, $connection);
				$no=1;
				$pdf->SetFont('Arial','B',8);
						
				while ($row = Database::Read($cursor))
					{
						$isbn=$row['isbn'];
						$title=$row['title'];
						$author=$row['author'];
						$serialno=$row['serialno'];
						// Color and font restoration
    					
					    $pdf->cell(35,10,$serialno);
					    $pdf->cell(35,10,$isbn);
						$pdf->cell(35,10,$title);
						$pdf->cell(30,10,$author);
						$pdf->Ln();
					    
				}
		//ob_end_clean();
		$pdf->Output();
}
?>


               
  
            


