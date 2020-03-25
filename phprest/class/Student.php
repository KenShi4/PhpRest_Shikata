<?php
/**
 * @package Student class
 *
 * @author 
 *   
 */
 
include("DBConnection.php");
class Student 
{
    protected $db;
    public $_id;
    public $_name;
    public $_surname;
    public $_sidiCode;
    public $_taxCode;
 
	public function __construct()
	{
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();
    }
 
    //insert
	public function insert()
	{
		try
		{
    		$sql = 'INSERT INTO student (name, surname, sidi_code, tax_code)  VALUES (:name, :surname, :sidi_code, :tax_code)';
    		$data = [
			    'name' => $this->_name,
			    'surname' => $this->_surname,
			    'sidi_code' => $this->_sidiCode,
			    'tax_code' => $this->_taxCode
			];
	    	$stmt = $this->db->prepare($sql);
	    	$stmt->execute($data);
			$status = $stmt->rowCount();
            return $status;
 
		} catch (Exception $e)
		{
    		die("Oh noes! There's an error in the query! ".$e);
		}
 
    }
   
    // getAll 
    public function list() {
    	try {
    		$sql = "SELECT * FROM student";
		    $stmt = $this->db->prepare($sql);
 
		    $stmt->execute();
		    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
		} catch (Exception $e) {
		    die("Oh noes! There's an error in the query! ".$e);
		}
    }

    // getOne
    public function one() {
    	try {
    		$sql = "SELECT * FROM student WHERE id=:id";
		    $stmt = $this->db->prepare($sql);
		    $data = [
		    	'id' => $this->_id
			];
		    $stmt->execute($data);
		    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
		} catch (Exception $e) {
		    die("Oh noes! There's an error in the query! ".$e);
		}
	}
	
	public function getLast()
	{
		try
		{
    		$sql = "SELECT * FROM student ORDER BY id DESC LIMIT 1";
		    $stmt = $this->db->prepare($sql);
		    $stmt->execute($data);
		    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
		}
		catch (Exception $e)
		{
		    die("Oh noes! There's an error in the query! ".$e);
		}
	}
 
	public function delete()
	{
		try
		{
    		$sql = "DELETE FROM student_class WHERE id_student=:id";
		    $stmt = $this->db->prepare($sql);
		    $data = [
		    	'id' => $this->_id
			];
		    $stmt->execute($data);
			$status = $stmt->rowCount();
			
			$sql = "DELETE FROM student WHERE id=:id";
			$stmt = $this->db->prepare($sql);
		    $data = [
		    	'id' => $this->_id
			];
		    $stmt->execute($data);
			$status = $stmt->rowCount();

            return $status;
		}
		catch (Exception $e)
		{
			die("Oh noes! There's an error in the query! ".$e);
		}
    }

	public function patch()
	{
		try
		{
			$data = ['id' => $this->_id];
			$sql = 'UPDATE student SET ';
			
			foreach($this as $key => $value)
			{
				if($value != null && strcmp($key,'db')!=0 && strcmp($key,'id')!=0) //non inserisce la voce db e id nella query
				{
					$key = ltrim($key, "_");
					$sql = $sql . "$key=:$key,"; //statement come name=:name viene aggiunto alla query

					$data[$key] = $value; //statement come 'name' => $this->_name viene inserito all'interno dell'array $data per ogni valore passato;
				}
			}

			$sql = rtrim($sql,",");
			$sql = $sql . " WHERE id=:id";

	    	$stmt = $this->db->prepare($sql);
	    	$stmt->execute($data);
			$status = $stmt->rowCount();
			return $status;
		}
		catch (Exception $e)
		{
    		die("Oh noes! There's an error in the query! ".$e);
		}
	}
	
	public function put()
	{
		try
		{
			$sql = 'UPDATE student SET name=:name, surname=:surname, sidi_code=:sidi_code, tax_code=:tax_code WHERE id=:id';

    		$data = [
				'id' =>$this->_id,
			    'name' => $this->_name,
			    'surname' => $this->_surname,
			    'sidi_code' => $this->_sidiCode,
			    'tax_code' => $this->_taxCode
			];

	    	$stmt = $this->db->prepare($sql);
	    	$stmt->execute($data);
			$status = $stmt->rowCount();
            return $status;
		}
		catch (Exception $e)
		{
    		die("Oh noes! There's an error in the query! ".$e);
		}
    }
 
}
?>