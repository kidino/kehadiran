<?php

class kursus extends dbmodel {

	var $idcol = 'kursus_id';
	var $table = 'kursus';

	function kehadiran( $kursus_id ){
		$sql = "select pelajar.* from kursus_pelajar left join pelajar
		on kursus_pelajar.pelajar_id = pelajar.pelajar_id
		where kursus_id = $kursus_id";

		$stmt = $this->conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->error, E_USER_ERROR);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$pelajar_kursus = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			  $pelajar_kursus[]=$row;
			}
		}

		$sql = "select * from kelas where kursus_id = $kursus_id order by tarikh_masa asc";

		$stmt = $this->conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->error, E_USER_ERROR);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$kelas_kursus = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			  $kelas_kursus[]=$row;
			}
		}

		$sql = "select kehadiran.* from kehadiran left join kelas
		on kehadiran.kelas_id = kelas.kelas_id
		where kelas.kursus_id = $kursus_id";

		$stmt = $this->conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $this->conn->error, E_USER_ERROR);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$kehadiran = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_array(MYSQLI_ASSOC)) {
			  $kehadiran[$row['kelas_id']][$row['pelajar_id']]  = $row['hadir'];
			}
		}

		return array(
			'pelajar' => $pelajar_kursus,
			'kelas' => $kelas_kursus,
			'kehadiran' => $kehadiran
		);

	}

	function clear_kehadiran($kursus_id){
		$sql = "delete from kehadiran where kelas_id in (select kelas_id from kelas where kursus_id = $kursus_id)";
		$stmt = $this->conn->prepare($sql);
		$stmt->execute();
		return $stmt->affected_rows;
	}

	function add_kehadiran( $kehadiran ) {
		$sql = "insert into kehadiran (kelas_id, pelajar_id, hadir) values (?,?,?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param('iis', $kelas_id, $pelajar_id, $hadir);

		foreach($kehadiran as $kh){
			$kelas_id = $kh['kelas_id'];
			$pelajar_id = $kh['pelajar_id'];
			$hadir = $kh['hadir'];
			$stmt->execute();
		}
	}
}
