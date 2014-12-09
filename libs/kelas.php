<?php

class kelas extends dbmodel {

	var $idcol = 'kelas_id';
	var $table = 'kelas';

	function clear_kehadiran( $kelas_id ){
		$sql = "delete from kehadiran where kelas_id = $kelas_id";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->affected_rows;
	}

}
