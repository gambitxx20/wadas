<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-3.5.1.min.js"></script>
</head>
<body>
	<div class="content p-2">
		<nav class="navbar navbar-expand navbar-light bg-light">
		  <a class="navbar-brand" href="#">
		    <h4>PT Wadas</h4>
		  </a>
		  <div class="navbar-nav">
		     <a class="nav-item nav-link" href="<?php echo base_url()?>">Home</a>
		    <a class="nav-item nav-link" href="<?php echo base_url()?>barang">Barang</a>
		    <a class="nav-item nav-link" href="<?php echo base_url()?>perusahaan">Perusahaan</a>
		    <a class="nav-item nav-link" href="<?php echo base_url()?>penjualan">Penjualan</a>
		    <a class="nav-item nav-link" href="<?php echo base_url()?>users">Users</a>
		  </div>
		  
		</nav>
		<div class="content-wrapper p-4">
			<h3>Perusahaan</h3>
			<a href="<?php echo base_url()?>perusahaan/add" class="btn btn-sm btn-success">Tambah Perusahaan</a>
			<table class="table my-2" id="perusahaanTable">
				<tr>
					<th>No</th>
					<th>Nama Perusahaan</th>
					<th>Action</th>
				</tr>
			</table>
		</div>
	</div>
</body>
<script type="text/javascript">
	getPerusahaan();
	function getPerusahaan(){
	    $.ajax({
	        url: '<?php echo base_url()?>api/perusahaan',
	        type: 'get',
	        dataType: 'json',
	        data: null,
	        contentType: 'application/json',
	        success: function (data) {
	            var a = JSON.stringify(data),
	            n = JSON.parse(a);
	            var no = 1
	            for (var i = 0; i < n.data.length; i++)
                {
                	var data = n.data[i];
	            $('#perusahaanTable').append('<tr>\
	            	<td>'+ no++ +'</td>\
	            	<td>'+data.nama+'</td>\
	            	<td class="w-25">\
	            		<a href="<?php echo base_url()?>perusahaan/edit/'+data.id+'" class="btn btn-primary btn-sm">Edit</a>\
	            		<a href="javascript:deleteperusahaan('+data.id+')" class="btn btn-danger btn-sm">Delete</a>\
	            	</td>\
	            	</tr>')          
                }
	        },
	    });
	}

	function deleteperusahaan(id) {
		$.ajax({
	        url: '<?php echo base_url()?>api/perusahaan',
	        type: 'Delete',
	        dataType: 'json',
	        data: JSON.stringify({id:id}),
	        contentType: 'application/json',
	        success: function (data) {
	            var a = JSON.stringify(data),
	            n = JSON.parse(a);

	            if (n.error == 0) {
	            	alert(n.message);
	            	window.location.href = '<?php echo base_url()?>perusahaan';
	            }
	        }
	    });
	}
</script>
</html>