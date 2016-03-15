<?php 
session_start();
if($_SESSION['user']=='student'||$_SESSION['user']=='faculty')
{}else{
	
    header('Location: index.php');
 die();
} 

$url='../res/includes/normal/normalhome.php';
if(isset($_GET['loc']))
{
switch ($_GET['loc']) {
    case 'home': $url='../res/includes/normal/normalhome.php';
        break;
    case 'search': $url='../res/includes/normal/viewbook.php';
        break;
    case 'set': $url='../res/includes/normal/settings.php';
        break;
    case 'notify': $url='../res/includes/normal/notifications.php';
        break;
      

    default:
        break;
}
}





 ?>
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
			<li><a href="normal.php?loc=home"><span class="iconic home"></span> Home</a></li>
			<li><a href="normal.php?loc=search"><span class="iconic magnifying-glass"></span>Search Books</a></li>
            <li><a href="normal.php?loc=notify"><span class="iconic at"></span>Notifications</a></li>
            <li><a href="normal.php?loc=set"><span class="iconic cog"></span>Settings</a></li>
            <li><a href="logout.php"><span class="iconic x"></span> Logout</a></li>
                            
		</ul>
		<div class="clearfix"></div>
	</nav>
        </div>
    <div class="wrap" style="height: 800px" >
        <iframe src="<?php echo $url; ?>" width="100%" height="100%"></iframe> </div>
 <?php

 echo $_SESSION['userid'].'thengakola';

 ?>
</body>

</html>