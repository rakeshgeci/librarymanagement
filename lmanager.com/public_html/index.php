<?php
include_once "../res/includes/classes/objects/class.user.php";
session_start();

if(isset($_POST['userid']))
{
    $userlogged = new user();
    $userlogged->Get($_POST['userid'],md5($_POST['password'])); 
    switch ($userlogged->checkType()) {
        case 1:
            $_SESSION['user']='admin';
            $_SESSION['userid']=$_POST['userid'];
            break;
        case 2:
            $_SESSION['user']='faculty';
            $_SESSION['userid']=$_POST['userid'];
            break;
         case 3:
            $_SESSION['user']='student';
            $_SESSION['userid']=$_POST['userid'];
            break;
        default:
            ?>
            <script type="text/javascript">alert('Invalid username/password');</script>
            <?php
            break;
    }
}

if(!isset($_SESSION['user']))
		$_SESSION['user']='login';
switch ($_SESSION['user']) {
	case 'admin':
		header('Location: admin.php');
                die();
		break;
	case 'faculty':
		header('Location: normal.php');
       // echo 'Faculty';
         die();
		break;
    case 'student':
        header('Location: normal.php');
        //echo 'Student';
        die();
        break;
	default:
		include('login.php');
		break;
}


?>
