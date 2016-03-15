<?php
session_start();
if($_SESSION['user']!='admin')
{
    echo 'You are not authorized to view this page';
    die();
} 
?>
<!DOCTYPE HTML>
<html>
    <head><link rel="stylesheet" type="text/css" href="../css/style.css" />
        <script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
    </head>
    
    
    <body>
      
        <div style="width:100%; height: 800px; overflow-y:hidden; overflow-x:hidden;">
            <span style="width:20%; float: left; height: 100%">
            
            
                    
                        <h1>Quick Links</h1>
                        <br/>
                        <a href="category/categoryhome.php" target="categorymanager">Add Category</a> <br/>
                        <a href="category/editcategory.php" target="categorymanager">Edit category</a> <br/>
                        <a href="category/viewcategory.php" target="categorymanager">View Cateogory Id</a> <br/>
                       <!-- <a href="#" target="categorymanager">View Stocks</a> <br/>-->
                    </span>
            <span style="width:80%; float: right; height: 100%">
                
                    
                    <iframe height="100%" width="100%" name="categorymanager" src="category/categoryhome.php"></iframe>
            </span>
        </div>
    </body>
<?php



?>

