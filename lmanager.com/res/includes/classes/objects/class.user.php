<?php
require('class.database.php');
class user
{
	/**
	 * @var VARCHAR(255)
	 */
	public $userid;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $password;
	
	/**
	 * @var INT
	 */
	public $type;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $name;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $email;
	
	/**
	 * @var VARCHAR(255)
	 */
	public $phone;
	public $query;
	
	
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
	
	function user($userid='', $password='', $type='', $name='', $email='', $phone='')
	{
		$this->userid = $userid;
		$this->password = $password;
		$this->type = $type;
		$this->name = $name;
		$this->email = $email;
		$this->phone = $phone;
	}
	
	/**
	* Gets object from database
	* @param integer $userId 
	* @return object $user
	*/
        
	function Get($userid,$password)
	{
		$connection = Database::Connect();
		$this->query = "select * from `user` where `userid`='".$userid."' AND password='".$password."' LIMIT 1";
		$cursor = Database::Reader($this->query, $connection);
		while ($row = Database::Read($cursor))
		{
                        //print_r($row);
			$this->userid = $row['userid'];
			$this->password = $row['password'];
			$this->type = $row['type'];
			$this->name = $row['name'];
			$this->email = $row['email'];
			$this->phone = $row['phone'];
		}
		return $this;
	}
        
        
        
        
        function getUserid()
        {
            return $this->userid;
        }
	
        function checkType()
        {
            return $this->type;
        }
	
	/**
	* Returns a sorted array of objects that match given conditions
	* @param multidimensional array {("field", "comparator", "value"), ("field", "comparator", "value"), ...} 
	* @param string $sortBy 
	* @param boolean $ascending 
	* @param int limit 
	* @return array $userList
	*/
		
	
	/**
	* Saves the object to the database
	* @return integer $userId
	*/
	function Save()
	{
		$connection = Database::Connect();
		$rows = 0;
		//echo $this->userid;
		if ($this->userid!=''){
			$this->query = "select `userid` from `user` where `userid`='".$this->userid."' LIMIT 1";
			$rows = Database::Query($this->query, $connection);
		}
		if ($rows > 0)
		{
			$this->query = "update `user` set 
			`password`='".md5($this->password)."', 
			`type`='".$this->type."', 
			`name`='".$this->name."', 
			`email`='".$this->email."', 
			`phone`='".$this->phone."' where `userid`='".$this->userid."'";
		}
		else
		{
			$this->query = "insert into `user` (`userid`, `password`, `type`, `name`, `email`, `phone` ) values (
			'".$this->userid."', 
			'".md5($this->password)."', 
			'".$this->type."', 
			'".$this->name."', 
			'".$this->email."', 
			'".$this->phone."' )";
		}
		//echo $this->query;
		$insertId = Database::InsertOrUpdate($this->query, $connection);
		if ($this->userid == "")
		{
			$this->userid = $insertId;
		}
		return $this->userId;
	}
	
	
	
}

class AdminUser extends user
{
    function SearchUser($userid)
	{
		$connection = Database::Connect();
		$this->query = "select * from user where name like '%$userid%' or userid like '%$userid%' order by userid LIMIT 5";
		$cursor = Database::Reader($this->query, $connection);
		while ($row = Database::Read($cursor))
		{
                        $this->userid = $row['userid'];
			$this->password = $row['password'];
			$this->type = $row['type'];
                        if($this->type=='1')
                            continue;
                        elseif ($this->type=='2') {
                        	$typeS='Faculty';
                        }
                        else
                        	$typeS='Student';

			$this->name = $row['name'];
			$this->email = $row['email'];
			$this->phone = $row['phone'];
                        $re_name='<b>'.$userid.'</b>';
                        $re_userid='<b>'.$userid.'</b>';
                        
                        $final_name = str_ireplace($userid, $re_name, $this->name);

                        $final_userid = str_ireplace($userid, $re_userid, $this->userid);
                        $param="'".$row['userid']."'".','."'".$row['type']."'".','."'".$row['name']."'";
                        $param=$param.','."'".$row['email']."'".','."'".$row['phone']."'";


?>
<div class="display_box" align="left" onclick="selectUser(<?php echo $param; ?>)">

                        <?php echo $final_name; ?>&nbsp;<?php echo $final_userid; ?><br/>
                        <span style="font-size:9px; color:#999999"><?php echo $typeS ?></span></div>



                        <?php
		}
		return $this;
	}
        
        
        
        function GetUser($userid)
	{
		$connection = Database::Connect();
		$this->query = "select * from user where userid = '$userid' LIMIT 1";
		$cursor = Database::Reader($this->query, $connection);
		while ($row = Database::Read($cursor))
		{
                       $this->userid = $row['userid'];
			$this->password = $row['password'];
			$this->type = $row['type'];
			$this->name = $row['name'];
			$this->email = $row['email'];
			$this->phone = $row['phone'];
         
		}
		return $this;
	}
        	/**
	* Deletes the object from the database
	* @return boolean
	*/
	function Delete()
	{
		$connection = Database::Connect();
		$this->query = "delete from `user` where `userid`='".$this->userid."'";
		return Database::NonQuery($this->query, $connection);
	}
	
	
}
?>