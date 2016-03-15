<?php

require_once('class.database.php');

class book_trans
{
	public $serialno;
	public $isbn;
	public $status;
	public $comments;



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

	function book_trans($serialno='', $isbn='', $status=1, $comments='')
	{
		$this->serialno = $serialno;
		$this->isbn = $isbn;
		$this->status = $status;
		$this->comments = $comments;
	}

	function Get($serialno)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `book_trans` where `serialno`='".$serialno."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->serialno = $row['serialno'];
			$this->isbn = $row['isbn'];
			$this->status = $row['status'];
			$this->comments = $row['comments'];
		}
		return $this;
	}


	/**
	* Saves the object to the database
	* @return integer $book_masterId
	*/
	public function Save()
	{
		$connection = Database::Connect();
		$rows = 0;
		if ($this->serialno!=''){
			$this->pog_query = "select `serialno` from `book_trans` where `serialno`='".$this->serialno."' LIMIT 1";
			$rows = Database::Query($this->pog_query, $connection);
		}
		if ($rows > 0)
		{
			$this->pog_query = "update `book_trans` set 
			`serialno`='".$this->serialno."', 
			`isbn`='".$this->isbn."', 
			`status`='".$this->status."', 
			`comments`='".$this->comments."' where `serailno`='".$this->serialno."'";
		}
		else
		{
			$this->pog_query = "insert into `book_trans` (`isbn`, `status`, `comments` ) values (
			'".$this->isbn."',
			'".$this->status."', 
			'".$this->comments."' )";
				
		}
		$insertId = Database::InsertOrUpdate($this->pog_query, $connection);

		echo 'CSED-'.$insertId.' ';
		
	}


		

}