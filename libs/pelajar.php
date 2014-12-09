<?php

class pelajar extends dbmodel {

	var $idcol = 'pelajar_id';
	var $table = 'pelajar';

	function in_kursus( $pelajar_id, $kursus_id ){
		$sql = "select * from kursus_pelajar where pelajar_id = $pelajar_id and kursus_id = $kursus_id limit 1";
		$stmt = $this->conn->prepare($sql);
        $stmt->execute();
		$result = $stmt->get_result();
		return ($result->num_rows > 0);
	}

	function add_kursus( $pelajar_id, $kursus_id ){
		$sql = "insert into kursus_pelajar ( pelajar_id, kursus_id) values ($pelajar_id, $kursus_id)";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return ($stmt->affected_rows > 0 );
	}

}
