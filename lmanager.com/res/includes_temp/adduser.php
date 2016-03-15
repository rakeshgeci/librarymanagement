<?php
session_start();
if($_SESSION['user']!='admin')
{
    echo 'You are not authorized to view this page';
    die();
} 
 include_once "classes/objects/class.user.php";
include_once "classes/objects/class.database.php";
require_once "Excel/reader.php"; ?>
<!DOCTYPE HTML>
<html>
    <head><link rel="stylesheet" type="text/css" href="../css/style.css" />
        <script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
    <script>
        function setLabel()
        {
            var label,radValue;
            if(document.getElementById('type').checked)
            {
                radValue=document.getElementById('type').value;
            }
            if(radValue=='faculty') label= 'Faculty ID*'; else label='Student ID*';
            document.getElementById('useridLabel').innerHTML = label;
        }
        
       
        
        function check(input) {
     
                jQuery.ajax({
        type: "GET",
        url: 'validations.php',
        data: {functionname: 'checkuser', arguments: input.value},

        success: function (obj) {
                  //if( !('error' in obj) ) {
                      input.setCustomValidity(obj);
                 // }
                  
            }
}); 

            }


  function checkname(input) {
     
                jQuery.ajax({
        type: "GET",
        url: 'validations.php',
        data: {functionname: 'checkname', arguments: input.value},

        success: function (obj) {
                  //if( !('error' in obj) ) {
                      input.setCustomValidity(obj);
                 // }
                  
            }
}); 

            }
       
</script></head>
   
        <?php 
            if(isset($_POST['formposted']))
            {
                switch ($_POST['type']) {
                    case 'faculty': $type=2;


                        break;
                    case 'student': $type=3;


                        break;

                    default:
                        break;
                }
                $newuser=new user($_POST['userid'], $_POST['password'], $type, $_POST['name'], $_POST['email'], $_POST['phone']);
                $newuser->Save();
                ?><font style="color: red">User <?php echo $_POST['userid']; ?> added successfullly </font><br/>
         <?php            }


    if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['fileuploaded']))
    {
            if ($_FILES["file"]["error"] > 0) {
        echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else {
              if ($_FILES["file"]["type"] == "application/vnd.ms-excel") 
              { 
        //echo "Upload: " . $_FILES["file"]["name"] . "<br>";
       // echo "Type: " . $_FILES["file"]["type"] . "<br>";
       // echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
       // echo "Stored in: " . $_FILES["file"]["tmp_name"];
        move_uploaded_file($_FILES["file"]["tmp_name"],"upload/" . $_FILES["file"]["name"]);
      //  echo "Stored in: " . "upload/" . $_FILES["file"]["name"];


        ?>
        <table>
    <?php
        $userid='';
        $password='';
        $name='';
        $email='';
        $phone='';
        $type='';
         $excel = new Spreadsheet_Excel_Reader();
    
    // read spreadsheet data
    $excel->read('upload/'.$_FILES["file"]["name"]);   
    
    // iterate over spreadsheet cells and print as HTML table
    $x=1;
    $f=0;
    while($x<=$excel->sheets[0]['numRows']) {
        if($f==0) { $f=1; $x++; continue;}
     // echo "\t<tr>\n";
      $y=1;
      while($y<=$excel->sheets[0]['numCols']) {
        $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
        //echo "\t\t<td>$cell</td>\n";  
        switch ($y) {
            case 1:
                $userid=$cell;
                break;
            case 2:
                $password=$cell;
                break;
            case 3:
                $name=$cell;
                break;
            case 4:
                $email=$cell;
                break;
            case 5:
                 $phone=$cell;
                break;
            case 6:
                $type=$cell;
                break;
                          
            default:
                # code...
                break;
        }
        
        $y++;
      } 
      //echo $userid.' '.$password.' '.$name.' '.$email.' '.$phone.' '.$type;
      addUserFromXls($userid,$password,$name,$email,$phone,$type); 
      $x++;
    }

 } else echo 'invalid file type';

    }
        
    }
 ?>
     <body>
     <table>
     <tr><td width="400">
        <form method="POST" action="" name="adduser" id="adduser">
            <input type="hidden" name="formposted" value="true" />
            <table>
                <tr>
                    <td>User Type</td>
                    <td>
                        <input type="radio" name="type" value="faculty" id="type" checked="checked" onchange="setLabel()"/> Faculty 
                        <input type="radio" name="type" value="student" id="type" onchange="setLabel()" /> Student
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="userid" id="useridLabel">Faculty ID*</label>
                    </td>
                    <td>
                        <input type="text" name="userid" id="userid" required="required" maxlength="10" onchange="check(this)" >
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="password">Password*</label>
                    </td>
                    <td>
                        <input type="password" name="password" required="required" maxlength="50" >
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="name">Name*</label>
                    </td>
                    <td>
                        <input type="text" name="name" required="required" maxlength="50" onchange="checkname(this)" >
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="Email">Email*</label>
                    </td>
                    <td>
                        <input type="email" name="email" required="required" id="email" maxlength="50">
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="phone">Phone No</label>
                    </td>
                    <td>
                        <input type="text" name="phone" id="phone" maxlength="20">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" name="Add User" />
                    </td>
                </tr>
            </table>
        </form>
          </td>
          <td>
          Add from xls file
           <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="fileuploaded" value="ok">
               <input type="file" name='file' id='file' required="required" /><input type="submit" name="upload" value="Upload">
           </form> 
          </td>        

        </tr>
        </table>
    </body>
</html>


<?php
function addUserFromXls($userid,$password,$name,$email,$phone,$type)
{
    $query="select * from user where userid='".$userid."'";
    $connection=Database::Connect();
    $cursor = Database::Reader($query, $connection);
        if($row = Database::Read($cursor))
        {
            echo "User $userid alreday exists <br />";
        }
        else
        {
            $newuser=new user($userid, $password, $type, $name, $email, $phone);
        
            $newuser->Save();
            ?><font style="color: red">User <?php echo $userid; ?> added successfullly </font><br />
    <?php
        }
}
