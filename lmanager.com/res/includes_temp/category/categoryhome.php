<!DOCTYPE HTML>
<html>
    <head><link rel="stylesheet" type="text/css" href="../../css/style.css" />
        <script type="text/javascript" src="../../js/jquery-2.1.1.js"></script>
    </head>
<?php
include '../classes/objects/class.book_master.php';
include '../classes/objects/class.category.php';


if($_SERVER['REQUEST_METHOD']=='POST')
{
    $catnew=new category('',$_POST['catnamenew'],$_POST['catid']);
    $catnew->Save();
    ?>
    <div style="color: red"><?php
    echo 'New Category Added Succesfully';?></div><?php
}


$cat=new category();
?>
    <form action="" method="POST">
        <table>
            <tr><td>Select Parent Category</td>
                <td>
                    <select name="catid">
        <option value="0">&lt;root&gt;</option> 
  <?php $cat->build_category_tree(0,''); ?>
</select>
                    </td>
            </tr>
            <tr><td>Enter New category Name</td>
                <td><input required="required" type="text" name="catnamenew" id="catnamenew" /></tr>
            <tr><td></td><td><input type="submit" value="Add Category"></td></tr>
            </table>
        </form>
