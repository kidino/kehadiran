<?php
include('autoload.php');

$db = new dbconnection();

if (array_key_exists('action',$_POST)) {


	switch(trim($_POST['action'])){
		case 'add_tarikh_masa':
			$kursus_id = trim($_POST['kursus_id']);
			$tarikh_masa = trim($_POST['tarikh_masa']);
			$kelas = new kelas($db);
			if (validateMysqlDate($tarikh_masa)) {
				$kelas->save( array(
					'kursus_id' => $kursus_id,
					'tarikh_masa' => $tarikh_masa
				) );
			}
			header('Location: kehadiran.php?kursus_id='.$kursus_id);
			break;
		case 'delete_kelas':
			$kelas = new kelas($db);
			$kelas_id = trim($_POST['kelas_id']);
			$thiskelas = $kelas->get($kelas_id);
			$kelas->delete($kelas_id);
			$kelas->clear_kehadiran($kelas_id);
			header('Location: kehadiran.php?kursus_id='.$thiskelas['kursus_id']);
			break;
		case 'add_pelajar':
			$pelajar = new pelajar($db);
			$no_matrik = trim($_POST['no_matrik']);
			$kursus_id = trim($_POST['kursus_id']);
			$p = $pelajar->get_where( array( 'no_matrik' => $no_matrik ) );
			//dumper($p);
			if (is_array($p[0])
			&& array_key_exists('pelajar_id',$p[0])
			&& ( !$pelajar->in_kursus( $p[0]['pelajar_id'], $kursus_id ) )) {
				$pelajar->add_kursus( $p[0]['pelajar_id'], $kursus_id );
			}
			header('Location: kehadiran.php?kursus_id='.$kursus_id);
			break;
		case 'update_kehadiran':
			$kursus_id = trim($_POST['kursus_id']);
			$kursus = new kursus($db);

			$khinput = $_POST['kehadiran'];
			$kehadiran = array();
			foreach($khinput as $k) {
				list($kelas_id, $pelajar_id) = explode('-', $k);
				$kehadiran[] = array(
					'pelajar_id' => $pelajar_id,
					'kelas_id' => $kelas_id,
					'hadir' => 'Y'
				);
			}

			$kursus->clear_kehadiran( $kursus_id );
			$kursus->add_kehadiran( $kehadiran );
			header('Location: kehadiran.php?kursus_id='.$kursus_id.'&updated=1');
			break;
	}
} else {

$kursus_id = trim($_GET['kursus_id']);

$kursus = new kursus($db);
$kursus_info = $kursus->get( $kursus_id );
$pensyarah = new pensyarah($db);
$pensyarah_info = $pensyarah->get( $kursus_info['pensyarah_id'] );
$kehadiran = $kursus->kehadiran( $kursus_id );

?>
<html>
<head><title>Kehadiran Kursus</title></head>
<body>
<h1>Kehadiran</h1>
<h3><?php echo $kursus_info['kod_kursus']; ?> - <?php echo $pensyarah_info['nama']; ?></h3>

<form action="kehadiran.php" method="post">
	<input type="hidden" name="action" value="add_tarikh_masa" />
	<input type="hidden" name="kursus_id" value="<?php echo $kursus_id?>" />
	<input type="text" name="tarikh_masa" value="" placeholder="contoh: 2014-01-01 10:30:00" />
	<input type="submit" value="tambah kelas" /><br>
	<em>YYYY-MM-DD HH:MM:SS dengan format 24-jam<br>contoh: 2014-01-01 10:30:00 untuk 1 Jan 2014, 10.30 pagi</em>
</form>

<form action="kehadiran.php" method="post">
	<input type="hidden" name="action" value="add_pelajar" />
	<input type="hidden" name="kursus_id" value="<?php echo $kursus_id?>" />
	<input type="text" name="no_matrik" value="" placeholder="MA000001" />
	<input type="submit" value="tambah pelajar" /><br>
	<em>masukkan nombor matrik pelajar</em>
</form>

<?php
echo "<table border=\"1\">\n\t<tr>\n\t\t<td>Pelajar</td>";
foreach( $kehadiran['kelas'] as $k ) {
	echo "\n\t\t<td width='80'>".str_replace(' ','<br />',$k['tarikh_masa'])."<br />";
	echo "<form action='kehadiran.php' method='post'>";
	echo "<input type='hidden' name='action' value='delete_kelas' />";
	echo "<input type='hidden' name='kelas_id' value='$k[kelas_id]' />";
	echo "<input type='submit' value=' X ' />";
	echo "</form></td>";
}
echo "\n\t</tr>";
echo "<form action=\"kehadiran.php\" method=\"post\">";
echo "<input type=\"hidden\" name=\"action\" value=\"update_kehadiran\" />";
echo "<input type=\"hidden\" name=\"kursus_id\" value=\"". $kursus_id ."\" />";
foreach( $kehadiran['pelajar'] as $p ) {
	echo "\n\t<tr>\n\t\t<td>[ $p[no_matrik] ] $p[nama]</td>";
	foreach( $kehadiran['kelas'] as $k ){
		$x = @$kehadiran['kehadiran'][$k['kelas_id']][$p['pelajar_id']];
		$checked = ($x != null) ? ' checked="checked"' : '';
		echo "\n\t\t".'<td><input name="kehadiran[]" type="checkbox" value="'.$k['kelas_id'].'-'.$p['pelajar_id'].'"'.$checked.' /></td>';
	}
	echo "\n\t</tr>";
}
echo '<tr><td colspan="'. (count($kehadiran['kelas']) + 1) .'" align="right">';
if (array_key_exists('updated', $_GET) && ($_GET['updated'] == 1)) {
echo '<strong>kehadiran telah dikemaskini</strong>';
}
echo '<input type="submit" value="kemaskini kehadiran"></td></tr>';
echo "</form></table>";

} // else action
?>
</body>
</html>
