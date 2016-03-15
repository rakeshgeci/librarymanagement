<?php
include_once '../classes/objects/class.book_master.php';
include_once "../classes/objects/class.category.php";
require_once "../classes/objects/class.book_trans.php";
include_once('../classes/objects/class.database.php');
session_start();
if($_SESSION['user']=='student'||$_SESSION['user']=='faculty')
{}else{
	
    echo 'No access';
 die();
} 
?>
<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../css/table2.css" />
        <link rel="stylesheet" type="text/css" href="../../css/request.css" />
        <script type="text/javascript" src="../../js/jquery-2.1.1.js"></script>
    </head>
    <body>
    <h3>Issued Books</h3>	
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
                            Isbn
                        </td>
                        <td>
                            Author
                        </td>
                        <td>
                            Duedate
                        </td>
                        <td>
                        	Fine
                        </td>
                    </tr>
                    <?php

                    $connection = Database::connect();
                    $query="select a.serialno, b.title, b.author, b.isbn, c.duedate from
                    issues c, book_trans a, book_master b where a.isbn=b.isbn and
                     c.userid='".$_SESSION['userid']."' and c.serialno=a.serialno and c.returndate='0000-00-00'";
                    // echo $query;
                    $cursor = Database::Reader($query, $connection);
					while ($row = Database::Read($cursor))
					{
						$fine=0;
						$serialno=$row['serialno'];
						$title=$row['title'];
						$author=$row['author'];
						$isbn=$row['isbn'];
						$duedate=$row['duedate'];
						$d = date('Y-m-d');
			
						$time1 = strtotime($d);
						$time2 = strtotime($duedate);
						$diff = $time1-$time2;
						$diff=$diff/86400;
						if($diff<1) $fine=0;
						
						else
							{
								$type=0;
								switch ($_SESSION['user']) {
									case 'student': $type=3;
										# code...
										break;
									case 'faculty': $type=2;
										# code...
										break;
									default:
										# code...
										break;
								}
							$query="SELECT value from adminsettings where type='$type' and field='fine'";
				
							$cursor = Database::Reader($query, $connection);
    						while ($row = Database::Read($cursor))
								$fine=$row['value'];
							$fine=$fine*$diff;

							}
						?>
						<tr>
							<td>
								<?php echo 'CSED-'.$serialno; ?>
							</td>
							<td>
								<?php echo $title; ?>
							</td>
							<td>
								<?php echo $isbn; ?>
							</td>
							<td>
								<?php echo $author; ?>
							</td>
							<td>
								<?php echo $duedate; ?>
							</td>
							<td>
								<?php echo $fine; ?>
							</td>
						</tr>
						<?php
					
					}


                    ?>


                    </table>

                </div>

                <h3>Reserved Books</h3>	
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
                            Isbn
                        </td>
                        <td>
                            Author
                        </td>
                        <td>
                            Status
                        </td>
                      </tr>
                    <?php

                    $connection = Database::connect();
                    $query="select a.serialno, a.status, b.title, b.author, b.isbn from
                     book_trans a, book_master b, reservation c where a.isbn=b.isbn and
                     c.userid='".$_SESSION['userid']."' and c.serialno=a.serialno";
                    $cursor = Database::Reader($query, $connection);
					while ($row = Database::Read($cursor))
					{
						$fine=0;
						$serialno=$row['serialno'];
						$title=$row['title'];
						$author=$row['author'];
						$isbn=$row['isbn'];
						$status=$row['status'];
						switch ($status) {
							case '1':
								$status='On Shelf';
								break;
							case '2':
								$status='Reserved';
								break;
							case '3':
								$status='On Loan';
								break;
							default:
								# code...
								break;
						}
						?>
						<tr>
							<td>
								<?php echo 'CSED-'.$serialno; ?>
							</td>
							<td>
								<?php echo $title; ?>
							</td>
							<td>
								<?php echo $isbn; ?>
							</td>
							<td>
								<?php echo $author; ?>
							</td>
							<td>
								<?php echo $status; ?>
							</td>
						</tr>
						<?php
					
					}


                    ?>




                </table>
                </div>
    </body>

</html>