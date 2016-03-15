<?php
include_once "classes/objects/class.user.php";
include_once('classes/objects/class.database.php');
include_once 'classes/objects/class.book_master.php';
include_once 'classes/objects/class.category.php';

function  search($q)
{
    $r=new AdminUser();
    $sql_res=$r->SearchUser($q);
}

    $aResult = '';
switch($_GET['functionname']) {
            case 'checkuser': if($_GET['arguments']=='')
                                    $aResult='Username Cannotbe Null';
                                else {
                                        $user = new AdminUser();
                                        $user->GetUser($_GET['arguments']);
                                        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_GET['arguments']))
                                        {
                                          $aResult="Special characters not allowed";
                                        }
                                        if($user->checkType())
                                            $aResult='Username already Exists';
                                        }
                              echo $aResult;
                                  
                               
                break;
             case 'checkname': if($_GET['arguments']=='')
                                    $aResult='Name Cannot be empty';
                                else {
                                                                           
                                        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_GET['arguments']))
                                        {
                                          $aResult="Special characters not allowed";
                                        }
                                      }
                              echo $aResult;
                                  
                               
                break;
            case 'useridsearch' : search($_GET['useridsearch']);
                break;
            case 'bookidsearch' : bookidsearch($_GET['bookidsearch']);
                break;
            case 'getBookDetails' : getBook($_GET['arguments']);
                break;
            case 'getUserIssueDetails' : getIssues($_GET['arguments']);
                break;
                
}

    function bookidsearch($bookid)
    {
      $r=new book_master();
    $sql_res=$r->SearchBook($bookid);
    }
    

    function getBook($isbn)
    {
        if($isbn!='')
        {
        $book=new book_master();
        $book->Get($isbn);
        if($book->title=='')
            $dis = 'disabled="disabled"';
       ?>
        <tr>
        <td>Title</td>
        <td><input type="text" name="title" id="title" value="<?php echo $book->title; ?>" required="required"></td>
                </tr>
                <tr>
                    <td>Author</td>
                    <td><input type="text" name="author" value="<?php echo $book->author; ?>" id="author"></td>
                </tr>
                <tr>
                    <td>Publisher</td>
                    <td><input type="text" name="publisher" value="<?php echo $book->publisher; ?>" id="publisher"></td>
                </tr>
                <tr>
                   <td>Category</td>
                   <td><select name='catid'><?php $cat=new category(); $cat->build_category_withsel(0,'',$book->catid); ?></select></td>
                </tr>
                 <tr>
                   <td>Rack No</td>
                   <td><input type="text" name="rackno" value="<?php echo $book->rackno; ?>" id="rackno" required="required"></td>
            
                </tr>
                <tr>
                    <td>Comments</td>
                    <td><textarea name="comments"><?php echo $book->comments; ?></textarea></td>
                </tr>
                <tr>
                    <td>No of copies</td>
                    <td><input type="number" name="stock" id="stock" required="required"></td>
                    <?php if($book->stock!='') { ?> <td> <?php echo 'In Library '.$book->stock.' copies'; ?> </td> <?php } ?>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" value="Add Copies" /></td>
                </tr>
             <?php
           }
        
    }
    
    
    function generateIssuedetails()
    {
        ?>
        <div class="caption">Issue Details</div>	
<div id="table">
	<div class="header-row row">
    <span class="cell primary">Book Id</span>
    <span class="cell">Book Name</span>
     <span class="cell">Issue Date</span>
    <span class="cell">Due Date</span>
     <span class="cell">Return</span>
  </div>
  <div class="row">
    <span class="cell primary">2013 Subaru WRX</span>
    <span class="cell" data-label="Exterior">World Rally Blue</span>
     <span class="cell" data-label="Interior">Black</span>
     <span class="cell" data-label="Engine">2.5L H4 Turbo</span>
     <span class="cell" data-label="Trans">5 Speed</span>
  </div>
  <div class="row">
    <span class="cell primary" data-label="Vehicle">2013 Subaru WRX STI</span>
    <span class="cell" data-label="Exterior">Crystal Black Silica</span>
     <span class="cell" data-label="Interior">Black</span>
     <span class="cell" data-label="Engine">2.5L H4 Turbo</span>
     <span class="cell" data-label="Trans">6 Speed</span>
  </div>
  <div class="row">
    <span class="cell primary" data-label="Vehicle">2013 Subaru BRZ</span>
    <span class="cell" data-label="Exterior">Dark Grey Metallic</span>
     <span class="cell" data-label="Interior">Black</span>
     <span class="cell" data-label="Engine">2.0L H4</span>
     <span class="cell" data-label="Trans">6 Speed</span>
  </div>
</div>
        <?php
    }



function getIssues($userid)
{
  ?>
  <tr>
                        <td>
                            Serial No
                        </td>
                        <td >
                            Title
                        </td>
                        <td>
                            Isbn
                        </td>
                        <td>
                            Author
                        </td>
                        <td>
                            Duedate
                        </td>
                        <td>
                            Fine
                        </td>
        </tr>
        <?php

                    $connection = Database::connect();
                    $query="select a.serialno, b.title, b.author, b.isbn, c.duedate from
                    issues c, book_trans a, book_master b where a.isbn=b.isbn and
                     c.userid='".$userid."' and c.serialno=a.serialno and c.returndate='0000-00-00'";
                    // echo $query;
                    $cursor = Database::Reader($query, $connection);
          while ($row = Database::Read($cursor))
          {
            $fine=0;
            $serialno=$row['serialno'];
            $title=$row['title'];
            $author=$row['author'];
            $isbn=$row['isbn'];
            $duedate=$row['duedate'];
            $d = date('Y-m-d');
      
            $time1 = strtotime($d);
            $time2 = strtotime($duedate);
            $diff = $time1-$time2;
            $diff=$diff/86400;
            if($diff<1) $fine=0;
            
            else
              {
                $type=0;
                switch ($_SESSION['user']) {
                  case 'student': $type=3;
                    # code...
                    break;
                  case 'faculty': $type=2;
                    # code...
                    break;
                  default:
                    # code...
                    break;
                }
              $query="SELECT value from adminsettings where type='$type' and field='fine'";
        
              $cursor = Database::Reader($query, $connection);
                while ($row = Database::Read($cursor))
                $fine=$row['value'];
              $fine=$fine*$diff;

              }
            ?>
            <tr>
              <td>
                <?php echo $serialno; ?>
              </td>
              <td>
                <?php echo $title; ?>
              </td>
              <td>
                <?php echo $isbn; ?>
              </td>
              <td>
                <?php echo $author; ?>
              </td>
              <td>
                <?php echo $duedate; ?>
              </td>
              <td>
                <?php echo $fine; ?>
              </td>
            </tr>
            <?php
          
          }


                  

}
?>