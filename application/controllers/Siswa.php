<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {
 
	public function __construct()
	{
		parent::__construct();
		$this->load->model('siswamodel'); 
	}
	
	public function index()
	{
		$this->load->view('siswa');  
	}


	public function listing(){
		try{
			$getdata = $this->siswamodel->listing_data();
			
			$data = array();  
			$no = 1;
			foreach($getdata as $row)  
			{  
				 $sub_array = array(); 
  
				 $sub_array[] = $row->nama;   
				 $sub_array[] = $row->alamat;   
				 $sub_array[] = $row->telp;    
				 $sub_array[] = '
				 <a href="javascript:void(0)" class="btn btn-warning btn-xs waves-effect" id="edit" onclick="Ubah_Data('.$row->id.');" > <i class="material-icons">create</i> Ubah </a>  &nbsp; 
				 <a href="javascript:void(0)" id="delete" class="btn btn-danger btn-xs waves-effect" onclick="Hapus_Data('.$row->id.');" > <i class="material-icons">delete</i> Hapus </a>  &nbsp;';  
				 $sub_array[] = $row->id;   
				 $data[] = $sub_array;  
				 $no++;
			}  
			echo json_encode(array('data'=>$data)); 

		}catch(Exception $e){
			echo json_encode(array('status'=>false,'code'=>400));
		}	
	}

	
	public function fetch_data(){  
		$id = $this->uri->segment(3); 
		$getdata = $this->siswamodel->fetch_data($id);
		echo json_encode($getdata);   
	 }
  
  

	public function simpan(){ 
		try{

			$id = $this->input->post('id');

			if($id){

				$data = array(
					'nama' => $this->input->post('nama'),
					'alamat' =>  $this->input->post('alamat'),
					'telp' =>  $this->input->post('telp')
				);
	
				$this->db->where('id',$id)->update('siswa', $data);
				echo json_encode(array('status'=>true,'code'=>200));
			}else{
				
				$data = array(
					'nama' => $this->input->post('nama'),
					'alamat' =>  $this->input->post('alamat'),
					'telp' =>  $this->input->post('telp')
				);
	
				$this->db->insert('siswa', $data);
				echo json_encode(array('status'=>true,'code'=>200));
			}
			
		}catch(Exception $e){
			echo json_encode(array('status'=>false,'code'=>400));
		}	 

	}

	public function hapus_data(){
		$id = $this->uri->segment(3);   
   		$sqlhapus = $this->siswamodel->hapus_data($id);
		if($sqlhapus){
			$result = array("response"=>array('message'=>'success'));
		}else{
			$result = array("response"=>array('message'=>'failed'));
		}
		
		echo json_encode($result,TRUE);
	}
}
