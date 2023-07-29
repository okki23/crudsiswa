<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pegawai extends CI_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pegawaimodel'); 
	}
	
	public function index()
	{
		$this->load->view('siswa');  
	}


	public function listing(){
		try{
			$getdata = $this->pegawaimodel->listing_data();
			
			
			$data = array();  
			$no = 1;
			foreach($getdata as $row)  
			{  
				 $sub_array = array();  
				 $sub_array['id'] = $row->id;    
				 $sub_array['name'] = $row->nama;   
				 $sub_array['desg'] = $row->posisi;   
				 $sub_array['salary'] = $row->gajih;      
				 $data[] = $sub_array;  
				 $no++;
			}  
			echo json_encode(array('result'=>$data)); 

		}catch(Exception $e){
			echo json_encode(array('status'=>false,'code'=>400));
		}	
	}

	
	public function fetch_data(){  
		$id = $this->uri->segment(3); 
		$getdata = $this->pegawaimodel->fetch_data($id);
		echo json_encode($getdata);   
	 }
  
  

	public function simpan(){ 
		try{

			$id = $this->input->post('id');

			if($id){

				$data = array(
					'nama' => $this->input->post('name'),
					'posisi' =>  $this->input->post('desg'),
					'gajih' =>  $this->input->post('salary')
				);
	
				$this->db->where('id',$id)->update('tb_pegawai', $data);
				echo json_encode(array('status'=>true,'code'=>200));
			}else{
				
				$data = array(
					'nama' => $this->input->post('name'),
					'posisi' =>  $this->input->post('desg'),
					'gajih' =>  $this->input->post('salary')
				);
	
				$this->db->insert('tb_pegawai', $data);
				echo json_encode(array('status'=>true,'code'=>200));
			}
			
		}catch(Exception $e){
			echo json_encode(array('status'=>false,'code'=>400));
		}	 

	}

	public function hapus_data(){
		$id = $this->uri->segment(3);   
   		$sqlhapus = $this->pegawaimodel->hapus_data($id);
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
}
