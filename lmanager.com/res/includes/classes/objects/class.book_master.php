<?php
require_once('class.database.php');
//require_once('class.category.php');

class book_master
{
	/**
	 * @var VARCHAR(255)
	 */
	public $isbn;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $title;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $author;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $publisher;
	
	/**
	 * @var INT
	 */
	public $catid;
        
	/**
	 * @var VARCHAR(255)
	 */
        public $rackno;
	
	/**
	 * @var INT
	 */
	public $stock;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $picture;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $comments;
	
	public $pog_query;
	
	
	/**
	* Getter for some private attributes
	* @return mixed $attribute
	*/
	public function __get($attribute)
	{
		if (isset($this->{"_".$attribute}))
		{
			return $this->{"_".$attribute};
		}
		else
		{
			return false;
		}
	}
	
	function book_master($isbn='', $title='', $author='', $publisher='', $catid='',$rackno='', $stock='', $picture='', $comments='')
	{
		$this->isbn = $isbn;
		$this->title = $title;
		$this->author = $author;
		$this->publisher = $publisher;
		$this->catid = $catid;
                $this->rackno = $rackno;
		$this->stock = $stock;
		$this->picture = $picture;
		$this->comments = $comments;
	}
	
	
	/**
	* Gets object from database
	* @param integer $book_masterId 
	* @return object $book_master
	*/
	function Get($isbn)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `book_master` where `isbn`='".$isbn."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->isbn = $row['isbn'];
			$this->title = $row['title'];
			$this->author = $row['author'];
			$this->publisher = $row['publisher'];
			$this->catid = $row['catid'];
                        $this->rackno = $row['rackno'];
			$this->stock = $row['stock'];
			$this->picture = $row['picture'];
			$this->comments = $row['comments'];
		}
		return $this;
	}
	
	
	
	/**
	* Saves the object to the database
	* @return integer $book_masterId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$rows = 0;
		if ($this->isbn!=''){
			$this->pog_query = "select `isbn` from `book_master` where `isbn`='".$this->isbn."' LIMIT 1";
			$rows = Database::Query($this->pog_query, $connection);
		}
		if ($rows > 0)
		{
			$this->pog_query = "update `book_master` set 
			`isbn`='".$this->isbn."', 
			`title`='".$this->title."', 
			`author`='".$this->author."', 
			`publisher`='".$this->publisher."', 
			`catid`='".$this->catid."', 
                        `rackno`='".$this->rackno."',
			`stock`='".$this->stock."', 
			`picture`='".$this->picture."', 
			`comments`='".$this->comments."' where `isbn`='".$this->isbn."'";
		}
		else
		{
			$this->pog_query = "insert into `book_master` (`isbn`, `title`, `author`, `publisher`, `catid`, `rackno`, `stock`, `picture`, `comments` ) values (
			'".$this->isbn."', 
			'".$this->title."', 
			'".$this->author."', 
			'".$this->publisher."', 
			'".$this->catid."', 
            '".$this->rackno."',
			'".$this->stock."', 
			'".$this->picture."', 
			'".$this->comments."' )";
				
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		
		return $this->isbn;
	}
	
		
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `book_master` where `isbn`='".$this->isbn."'";
		return Database::NonQuery($this->pog_query, $connection);
	}
	
        function getBooks($catid)
        {
        	$connection = Database::Connect();
            $this->pog_query="Select * from `book_master` where `catid`='".$catid."'";
            $cursor = Database::Reader($this->pog_query, $connection);
            return $cursor;
            
        }
        
	function checkExisting($isbn)
	{
		$connection = Database::Connect();
		$this->pog_query="Select stock from `book_master` where `isbn`='".$isbn."'";
		$cursor = Database::Reader($this->pog_query, $connection);
		$newstock=0;
		while ($row = Database::Read($cursor))
		{
			$newstock = $row['stock'];
		}
		return $newstock;

	}



		function SearchBook($bookid)
	{
		$serialno='';
		$connection = Database::Connect();
		$orgbookid=str_replace('CSED-', '', $bookid);
		$this->query = "select * from `book_master` a, `book_trans` b where a.isbn=b.isbn and (a.isbn like '%$bookid%' or b.serialno like '$orgbookid%' or a.title like '%$bookid%' or a.author like '%$bookid%') order by b.serialno LIMIT 5";
		$cursor = Database::Reader($this->query, $connection);
		while ($row = Database::Read($cursor))
		{
            $serialno = $row['serialno'];
			$isbn = $row['isbn'];
			$author = $row['author'];
			$title = $row['title'];
			$status = $row['status'];
			$re_serialno='<b>'.$bookid.'</b>';
            $re_isbn='<b>'.$bookid.'</b>';
            $re_author='<b>'.$bookid.'</b>';
            $re_title='<b>'.$bookid.'</b>';
            $final_serialno = str_ireplace($bookid, $re_serialno, 'CSED-'.$serialno);
            $final_isbn = str_ireplace($bookid, $re_isbn, $isbn);
            $final_author = str_ireplace($bookid, $re_author, $author);
            $final_title = str_ireplace($bookid, $re_title, $title);
			$param="'".$serialno."'";


?>
<div class="display_box" align="left" onclick="selectBook(<?php echo $param; ?>)">

                        <?php echo $final_serialno; ?>&nbsp;<?php echo $final_title; ?><br/>
                        <span style="font-size:9px; color:#999999"><?php echo $re_isbn;?>&nbsp;<?php echo $re_author;?></span></div>



                        <?php
		}
		return $this;
	}
	
	
}
?>