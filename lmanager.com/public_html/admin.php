<?php
session_start();
if($_SESSION['user']!='admin')
{
    header('Location: index.php');
    die();
} 
$url='../res/includes/viewbooks.php';
if(isset($_GET['loc']))
{
switch ($_GET['loc']) {
    //case 'home': $url='../res/includes/adminhome.php';


        //break;
    case 'adduser' : $url='../res/includes/adduser.php';
        break;
    case 'viewuser' : $url='../res/includes/viewuser.php';
        break;
    case 'requests' : $url='../res/includes/userrequests.php';
        break;
    case 'managecategory' : $url='../res/includes/managecategory.php';
         break;
     case 'addbooks' : $url='../res/includes/addbooks.php';
         break;
       case 'viewbooks' : $url='../res/includes/viewbooks.php';
         break;
    case 'reports': $url='../res/includes/reports.php';
    	break;
    case 'deleteuser': $url='../res/includes/deleteuser.php';
    	break;
    case 'edit': $url='../res/includes/edit.php';
    	break;
    case 'settings': $url='../res/includes/settings.php';
    	break;
    default:
        break;
}
}?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
		<meta charset="utf-8">
		<title>Library Manager - <?php echo  $_SESSION['user']; ?></title>
		<link href="../res/css/style.css" media="screen" rel="stylesheet" type="text/css" />
		<link href="../res/css/iconic.css" media="screen" rel="stylesheet" type="text/css" />
		<script src="../res/js/prefix-free.js"></script>
                <script type="text/javascript" src="../res/js/jquery-2.1.1.js"></script>
              
                <script type="text/javascript" language="javascript"> 
                      //  $('.myIframe').css('height', $(window).height()+'px');
                </script>
                
	</head>

<body>
	<div class="wrap">
	
	<nav>
		<ul class="menu">
			<li><a href="#"><span class="iconic user"></span> Manage User</a>
				<ul>
					<li><a href="admin.php?loc=adduser">Add User</a></li>
					<li><a href="admin.php?loc=viewuser">View/Delete User</a></li>
                </ul>
			</li>
			<li><a href="#"><span class="iconic magnifying-glass"></span> Manage Books</a>
				<ul>
					<li><a href="admin.php?loc=addbooks">Add Book</a></li>
					<li><a href="admin.php?loc=viewbooks">View Book</a></li>
					<li><a href="admin.php?loc=managecategory">Manage Category</a></li>
				</ul>
			</li>
			<li><a href="#"><span class="iconic check"></span>Perform</a>
				<ul>
					<li><a href="admin.php?loc=viewbooks">Issue Book</a></li>
					<li><a href="admin.php?loc=viewbooks">Return Book</a></li>
					<li><a href="admin.php?loc=viewbooks">Remove Book</a></li>
				</ul>
            <li><a href="admin.php?loc=reports"><span class="iconic article"></span>Reports</a></li>
			<li><a href="#"><span class="iconic cog"></span> Admin</a>
				<ul>
					<li><a href="admin.php?loc=edit">Change Password</a></li>
					<li><a href="admin.php?loc=settings">Settings</a></li>
				</ul>
			</li>
                        
                        <li><a href="logout.php"><span class="iconic x"></span> Logout</a></li>
                            
		</ul>
		<div class="clearfix"></div>
	</nav>
        </div>
    <div class="wrap" style="height: 800px" >
        <iframe src="<?php echo $url; ?>" width="100%" height="100%"></iframe> </div>
</body>

</html>