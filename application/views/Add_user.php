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
			<h3>Add User</h3>
			
			<form class="mt-4 pt-2" id="userForm">
				<div class="form-group my-2">
					<label>Username</label>
				    <input type="text" class="form-control" id="username" placeholder="Enter Username">
				</div>
				<div class="form-group my-2">
					<label>Name</label>
				    <input type="text" class="form-control" id="name" placeholder="Enter Name">
				</div>
				<div class="form-group my-2">
					<label>Password</label>
				    <input type="password" class="form-control" id="password" placeholder="Enter Password">
				</div>
				<div class="form-group my-2">
					<input type="submit" class="btn btn-primary" id="submit">
				</div>
			</form>
		</div>
	</div>
</body>
<script type="text/javascript">
	$( "#userForm" ).submit(function( event ) {
	  event.preventDefault();
	  var data = {
	  	name : $("#name").val(),
	  	username : $("#username").val(),
	  	password : $("#password").val(),
	  }
	  $.ajax({
	        url: '<?php echo base_url()?>api/users',
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
	            	window.location.href = '<?php echo base_url()?>users';
				}	                                   
	        },
	    });
	});
</script>
</html>