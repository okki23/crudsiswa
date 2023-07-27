<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiswaModel extends CI_Model {

	 private $tablename = 'siswa';

	 public function listing_data(){
		return $this->db->get($this->tablename)->result();
	 }

	 public function fetch_data($id){
		return $this->db->where('id',$id)->get($this->tablename)->row();
	 }

	 public function hapus_data($id){
		return $this->db->where('id',$id)->delete($this->tablename);
	 }
}
