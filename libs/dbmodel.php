<?php

class dbmodel {

	private $host = 'localhost';
	private $user = 'root';
	private $passwd = '';
	private $db = 'kehadiran';
	public $conn = '';
	
	public $idcol = '';
	public $table = '';
	
	public $errmsg = '';
		
	function __construct(){
		$this->conn = new mysqli(
			$this->host, 
			$this->user, 
			$this->passwd, 
			$this->db
		);
		
		if ($this->conn->connect_error) {
		  trigger_error('Database connection failed: '  . $this->conn->connect_error, E_USER_ERROR);
		}
	}
	
	function get( $id, $limit = 1, $offset = 0 ){
		$sql = "select * from {$this->table} where {$this->idcol} = ? limit $limit offset $offset";
		$stmt = $this->conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->error, E_USER_ERROR);
		}		
		$stmt->bind_param('i',$id);
        $stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			return $result->fetch_array(MYSQLI_ASSOC);
		}
		return false;		
	}
	
	function get_all( $limit = 0, $offset = 0){
		$sql = "select * from {$this->table}";
		if ($limit > 0) { $sql .= " limit $limit offset $offset"; }
		$stmt = $this->conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->error, E_USER_ERROR);
		}		
        $stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			  $rows[]=$row;
			}
			return $rows;
		}
		return false;		
	}
	
	function get_where( $data ) {
		if (!is_array( $data )) {
		  trigger_error('Wrong Parameter: get_where() requires an array as parameter', E_USER_ERROR);
		}
		
		$sql = "select * from {$this->table} where ";
		
		$types = '';
		$cols = array();
		foreach( $data as $k => $v ) {
			$vals[] = &$data[$k];
			switch (gettype($v)) {
				case 'boolean': 
					$types .= 'i';
				case 'integer': 
					$types .= 'i'; 
					$cols[] = "$k = ?";
					break;
				case 'double': 
					$cols[] = "$k = ?";
					$types .= 'd'; break;
				case 'string': 
					$cols[] = "$k like ?";
					$types .= 's'; break;
			}
		}
		
		$sql .= implode(' and ', $cols);
		$stmt = $this->conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->error, E_USER_ERROR);
		}		
		call_user_func_array(array($stmt, 'bind_param'), array_merge( array($types), $vals) ); 
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			  $rows[]=$row;
			}
			return $rows;
		}
		return false;				
	}
	
	function delete($id){
		$sql = "delete from {$this->table} where {$this->idcol} = ?";
		$stmt = $this->conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->error, E_USER_ERROR);
		}		
		$stmt->bind_param('i',$id);
        $stmt->execute();
		return $stmt->affected_rows;
	}
	
	function save( $data ) {
		if (!is_array( $data )) {
		  trigger_error('Wrong Parameter: save() requires array as parameter', E_USER_ERROR);
		}
		
		if (array_key_exists( $this->idcol, $data)) {
			$vals = array( str_repeat("s", count($data) + 1) ); // + 1 for where ?
			$cols = array();
			foreach( $data as $k => $v) {
				$cols[] = "$k = ?";
				$vals[] = &$data[$k];
			}
			$vals[] = &$data[$this->idcol]; // for the where idcol = ?
			
			$update_cols = implode(',', $cols);
			$sql = "update {$this->table} set {$update_cols} where {$this->idcol} = ?";
			$stmt = $this->conn->prepare($sql);			
			if($stmt === false) {
			  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->error, E_USER_ERROR);
			}
			call_user_func_array(array($stmt, 'bind_param'), $vals ); 

			$stmt->execute();
			return $stmt->affected_rows;
		} else {

			$params = array( str_repeat("s", count($data) ) ); // + 1 for where ?
			foreach( $data as $k => $v) {
				$cl[] = "$k";
				$vl[] = "?";
				$params[] = &$data[$k];
			}
			
			$cols = implode(',', $cl);
			$vals = implode(',', $vl);

			$sql = "insert into {$this->table} ($cols) values ($vals)";
			$stmt = $this->conn->prepare($sql);			
			if($stmt === false) {
			  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->error, E_USER_ERROR);
			}
			call_user_func_array(array($stmt, 'bind_param'), $params ); 
			$stmt->execute();
			if ( $stmt->affected_rows > 0 ) {
				return $stmt->insert_id;
			}
		}
		return false;
	}
	
}

