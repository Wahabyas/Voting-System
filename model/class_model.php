<?php

require 'config/connection.php';

class class_model {

    public $host = db_host;
    public $user = db_user;
    public $pass = db_pass;
    public $dbname = db_name;
    public $conn;
    public $error;
	private $pdo;
    public function __construct() {
		try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=voring_system", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $this->connect();
    }
	public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }

    private function connect() {
        // Establish connection to the database
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        
        // Check if the connection was successful
        if ($this->conn->connect_error) {
            $this->error = "Fatal Error: Can't connect to database" . $this->conn->connect_error;
            return false;
        }
    }
	public function count_Voter($Activeyear){
		$stmt= $this->conn->prepare('SELECT * FROM voter_vouchers WHERE `year` = ?') or die($this->conn->error);
		$stmt -> bind_param('i',$Activeyear);
		$stmt ->execute();
		$result = $stmt->get_result();
		return $result->num_rows;
	}
	public function count_candidate($Activeyear){
		$stmt= $this->conn->prepare('SELECT * FROM candidate WHERE `yearofcandidacy` = ?') or die($this->conn->error);
		$stmt -> bind_param('i',$Activeyear);
		$stmt ->execute();
		$result = $stmt->get_result();
		return $result->num_rows;
	}
	public function count_votes($Candidate_id){
		$stmt= $this->conn->prepare('SELECT * FROM votes WHERE `Candidate_id` = ?') or die($this->conn->error);
		$stmt -> bind_param('i',$Candidate_id);
		$stmt ->execute();
		$result = $stmt->get_result();
		return $result->num_rows;
	}

	public function select_years(){
		$stmt= $this->conn->prepare("SELECT * from `year`") or die($this->conn->error);
		
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()){
			$data[] = $row;
		}
		return $data;
	}


    public function login($username, $password, $status){
		// Prepare SQL query to get user details based on username, password, and account status
		$stmt = $this->conn->prepare("SELECT * FROM `user` WHERE `UserName` = ? AND `Password` = ? AND `account_status` = ?");
		$stmt->bind_param("sss", $username, $password, $status);
	
		// Execute the query
		if ($stmt->execute()) {
			// Get the result of the query
			$result = $stmt->get_result();
			$valid = $result->num_rows;
	
			// Check if there is at least one result
			if ($valid > 0) {
				// Fetch the data if there is a valid result
				$fetch = $result->fetch_array();
				
				// Return the user data
				return array(
					'user_id' => htmlentities($fetch['user_id']),
					'count' => $valid
				);
			} else {
				// If no results are found, return an error
				return array(
					'status' => 'error',
					'message' => 'Incorrect username or password.'
				);
			}
		} else {
			// If the query execution failed, return a general error
			return array(
				'status' => 'error',
				'message' => 'Failed to execute query.'
			);
		}
	}

	public function loginvoucher($username){
		// Prepare SQL query to get user details based on username, password, and account status
		$stmt = $this->conn->prepare("SELECT * FROM `voter_vouchers` WHERE `Voucher_code` = ?");
		$stmt->bind_param("s", $username);
	
		// Execute the query
		if ($stmt->execute()) {
			// Get the result of the query
			$result = $stmt->get_result();
			$valid = $result->num_rows;
	
			// Check if there is at least one result
			if ($valid > 0) {
				// Fetch the data if there is a valid result
				$stmtZ = $this->conn->prepare("UPDATE `voter_vouchers` SET `Status` = 1 WHERE `Voucher_code` = ?");
		$stmtZ->bind_param("s", $username);
		$stmtZ->execute();
				$fetch = $result->fetch_array();
				
				// Return the user data
				return array(
					'Voucher_id' => htmlentities($fetch['Voucher_id']),
					'count' => $valid
				);
			} else {
				// If no results are found, return an error
				return array(
					'status' => 'error',
					'message' => 'Voucher has Cease to Exist.'
				);
			}
		} else {
			// If the query execution failed, return a general error
			return array(
				'status' => 'error',
				'message' => 'Failed to execute query.'
			);
		}
	}
	public function fetch_user($me){
		$stmt= $this->conn->prepare("SELECT * from `user` WHERE `user_id` = ?") or die($this->conn->error);
		$stmt->bind_param('i',$me);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()){
			$data[] = $row;
		}
		return $data;
	}
	public function fetch_voucher(){
		$stmt= $this->conn->prepare("SELECT * from voter_vouchers") or die($this->conn->error);
		
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()){
			$data[] = $row;
		}
		return $data;
	}

	

	public function fetch_Voter($me){
		$stmt= $this->conn->prepare("SELECT * from `voter_vouchers` WHERE `Voucher_id` = ?") or die($this->conn->error);
		$stmt->bind_param('i',$me);
		$stmt->execute();
		$result = $stmt->get_result();
		$data = array();
		while ($row = $result->fetch_assoc()){
			$data[] = $row;
		}
		return $data;
	}

	public function fetchAll_year(){ 
		$sql = "SELECT * FROM `year` ORDER BY `Year` DESC"; 
			$stmt = $this->conn->prepare($sql); 
			$stmt->execute();
			$result = $stmt->get_result();
			$data = array();
			 while ($row = $result->fetch_assoc()) {
					   $data[] = $row;
				}
			 return $data;

	  }

	  public function fetchActive_year(){ 
		$sql = "SELECT * FROM `year` where `Status` = 1"; 
			$stmt = $this->conn->prepare($sql); 
			$stmt->execute();
			$result = $stmt->get_result();
			$data = array();
			 while ($row = $result->fetch_assoc()) {
					   $data[] = $row;
				}
			 return $data;

	  }

	  public function fetchAll_User(){ 
		$sql = "SELECT * FROM `user`"; 
			$stmt = $this->conn->prepare($sql); 
			$stmt->execute();
			$result = $stmt->get_result();
			$data = array();
			 while ($row = $result->fetch_assoc()) {
					   $data[] = $row;
				}
			 return $data;

	  }
	  


	public function add_year($year, $status) {
		// Set all statuses to 0
		
	
		// Check if the year already exists
		$count=null;
		$check_stmt = $this->conn->prepare("SELECT COUNT(*) FROM `year` WHERE `Year` = ?") or die($this->conn->error);
		$check_stmt->bind_param("i", $year);
		$check_stmt->execute();
		$check_stmt->bind_result($count); // Bind the result to the variable $count
		$check_stmt->fetch(); // Fetch the result into $count
		$check_stmt->close();
	
		if ($count > 0) {
			// If the year already exists, return false
			return false;
		}
		$update_stmt = $this->conn->prepare("UPDATE `year` SET `Status` = 0") or die($this->conn->error);
		if (!$update_stmt->execute()) {
			// If the update fails, return false
			return false;
		}
		$update_stmt->close();
		// Now insert the new year with the status
		$insert_stmt = $this->conn->prepare("INSERT INTO `year` (`Year`, `Status`) VALUES (?, ?)") or die($this->conn->error);
		$insert_stmt->bind_param("ii", $year, $status);
	
		if ($insert_stmt->execute()) {
			$insert_stmt->close();
			$this->conn->close();
			return true; // Success
		} else {
			$insert_stmt->close();
			$this->conn->close();
			return false; // Failure in insertion
		}
	}
	public function add_user($Fullname,$Username,$password,$status,$role, $profile_picture) {
		if ($profile_picture){
		$insert_stmt = $this->conn->prepare("INSERT INTO `user` (`Fullname`, `UserName`,`Password`,`account_status`,`role`,`profile_picture`) VALUES (?, ?,?,?,?,?)") or die($this->conn->error);
		$insert_stmt->bind_param("ssssss",$Fullname,$Username,$password,$status,$role, $profile_picture);
	
		if ($insert_stmt->execute()) {
			$insert_stmt->close();
			$this->conn->close();
			return true; // Success
		} else {
			$insert_stmt->close();
			$this->conn->close();
			return false; // Failure in insertion
		}
		}
	}


	public function count_Voter1($Candidate_id){
		$stmt= $this->conn->prepare('SELECT * FROM votes WHERE `Candidate_id` = ?') or die($this->conn->error);
		$stmt -> bind_param('i',$Candidate_id);
		$stmt ->execute();
		$result = $stmt->get_result();
		return $result->num_rows;
	}

	public function fetchAll_candidateposition($Office_idp){ 
		$sql = "SELECT * FROM `candidate` WHERE `Candidate_id` = ? "; 
			$stmt = $this->conn->prepare($sql); 
			$stmt -> bind_param('i',$Office_idp);
			$stmt -> execute();
			$result = $stmt->get_result();
			$data = array();
			 while ($row = $result->fetch_assoc()) {
					   $data[] = $row;
				}
			 return $data;

	  }

	
	public function fetchcandidatebyyear($Activeyear) {
		// SQL query with JOIN to get related office details
		$stmt = $this->conn->prepare("
			SELECT 
				c.Candidate_id, 
				c.profile_picture, 
				c.Candidate_fullname, 
				c.Balotno, 
				c.yearofcandidacy, 
				o.Office_id, 
				o.Electiveoffice, 
				o.Year AS OfficeYear
			FROM 
				candidate c
			INNER JOIN 
				office o 
			ON 
				c.Office_id = o.Office_id
			WHERE 
				c.yearofcandidacy = ?
		");
	
		if (!$stmt) {
			// Log the error and return an empty array on failure
			error_log("Prepare failed: " . $this->conn->error);
			return [];
		}
	
		// Bind the parameter
		$stmt->bind_param('i', $Activeyear);
	
		// Execute the statement
		if (!$stmt->execute()) {
			error_log("Execute failed: " . $stmt->error);
			$stmt->close();
			return [];
		}
	
		// Get the result
		$result = $stmt->get_result();
		$Data = [];
		while ($row = $result->fetch_assoc()) {
			$Data[] = $row; // Add each row to the data array
		}
	
		// Close the statement
		$stmt->close();
	
		// Return the data
		return $Data;
	}

	public function fetchcandidatebyyear_and_position($position_id, $Activeyear) {
		$stmt = $this->conn->prepare("
			SELECT 
				c.Candidate_id, 
				c.profile_picture, 
				c.Candidate_fullname, 
				c.Balotno, 
				c.yearofcandidacy,
				o.Office_id,
				o.Electiveoffice,
				o.Year AS OfficeYear
			FROM 
				candidate c
			INNER JOIN 
				office o 
			ON 
				c.Office_id = o.Office_id
			WHERE 
				c.yearofcandidacy = ? 
				AND o.Office_id = ?
		");
		if (!$stmt) {
			error_log("Prepare failed: " . $this->conn->error);
			return [];
		}
		$stmt->bind_param('ii', $Activeyear, $position_id);
		if (!$stmt->execute()) {
			error_log("Execute failed: " . $stmt->error);
			$stmt->close();
			return [];
		}
	
		// Get the result
		$result = $stmt->get_result();
		$Data = [];
		while ($row = $result->fetch_assoc()) {
			$Data[] = $row; // Add each row to the data array
		}
	
		// Close the statement
		$stmt->close();
	
		// Return the data
		return $Data;
	}



	public function fetchcandidatebyyear_and_position_andvote($position_id, $Activeyear) {
    $stmt = $this->conn->prepare("
        SELECT
            c.Candidate_id, 
            c.profile_picture, 
            c.Candidate_fullname, 
            c.Balotno, 
            c.yearofcandidacy, 
            o.Office_id, 
            o.Electiveoffice, 
            o.year AS OfficeYear,
            COUNT(v.Vote_id) AS TotalVotes
        FROM 
            candidate c
        INNER JOIN 
            office o ON c.Office_id = o.Office_id
        LEFT JOIN 
            votes v ON c.Candidate_id = v.Candidate_id AND v.year_id = ?  
        WHERE 
            c.yearofcandidacy = ? 
            AND o.Office_id = ? 
        GROUP BY 
            c.Candidate_id, c.profile_picture, c.Candidate_fullname, c.Balotno, c.yearofcandidacy, o.Office_id, o.Electiveoffice, o.year
    ");
    if (!$stmt) {
        error_log("Prepare failed: " . $this->conn->error);
        return [];  // Return empty array if prepare fails
    }
    $stmt->bind_param('iii', $Activeyear, $Activeyear, $position_id);
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return []; 
    }
    $result = $stmt->get_result();
    $Data = [];  
    while ($row = $result->fetch_assoc()) {
        $Data[] = $row;  
    }
    $stmt->close();
    return $Data;
}

	
	
	public function submit_vote($voter, $candidate_id, $Activeyear) {
		$this->conn->begin_transaction();
	
		try {
			// Insert into the votes table
			$sql = "INSERT INTO votes (voter, candidate_id, year_id) VALUES (?, ?, ?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("sis", $voter, $candidate_id, $Activeyear);
	
			if (!$stmt->execute()) {
				throw new Exception("Error inserting vote: " . $stmt->error);
			}
	
			// Update the 'voter_vouchers' table
			$update_stmt = $this->conn->prepare("UPDATE voter_vouchers SET isvote = 1 WHERE Voucher_code = ?");
			$update_stmt->bind_param('s', $voter);
	
			if (!$update_stmt->execute()) {
				throw new Exception("Error updating voter_vouchers: " . $update_stmt->error);
			}
	
			// Commit the transaction if both queries are successful
			$this->conn->commit();
			return true;
	
		} catch (Exception $e) {
			// Rollback the transaction in case of an error
			$this->conn->rollback();
			error_log($e->getMessage());
			return false;
		}
	}
	


	public function select_vote($Voucher_code, $Year_idd) {
		$stmt = $this->conn->prepare("SELECT * FROM votes WHERE voter = ? AND year_id = ?");
		if ($stmt === false) {
			die('Error in preparing the statement: ' . $this->conn->error);
		}
		$stmt->bind_param('si', $Voucher_code, $Year_idd);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result && $result->num_rows > 0) {
			return true; 
		} else {
			return false; 
		}
		$stmt->close();
	}
	
	



	public function fetchall_office($Activeyear){
		$stmt = $this->conn->prepare("SELECT * FROM `office` WHERE `Year` = ?") or die($this->conn->error);
		$stmt->bind_param('i', $Activeyear);
		$stmt->execute();
		$result = $stmt->get_result();
		$Data = array();
		while ($row = $result->fetch_assoc()) {
			$Data[] = $row; // Add each row to the $Data array
		}
		$stmt->close(); // Close the statement
		$this->conn->close(); // Close the connection if no further queries will be executed
		return $Data; // Return the populated array
	}
	
	public function fetchcandidates($Activeyear,$Office_id){
		$stmt = $this->conn->prepare("SELECT * FROM `candidate` WHERE `yearofcandidacy` = ? AND `Office_id` = ?") or die($this->conn->error);
		$stmt->bind_param('ii', $Activeyear,$Office_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$Data = array();
		while ($row = $result->fetch_assoc()) {
			$Data[] = $row; // Add each row to the $Data array
		}
		$stmt->close(); // Close the statement
		$this->conn->close(); // Close the connection if no further queries will be executed
		return $Data;
	}
	

	public function add_candidate($Fullname, $Balotno, $yearofcandidacy, $Username, $profile_picture) {
    $stmt = $this->conn->prepare("INSERT INTO `candidate` (`Candidate_fullname`, `Balotno`, `yearofcandidacy`, `Office_id`, `profile_picture`) 
                                  VALUES (?, ?, ?, ?, ?)") or die($this->conn->error);
    $stmt->bind_param("ssiis", $Fullname, $Balotno, $yearofcandidacy, $Username, $profile_picture);

    if ($stmt->execute()) {
        $stmt->close();
        $this->conn->close();
        return true;
    } else {
        $stmt->close();
        $this->conn->close();
        return false;
    }
}
 public function add_users($Fullname, $Username, $password, $role, $profile_picture) {

    $stmt = $this->conn->prepare("INSERT INTO `user` (`Fullname`, `UserName`,`Password`,`account_status`,`role`,profile_picture) 
                                  VALUES (?, ?, ?, ?, ? ,?)") or die($this->conn->error);
    $stmt->bind_param("sssss", $Fullname, $Username, $password, $role, $profile_picture);

    if ($stmt->execute()) {
        $stmt->close();
        $this->conn->close();
        return true;
    } else {
        $stmt->close();
        $this->conn->close();
        return false;
    }
}
	

	public function add_office($Electiveoffice,$Year){
		$stmt = $this->conn->prepare("INSERT INTO `office`  (`Electiveoffice`,`Year`) VALUES (?,?)") or die($this->conn->error);
		$stmt->bind_param('si',$Electiveoffice,$Year);
		if($stmt->execute()){
			return true;
		}
	}
	 
	public function fetch_office($Activeyear){
		$stmt = $this->conn->prepare("SELECT * FROM `office` WHERE `Year` = ?") or die($this->conn->error);
		$stmt->bind_param("i", $Activeyear);
	
		// Execute the statement
		if ($stmt->execute()) {
			// Fetch the result set
			$result = $stmt->get_result();
			$data = array();
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
			return $data;
		} else {
			// Handle execution failure
			return array(); // Return an empty array or handle the error as needed
		}
	}
	
	

	public function delete_year($year_id){
		$sql = "DELETE FROM `year` WHERE Year_id = ?";
		 $stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $year_id);
		if($stmt->execute()){
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}
	public function delete_user($year_id){
		$stmt = $this->conn->prepare("SELECT `profile_picture` FROM `user` WHERE `user_id` = ? LIMIT 1");
		$stmt->bind_param("i", $year_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$candidate = $result->fetch_assoc();
		$profile_picture = $candidate['profile_picture'];
		$stmt->close();

	$stmt=$this->conn->prepare("DELETE  FROM `user` where user_id= ?") or die($this->conn->error);
	$stmt->bind_param("i",$year_id);
	if($stmt->execute()){
		if ($profile_picture) {
			$imagePath = '../uploads/profile_pictures/' . $profile_picture;
			if (file_exists($imagePath)) {
				unlink($imagePath);  // Delete the file from the server
			}
		}
		$stmt->close();
		$this->conn->close();
		return true;
	}
	}
	public function delete_Candidate($year_id) {
		// Step 1: Get the profile picture name before deletion
		$stmt = $this->conn->prepare("SELECT `profile_picture` FROM `candidate` WHERE `Candidate_id` = ? LIMIT 1");
		$stmt->bind_param("i", $year_id);
		$stmt->execute();
		$result = $stmt->get_result();
		$candidate = $result->fetch_assoc();
		$profile_picture = $candidate['profile_picture'];
		$stmt->close();
		
		// Step 2: Delete the candidate record from the database
		$stmt = $this->conn->prepare("DELETE FROM `candidate` WHERE `Candidate_id` = ?");
		$stmt->bind_param("i", $year_id);
		if ($stmt->execute()) {
			// Step 3: If deletion is successful, delete the image file from the server
			if ($profile_picture) {
				$imagePath = '../uploads/profile_pictures/' . $profile_picture;
				if (file_exists($imagePath)) {
					unlink($imagePath);  // Delete the file from the server
				}
			}
			
			$stmt->close();
			return true;
		} else {
			$stmt->close();
			return false;
		}
	}
	
		public function delete_Office($Office_id){
			$stmt=$this->conn->prepare("DELETE  FROM `office` WHERE Office_id = ?") or die($this->conn->error);
			$stmt->bind_param("i",$Office_id);
			if($stmt->execute()){
				$stmt->close();
				$this->conn->close();
				return true;
			}
			}


	public function Activate_year($year_id){
		$this->conn->query("UPDATE `year` SET `Status` = 0");
		$sql = "UPDATE `year` SET `Status` = 1 WHERE Year_id = ?";
		 $stmt = $this->conn->prepare($sql);
		$stmt->bind_param("i", $year_id);
		if($stmt->execute()){
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}

	public function edit_year($year, $year_id){
		$count=null;
		$check_stmt = $this->conn->prepare("SELECT COUNT(*) FROM `year` WHERE `Year` = ?") or die($this->conn->error);
		$check_stmt->bind_param("i", $year);
		$check_stmt->execute();
		$check_stmt->bind_result($count); // Bind the result to the variable $count
		$check_stmt->fetch(); // Fetch the result into $count
		$check_stmt->close();
	
		if ($count > 0) {
			// If the year already exists, return false
			return false;
		}

		$sql = "UPDATE `year` SET   `Year` = ?  WHERE Year_id  = ?";
		 $stmt = $this->conn->prepare($sql);
		$stmt->bind_param("si", $year, $year_id);
		if($stmt->execute()){
			$stmt->close();
			$this->conn->close();
			return true;
		}
	}
	public function edit_candidate($fullname, $Balotno,$Candidate_id){
		$stmt= $this->conn->prepare("UPDATE `candidate` SET `Candidate_fullname` = ?, `Balotno` =  ?  WHERE `Candidate_id` = ? ") or die($this->conn->error);
		$stmt->bind_param('ssi',$fullname, $Balotno,$Candidate_id);
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function edit_user($fullname, $username,$password,$status,$role,$year_id){
		$stmt=$this->conn->prepare("UPDATE `user` set `Fullname` = ?,`UserName`=?,`Password`=?,`account_status`=?,`role`=? WHERE `user_id`= ? ") or die($this->conn->error);
	$stmt->bind_param('sssssi',$fullname, $username,$password,$status,$role,$year_id);
	if ($stmt->execute()) {
		$stmt->close();
		$this->conn->close();
		return true;
	}

	}

	
}
?>
