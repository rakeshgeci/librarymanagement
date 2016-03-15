<?php 
session_start();
if($_SESSION['user']!='admin')
{
    echo 'You are not authorized to view this page';
    die();
} 
include_once "classes/objects/class.user.php"; 
include_once "classes/objects/class.database.php"; 
?>
<!DOCTYPE HTML>
<html>
    <head><link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/table2.css" />
        <script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
    
        <script>
            function setLabel(input)
        {
            var label,radValue;
            if(input.checked)
            {
                radValue=input.value;
            }
            if(radValue=='faculty') label= 'Faculty ID*'; else label='Student ID*';
            document.getElementById('useridLabel').innerHTML = label;
        }
        
        function invertDis()
        {
            document.getElementById('phone').disabled=1-document.getElementById('phone').disabled;
            document.getElementById('faculty').disabled=1-document.getElementById('faculty').disabled;
            document.getElementById('student').disabled=1-document.getElementById('student').disabled;
            document.getElementById('password').disabled=1-document.getElementById('password').disabled;
            document.getElementById('name').disabled=1-document.getElementById('name').disabled;
            document.getElementById('email').disabled=1-document.getElementById('email').disabled;
            document.getElementById('change').disabled=1-document.getElementById('change').disabled;
            
        }
        function setTable(userid)
        {
             jQuery.ajax({
        type: "GET",
        url: 'validations.php',
        data: {functionname: 'getUserIssueDetails', arguments: userid},

        success: function (obj) {
                  //if( !('error' in obj) ) {
                      $('#issuetable tbody').html(obj);
                 // }
                  
            }
}); 
        }

           function selectUser(userid,type,name,email,phone)
           {
               
               document.getElementById('userid').value=userid;
               document.getElementById('name').value=name;
               document.getElementById('email').value=email;
               document.getElementById('phone').value=phone;
               if(type=='2')
                   document.getElementById('faculty').checked=true;
               else
                    document.getElementById('student').checked=true;
               setLabel(document.getElementById('faculty'));
               setTable(userid);
               var c='<a href="deleteuser.php?userid='+userid+'">Delete User</a>';
               document.getElementById("link").innerHTML=c;
           }
        
        $(document).ready(function(){

$(".search").keyup(function() 
{
var searchbox = $(this).val();
var dataString = 'useridsearch='+ searchbox;
functionname: 'checkuser'

if(searchbox=='')
{
    $('#display').hide();
}
else
{

$.ajax({
type: "GET",
url: "validations.php",
data: {functionname: 'useridsearch', useridsearch: searchbox},
cache: false,
success: function(html)
{

$("#display").html(html).show();
	
	
	}




});
}return false;    


});
});

jQuery(function($){
   $("#searchbox").Watermark("Search");
   });
</script>
<style type="text/css">

#searchbox
{
width:250px;
border:solid 1px #000;
padding:3px;
}
#display
{
width:250px;
display:none;
margin-right:30px;
border-left:solid 1px #dedede;
border-right:solid 1px #dedede;
border-bottom:solid 1px #dedede;
overflow:hidden;
}
.display_box
{
padding:4px; border-top:solid 1px #dedede; font-size:12px; height:30px;
}

.display_box:hover
{
background:#3b5998;
color:#FFFFFF;
}
#shade
{
background-color:#00CCFF;

}


</style>
</head>

<?php
if(isset($_POST['name']))
{
    $type=$_POST['type'];
    if($type=='faculty') $type=2; else $type=3;
    $userid=$_POST['userid'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $password=$_POST['password'];
    if($password=='')
    {
        $query = "update `user` set 
            `type`='".$type."', 
            `name`='".$name."', 
            `email`='".$email."', 
            `phone`='".$phone."' where `userid`='".$userid."'";

    }
    else
    {
        $query = "update `user` set 
            `password`='".md5($password)."', 
            `type`='".$type."', 
            `name`='".$name."', 
            `email`='".$email."', 
            `phone`='".$phone."' where `userid`='".$userid."'";
    }
    $connection = Database::Connect();
    Database::InsertOrUpdate($query, $connection);
    echo 'User Updated';


}
?>
<body>
<div style="width:100%; height: 200px">
        <span style="width:50%; float: left; height: 100%">
        <div style="width:100%; height: 100%">
            <input type="text" class="search" id="searchbox" placeholder="Search" /><br/>
            <br/><br/>
         <div id="display">
       </div>
        </div>
        
            
        </span>
        <span style="width:50%; float: right">
               
        
        <form method="POST" action="" name="viewuser" id="adduser">
            <input type="hidden" name="formposted" value="true" />
            <table>
                <tr>
                    <td>User Type</td>
                    <td>
                        <input type="radio" disabled="disabled" name="type" value="faculty" id="faculty" checked="checked" onchange="setLabel(this)"/> Faculty 
                        <input type="radio" disabled="disabled" name="type" value="student" id="student" onchange="setLabel(this)" /> Student
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="userid" id="useridLabel">Faculty ID*</label>
                    </td>
                    <td>
                        <input type="text" readonly="readonly" name="userid" id="userid" required="required" maxlength="10" onchange="check(this)" >
                        <a href="#" onclick="invertDis()"><u>edit</u></a>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="name">Name</label>
                    </td>
                    <td>
                        <input type="text" disabled="disabled" id="name" name="name" maxlength="50" >
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="Email">Email*</label>
                    </td>
                    <td>
                        <input type="email" disabled="disabled" id="email" name="email" required="required" id="email" maxlength="50">
                    </td>
                </tr>
                <tr>
                    <td> 
                        <label for="phone">Phone No</label>
                    </td>
                    <td>
                        <input type="text" disabled="disabled" name="phone" id="phone" maxlength="20">
                    </td>
                </tr>
                <tr>
                    <td>
                        New Password
                    </td>
                    <td>
                        <input type="text" disabled="disabled" name="password" id="password" maxlength="20">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Change" name="change" id="change" disabled="disabled">
                    </td>
                </tr>
            </table>
        </form>
        
        </span>
</div><br />
<br />
<div id="link"></div>
<h3>Issued Books</h3>   
    <div class="CSSTableGenerator" >
                <table id="issuetable">
                <tbody>
                    
                    </tbody>


                    </table>

                </div>
    
</body>
</html>