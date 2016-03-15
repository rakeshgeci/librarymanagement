<?php
include_once('../classes/objects/class.database.php');
session_start();
if(isset($_POST['name']))
{
    $userid=$_POST['userid'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $password=$_POST['password'];
    if($password=='')
    {
        $query = "update `user` set 
            `name`='".$name."', 
            `email`='".$email."', 
            `phone`='".$phone."' where `userid`='".$userid."'";
    }
    else
    {
        $query = "update `user` set 
            `password`='".md5($password)."', 
            `name`='".$name."', 
            `email`='".$email."', 
            `phone`='".$phone."' where `userid`='".$userid."'";
    }
    $connection = Database::Connect();
    Database::InsertOrUpdate($query, $connection);
    echo 'User Updated';


}
$query="select * from user where userid='".$_SESSION['userid']."' LIMIT 1";
//echo $query;
$connection=Database::Connect();
$cursor = Database::Reader($query, $connection);
$row=mysql_fetch_assoc($cursor);
//echo $row['name'];
?>

<form method="POST" action="" name="viewuser" id="adduser">
            <input type="hidden" name="formposted" value="true" />
            <table>
                <tr>
                    <td> 
                        <label for="userid" id="useridLabel">User Id</label>
                    </td>
                    <td>
                        <input type="text" readonly="readonly" name="userid" id="userid" value="<?php echo $_SESSION['userid']; ?>">
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="name">Name</label>
                    </td>
                    <td>
                        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" maxlength="50" >
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="Email">Email*</label>
                    </td>
                    <td>
                        <input type="email" id="email" name="email" required="required" value="<?php echo $row['email']; ?>" id="email" maxlength="50">
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="phone">Phone No</label>
                    </td>
                    <td>
                        <input type="text" name="phone" id="phone" value="<?php echo $row['phone']; ?>" maxlength="20">
                    </td>
                </tr>
                <tr>
                    <td>
                        New Password
                    </td>
                    <td>
                        <input type="text" name="password" id="password" maxlength="20">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Change" name="change" id="change">
                    </td>
                </tr>
            </table>
        </form>