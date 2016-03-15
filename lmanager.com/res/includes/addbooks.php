<?php
session_start();
if($_SESSION['user']!='admin')
{
    echo 'You are not authorized to view this page';
    die();
} 
include_once 'classes/objects/class.book_master.php';
include_once "classes/objects/class.category.php";
require_once "classes/objects/class.book_trans.php";
require_once "Excel/reader.php";
?>
<!DOCTYPE HTML>
<html>
    <head><link rel="stylesheet" type="text/css" href="../css/style.css" />
        <script type="text/javascript" src="../js/jquery-2.1.1.js"></script>
        <script>
        $(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
            function getBookDetails()
            {
               
                jQuery.ajax({
        type: "GET",
        url: 'validations.php',
        data: {functionname: 'getBookDetails', arguments: document.getElementById('isbn').value},

        success: function (obj) {
                  //if( !('error' in obj) ) {
                      $('#formtable tbody').html(obj);
                 // }
                  
            }
}); 
                //document.getElemetById('isbn').readOnly= true;
            }
            function deleteTable()
            {
                 $('#formtable tbody').html('');
            }

        </script>
        
    </head>
    <?php
    if($_SERVER['REQUEST_METHOD']=='POST'&&isset($_POST['isbn']))
        {
            $newbook=new book_master($_POST['isbn'],$_POST['title'], $_POST['author'], $_POST['publisher'], $_POST['catid'],$_POST['rackno'], $_POST['stock'], '', $_POST['comments']);
            $newstockno=$newbook->stock;
            $newbook->stock=$newbook->stock+$newbook->checkExisting($_POST['isbn']);
            $newbook->Save();
            echo 'Books Inserted With Serial Numbers:';
            for($i=0;$i<$newstockno;$i++)
            {
                $bookitem = new book_trans('',$newbook->isbn,1,'');
                $bookitem->Save();
            }
            ?>
            <div style="color:red">Book Added To Stock</div>
            <?php 
            
        }

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
        //echo "Stored in: " . "upload/" . $_FILES["file"]["name"];


        ?>
        <table>
    <?php
        $isbn='';
        $title='';
        $author='';
        $publisher='';
        $category='';
        $stock='';
        $rackno='';
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
                $isbn=$cell;
                break;
            case 2:
                $title=$cell;
                break;
            case 3:
                $author=$cell;
                break;
            case 4:
                $publisher=$cell;
                break;
            case 5:
                $category=$cell;
                break;
            case 6:
                $rackno=$cell;
                break;
            case 7:
                $stock=$cell;
                break;
            case 8:
                $comments=$cell;
                break;
            default:
                # code...
                break;
        }
        
        $y++;
      } 
      echo $isbn.' '.$title.' '.$author.' '.$publisher.' '.$category.' '.$rackno,' '.$stock.' '.$comments;
      addBookFromXls($isbn,$title,$author,$publisher,$category,$rackno,$stock,$comments); 
      $x++;
    }

 } else echo 'invalid file type';

    }
        
    }
    ?>

    <body>
    <table>
    <tr>
    <td style="width:400px">
        <form action="" method="POST" name="addbook" id="addbook">
            <table>
                <tr>
                    <td>ISBN</td>
                    <td><input type="text" name="isbn" id="isbn" required="required" onkeyup="deleteTable()"></td>
                    <td><input type="button" value="Go" onclick="getBookDetails();" /></td>
                </tr>
            </table>
            <table id="formtable">
                <tbody></tbody>
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


    <?php

    function addBookFromXls($isbn,$title,$author,$publisher,$category,$rackno,$stock,$comments)
    {
            $newbook=new book_master($isbn,$title, $author, $publisher, $category, $rackno, $stock, '', $comments);
            $newstockno=$newbook->stock;
            $newbook->stock=$newbook->stock+$newbook->checkExisting($isbn);
            $newbook->Save();
            echo "<br/>".'Book '.$isbn.' Inserted With Serial Numbers:';
            for($i=0;$i<$newstockno;$i++)
            {
                $bookitem = new book_trans('',$newbook->isbn,1,'');
                $bookitem->Save();
            }
            ?>
            <br/>
            <?php 
            
        
    }