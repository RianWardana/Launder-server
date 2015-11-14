<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sql extends CI_Controller {


	public function index() {
		$katalogTable = $this->db->order_by('nama', 'asc')->get('katalog')->result();
		$jenisTable = $this->db->order_by('nama', 'asc')->get('jenis')->result();
		$warnaTable = $this->db->order_by('warna', 'asc')->get('warna')->result();
		$katalogRows = $this->db->get('katalog')->num_rows();
		$jenisRows = $this->db->get('jenis')->num_rows();
		$warnaRows = $this->db->get('warna')->num_rows();
		$rowKatalog = 1;
		$rowJenis = 1;
		$rowWarna = 1;
		
		$sql = '';
		$newline = '</br>';


		// TAMPILKAN KATALOG //
		$sql .= "t.executeSql(\"drop table if exists katalog\")";
		$sql.= $newline;
		$sql .= "t.executeSql(\"create table katalog (nama unique, jenis, warna, keterangan, dicuci int, timeselesai integer)\")";
		$sql.= $newline;

		foreach ($katalogTable as $katalog) {
			$sql .= "t.executeSql(\"insert into katalog (nama, jenis, warna, keterangan, dicuci, timeselesai) 
				values(
					'{$katalog->nama}', 
					'{$katalog->jenis}', 
					'{$katalog->warna}', 
					'{$katalog->keterangan}', 
					{$katalog->dicuci}, 
					{$katalog->timeselesai}
				)\")
			";

			$sql .= $newline;
			$rowKatalog++;
		}
		$sql .= $newline;


		// TAMPILKAN JENIS //
		$sql .= "t.executeSql(\"drop table if exists jenis\")";
		$sql.= $newline;
		$sql .= "t.executeSql(\"create table jenis (nama unique, jenis unique, jumlah int)\")";
		$sql.= $newline;

		foreach ($jenisTable as $jenis) {
			$sql .= "t.executeSql(\"insert into jenis (nama, jenis, jumlah) 
				values(
					'{$jenis->nama}', 
					'{$jenis->jenis}', 
					'{$jenis->jumlah}'
				)\")
			";

			$sql .= $newline;
			$rowJenis++;
		}
		$sql .= $newline;


		// TAMPILKAN WARNA //
		$sql .= "t.executeSql(\"drop table if exists warna\")";
		$sql.= $newline;
		$sql .= "t.executeSql(\"create table warna (warna unique, hex unique)\")";
		$sql.= $newline;

		foreach ($warnaTable as $warna) {
			$sql .= "t.executeSql(\"insert into warna (warna, hex) 
				values(
					'{$warna->warna}',
					'{$warna->hex}'
				)\")
			";

			$sql .= $newline;
			$rowWarna++;
		}
		$sql .= $newline;


		/*// TAMPILKAN WARNA //
		$data .= "\"warna\": [";
		foreach ($warnaTable as $warna) {
			$data .= "{ 
				\"rowid\": {$warna->rowid},
				\"warna\": \"{$warna->warna}\",
				\"hex\": \"{$warna->hex}\"
			}";
			if ($rowWarna < $warnaRows) $data .= ',';
			$rowWarna++;
		}
		$data .= ']';*/


		header("Access-Control-Allow-Origin: *");
		echo $sql;
	}
}