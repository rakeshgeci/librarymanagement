<?php
require_once('class.database.php');
//require_once('class.book_master.php');

class category
{
	

	/**
	 * @var INT
	 */
	public $catid;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $catname;
	
	/**
	 * @var INT
	 */
	public $parent;
	
	
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
	
	function category($catid='', $catname='', $parent='')
	{
		$this->catid = $catid;
		$this->catname = $catname;
		$this->parent = $parent;
	}
	
	
	/**
	* Gets object from database
	* @param integer $categoryId 
	* @return object $category
	*/
	function Get($catid)
	{
		$connection = Database::Connect();
		$this->pog_query = "select * from `category` where `catid`='".$catid."' LIMIT 1";
		$cursor = Database::Reader($this->pog_query, $connection);
		while ($row = Database::Read($cursor))
		{
			$this->catid = $row['catid'];
			$this->catname = $row['catname'];
			$this->parent = $row['parent'];
		}
		return $this;
	}
	
	
	
	/**
	* Saves the object to the database
	* @return integer $categoryId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$rows = 0;
                
		if ($this->catid!=''){
			$this->pog_query = "select `catid` from `category` where `catid`='".$this->catid."' LIMIT 1";
			$rows = Database::Query($this->pog_query, $connection);
		}
		if ($rows > 0)
		{
			$this->pog_query = "update `category` set 
			`catid`='".$this->catid."', 
			`catname`='".$this->catname."', 
			`parent`='".$this->parent."' where `catid`='".$this->catid."'";
		}
		else
		{
			$this->pog_query = "insert into `category` (`catname`, `parent` ) values ('".$this->catname."', 
			'".$this->parent."' )";
                       
		}
                $insertId = Database::InsertOrUpdate($this->pog_query, $connection);
		
        }
	
	
		
	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->pog_query = "delete from `category` where `catid`='".$this->catid."' AND parent = 0";
		return Database::NonQuery($this->pog_query, $connection);
	}
        
        function build_category_tree($parent,$intend)
            {
                $connection = Database::Connect();
                $pog_query="select catid, catname FROM category WHERE parent = " . $parent;
                $cursor = mysql_query($pog_query, $connection);
                while($row = Database::Read($cursor))
                {
                    echo "<option value="."'".$row["catid"] ."'". ">".$intend.$row['catname']."</option>";
                    if($row["catid"] != $parent){
                        $ind = $intend . "--";
                        $this->build_category_tree($row["catid"],$ind);
                        
                        }
                }
                
            }
            
        function build_category_withsel($parent,$intend,$selected)
        {
            $sel="";
            $connection = Database::Connect();
                $pog_query="select catid, catname FROM category WHERE parent = " . $parent;
                $cursor = mysql_query($pog_query, $connection);
                while($row = Database::Read($cursor))
                {
                    if($row["catid"]==$selected)
                        {
                        	$sel="selected";
                         }
                         else $sel='';
                    echo "<option value="."'".$row["catid"] ."' ".$sel.">".$intend.$row['catname']."</option>";
                    if($row["catid"] != $parent){
                        $ind = $intend . "--";
                        $this->build_category_withsel($row["catid"],$ind,$selected);
                        
                        }
                }
        }
	
}
?>