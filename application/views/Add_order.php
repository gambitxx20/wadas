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
			<h3>Order Baru</h3>
			
			<form class="mt-4 pt-2" id="barangForm">
				<div class="form-group my-2">
					<label>Perusahaan</label>
					<select id="perusahaan" class="form-control">
						
					</select>
				</div>
				<div class="form-group my-2">
					<label>Nama Barang</label>
					<select id="barang" class="form-control">
						<option></option>
					</select>
				</div>
				<div class="form-group my-2">
					<label>Quantity</label>
				    <input type="number" class="form-control" id="qty" placeholder="Masukkan Jumlah Barang"  min="1" value="0" required>
				</div>
				<div class="form-group my-2">
					<label>Harga Barang</label>
				    <input type="number" class="form-control" id="harga" step="1000" required>
				</div>
				<div class="form-group my-2">
					<label>Total Harga Barang</label>
				    <input type="number" class="form-control" id="total_harga" step="1000" readonly>
				</div>
				<div class="form-group my-2">
					<input type="submit" class="btn btn-primary" id="submit">
				</div>
			</form>
		</div>
	</div>
</body>
<script type="text/javascript">
	$( "#barangForm" ).submit(function( event ) {
	  event.preventDefault();
	  var data = {
	  	id_perusahaan : $("#perusahaan").val(),
	  	id_barang : $("#barang").val(),
	  	qty_barang : $("#qty").val(),
	  	harga_barang : $("#harga").val(),
	  }
	  $.ajax({
	        url: '<?php echo base_url()?>api/penjualan',
	        type: 'post',
	        dataType: 'json',
	        async : false,
	        data: JSON.stringify(data),
	        contentType: 'application/json',
	        success: function (data) {
	              
	            var a = JSON.stringify(data),
	            n = JSON.parse(a);  

	            alert(n.message);
				if (n.success == 1) {
	            	window.location.href = '<?php echo base_url()?>penjualan';
				}	                                   
	        },
	    });
	});


	getPerusahaan();
	getBarang();
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
	            for (var i = 0; i < n.data.length; i++)
                {	
                	var data = n.data[i];
                	$("#perusahaan").append('<option value=' + data.id + '>' + data.nama + '</option>');
                }
	        },
	    });
	}

	function getBarang(){
		$.ajax({
	        url: '<?php echo base_url()?>api/barang',
	        type: 'get',
	        dataType: 'json',
	        data: null,
	        contentType: 'application/json',
	        success: function (data) {
	            var a = JSON.stringify(data),
	            n = JSON.parse(a);
	            for (var i = 0; i < n.data.length; i++)
                {	
                	var data = n.data[i];
                	$("#barang").append('<option value=' + data.id + '>' + data.nama + '</option>');
                }
	        },
	    });
	}

	function getDetailBarang(id){
		$.ajax({
	        url: '<?php echo base_url()?>api/barang/'+id,
	        type: 'get',
	        dataType: 'json',
	        data: null,
	        contentType: 'application/json',
	        success: function (data) {
	            var a = JSON.stringify(data),
	            n = JSON.parse(a);
	            console.log(n);
	            var harga = n.harga;
	            var qty = $('#qty').val();
	            $("#harga").val(harga);
	            $("#total_harga").val(harga*qty);
	        },
	    });
	}

	$('#barang').on('change', function() {
	  getDetailBarang(this.value);
	});

	$('#qty').on('input', function() {
    	harga = $('#harga').val();
    	qty = $('#qty').val();
    	$("#total_harga").val(harga*qty);
  	});
</script>
</html>