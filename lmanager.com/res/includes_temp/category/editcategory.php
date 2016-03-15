<!DOCTYPE HTML>
<html>
    <head><link rel="stylesheet" type="text/css" href="../../css/style.css" />
        <script type="text/javascript" src="../../js/jquery-2.1.1.js"></script>
        <script>
        function checknotequal()
        {
            var e=document.getElementById('catoldid');
            var one=e.options[e.selectedIndex].value;
            var d=document.getElementById('catnewid');
            var two=d.options[d.selectedIndex].value;
            if(one==two)
            { alert('Parent And Child Cannot Be The Same');
            return false;}
            return true;
            
        }
        </script>
    </head>
<?php
include '../classes/objects/class.book_master.php';
include '../classes/objects/class.category.php';


if($_SERVER['REQUEST_METHOD']=='POST')
{
    $catnew=new category($_POST['catoldid'],$_POST['catnamenew'],$_POST['catnewid']);
    $catnew->Save();
    ?>
    <div style="color: red"><?php
    echo 'Category Details changed';?></div><?php
}


$cat=new category();
?>
    <form action="" method="POST" onsubmit="return checknotequal()">
        <table>
            <tr><td>Select Category</td>
                <td>
                    <select name="catoldid" id="catoldid">
         <?php $cat->build_category_tree(0,''); ?>
</select>
                    </td>
            </tr>
            <tr><td>Select New Parent Category</td>
                <td>
                    <select name="catnewid" id="catnewid">
        <option value="0">&lt;root&gt;</option> 
  <?php $cat->build_category_tree(0,''); ?>
</select>
                    </td>
            </tr>
            <tr><td>Enter New category Name</td>
                <td><input required="required" type="text" name="catnamenew" id="catnamenew" /></tr>
            <tr><td></td><td><input type="submit" value="Change Category"></td></tr>
            </table>
        </form>
