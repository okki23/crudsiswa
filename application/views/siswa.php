<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Bootstrap User Management Data Table</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
 
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
</head>
<body>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2>Siswa <b>Management</b></h2>
						<br>
						<a href="javascript:void(0);" onclick="AddData();" class="btn btn-secondary"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
						<br> &nbsp;
                    </div>
                    <div class="col-sm-7">
						<!-- tambahkan fungsi untuk buka form -->
                        
                        <!-- <a href="#" class="btn btn-secondary"><i class="material-icons">&#xE24D;</i> <span>Export to Excel</span></a>						 -->
                    </div>
                </div>
            </div>

            <table class="table table-striped table-hover" id="example">
                <thead>
                    <tr> 
                        <th>Nama</th>						
                        <th>Alamat</th>
                        <th>Telpon</th> 
                        <th>Action</th>
                    </tr>
                </thead> 
            </table>
            
        </div>
    </div>
</div>     



<!-- Modal -->
<div class="modal fade" id="AddDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        
      </div>
      <div class="modal-body">
	
	  <form action="" enctype="multipart/form-data" id="formdata">
		<input type="hidden" id="id" name="id">
	  	<label for=""> Nama</label>
		<input type="text" name="nama" id="nama" class="form-control">
		<br>
		<label for=""> Alamat</label>
		<input type="text" name="alamat" id="alamat" class="form-control">
		<br>
		<label for=""> Telp</label>
		<input type="number" name="telp" id="telp" class="form-control">
		<br> 
		<button type="button" name="save" id="save" onclick="Save();" class="btn btn-primary"> Simpan </button>
		<button type="button" class="btn btn-secondary" onclick="CloseModal();" data-dismiss="modal">Close</button>
	  </form>

      </div>
    
    </div>
  </div>
</div>

</body>
<script>

	$(document).ready(function(){
		$("#example").DataTable({
			"ajax": "<?php echo base_url(); ?>siswa/listing" 
		});
	});

	function AddData(){
		Bersihkan_Form();
		$('#AddDataModal').modal('show');
	}

	function Save(){
		var nama = $("#nama").val();
		var alamat = $("#alamat").val();
		var telp = $("#telp").val();
		var id = $("#id").val();
		$.ajax({
			url:"<?php echo base_url('siswa/simpan'); ?>",
			data:{id:id,nama:nama,alamat:alamat,telp:telp},
			type:"POST",
			success:function(result){
				var data = JSON.parse(result);
				console.log(data.code);
				if(data.code == 200){
					$('#AddDataModal').modal('hide');
					$('#example').DataTable().ajax.reload(); 
					Bersihkan_Form();
					if(id != NULL){
						alert('Data Was Inserted');
					}else{
						alert('Data Was Updated');
					}
					
				}else{
					$('#AddDataModal').modal('hide');
					alert('Error');
				}
			}
		});
	}

	function CloseModal(){
		$('#AddDataModal').modal('hide');
	}

	function Ubah_Data(id){
		  
		$.ajax({
			 url:"<?php echo base_url(); ?>siswa/fetch_data/"+id,
			 type:"GET",
			 dataType:"JSON", 
			 success:function(result){  
				 $("#AddDataModal").modal('show'); 
				 $("#id").val(result.id);
                 $("#nama").val(result.nama); 
                 $("#alamat").val(result.alamat); 
				 $("#telp").val(result.telp); 
                
			 }
		 });
	 }
 
	 function Bersihkan_Form(){
        $(':input').val('');  
     }

	 function Hapus_Data(id){
		if(confirm('Anda yakin ingin menghapus data ini?'))
        {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo base_url('siswa/hapus_data')?>/"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
			   
               $('#example').DataTable().ajax.reload(); 
			   
			    $.notify("Data berhasil dihapus!", {
					animate: {
						enter: 'animated fadeInRight',
						exit: 'animated fadeOutRight'
					}  
				 },{
					type: 'success'
					});
				 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
   
    }
	}
    
       


</script>
</html>
