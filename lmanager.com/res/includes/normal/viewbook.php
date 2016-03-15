<?php
session_start();
if($_SESSION['user']=='student'||$_SESSION['user']=='faculty')
{}else{
    
    echo 'No access';
 die();
} 
include_once '../classes/objects/class.book_master.php';
include_once "../classes/objects/class.category.php";
require_once "../classes/objects/class.book_trans.php"
?>
<!DOCTYPE HTML>
<html>
    <head><link rel="stylesheet" type="text/css" href="../../css/style.css" />
        <script type="text/javascript" src="../../js/jquery-2.1.1.js"></script>
    <script>

    $(document).ready(function(){

$(".search").keyup(function() 
{
var searchbox = $(this).val();
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
data: {functionname: 'bookidsearch', bookidsearch: searchbox},
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

<body>
<div style="width:100%; height: 200px">
        <span style="width:30%; float: left; height: 100%">
        <div style="width:100%; height: 100%">
        <form method="POST" action="searchbook.php" target="output">
            <input type="text" class="search" id="searchbox" name="searchbox" placeholder="Search" /><br/>
            <br/><br/>
         <div id="display">
       </div>
        </div>
        
            
        </span>
        <span style="width:70%; float: right; overflow-y:hidden; overflow-x:hidden">
        <iframe name="output" src="searchbook.php" width="100%" height="800px"></iframe>
        </span>
 </div>
 </body>

