<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {


	public function index() {
		$katalogTable = $this->db->get('katalog')->result();
		$jenisTable = $this->db->get('jenis')->result();
		$warnaTable = $this->db->get('warna')->result();
		$katalogRows = $this->db->get('katalog')->num_rows();
		$jenisRows = $this->db->get('jenis')->num_rows();
		$warnaRows = $this->db->get('warna')->num_rows();
		$rowKatalog = 1;
		$rowJenis = 1;
		$rowWarna = 1;
		$data = '';


		$data .= '{';


		// TAMPILKAN KATALOG //
		$data .= "\"katalog\" : [";
		foreach ($katalogTable as $katalog) {
			$data .= "{ 
				\"rowid\" : {$katalog->rowid},
				\"nama\" : \"{$katalog->nama}\",
				\"jenis\" : \"{$katalog->jenis}\",
				\"warna\" : \"{$katalog->warna}\",
				\"keterangan\" : \"{$katalog->keterangan}\",
				\"dicuci\" : {$katalog->dicuci},
				\"laundry\" : {$katalog->laundry},
				\"terakhir_dicuci\" : {$katalog->terakhir_dicuci}
			}";
			if ($rowKatalog < $katalogRows) $data .= ',';
			$rowKatalog++;
		}
		$data .= '],';


		// TAMPILKAN JENIS //
		$data .= "\"jenis\": [";
		foreach ($jenisTable as $jenis) {
			$data .= "{ 
				\"rowid\": {$jenis->rowid},
				\"nama\": \"{$jenis->nama}\",
				\"jenis\": \"{$jenis->jenis}\",
				\"jumlah\": \"{$jenis->jumlah}\"
			}";
			if ($rowJenis < $jenisRows) $data .= ',';
			$rowJenis++;
		}
		$data .= '],';


		// TAMPILKAN WARNA //
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
		$data .= ']';


		$data .= '}';
		header("Access-Control-Allow-Origin: *");
		echo $data;
	}



	public function timestamp() {
		header("Access-Control-Allow-Origin: *");
		$timestamp = $this->db->get('timestamp')->row();
		echo $timestamp->timestamp;
	}



	public function post() {
		header("Access-Control-Allow-Origin: *");
		if ($this->input->post('katalog') && $this->input->post('jenis') && $this->input->post('warna')) {
			$this->db->truncate('katalog');
			foreach($this->input->post('katalog') as $katalog) {
				$data = array(
					'rowid' => $katalog['rowid'],
					'nama' => $katalog['nama'],
					'jenis' =>$katalog['jenis'],
					'warna' => $katalog['warna'],
					'keterangan' => $katalog['keterangan'],
					'dicuci' => $katalog['dicuci'],
					'terakhir_dicuci' => $katalog['terakhir_dicuci']
				);
				$this->db->insert('katalog', $data);
			}

			$this->db->truncate('jenis');
			foreach($this->input->post('jenis') as $jenis) {
				$data = array(
					'rowid' => $jenis['rowid'],
					'nama' => $jenis['nama'],
					'jenis' =>$jenis['jenis'],
					'jumlah' => $jenis['jumlah']
				);
				$this->db->insert('jenis', $data);
			}

			$this->db->truncate('warna');
			foreach($this->input->post('warna') as $warna) {
				$data = array(
					'rowid' => $warna['rowid'],
					'warna' => $warna['warna'],
					'hex' => $warna['hex']
				);
				$this->db->insert('warna', $data);
			}


			$this->db->where('rowid', 1)->update('timestamp', array('timestamp' => $this->input->post('timestamp')));
		}

		else echo "Akses ditolak.";
	}


}