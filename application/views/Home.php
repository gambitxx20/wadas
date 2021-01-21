<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
	<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-3.5.1.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
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
		  <div class="text-right">
		  	<a href="<?php echo base_url()?>login/logout" class="nav-item nav-link text-gray-700">Logout</a>
		  </div>
		</nav>

		<div class="content-wrapper p-4">
			<h3>Home</h3>
			<
			<div class="w-75 mx-auto">
				<h6>Transaksi Harian</h6>	
				<canvas id="myChart" width="400" height="200"></canvas>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	getUsers();
	function getUsers(){
	    $.ajax({
	        url: '<?php echo base_url()?>api/Users',
	        type: 'get',
	        dataType: 'json',
	        data: null,
	        contentType: 'application/json',
	        success: function (data) {
	            var a = JSON.stringify(data),
	            n = JSON.parse(a);
	            console.log(n);                        
	        },
	    });
	}
</script>

<script>
getPenjualan();
	function getPenjualan(){
	    $.ajax({
	        url: '<?php echo base_url()?>api/penjualan/daily',
	        type: 'get',
	        dataType: 'json',
	        data: null,
	        contentType: 'application/json',
	        success: function (data) {
	            var a = JSON.stringify(data),
	            n = JSON.parse(a);
	            var date = [];
	            var summary = [];
	            for (var i = 0; i < n.data.length; i++)
                {
                	var data = n.data[i];
                	summary.push(data.total)
                	date.push(data.created_date)

                }

	            var ctx = document.getElementById('myChart').getContext('2d');
	            var myChart = new Chart(ctx, {
	                type: 'bar',
	                data: {
	                    labels: date,
	                    datasets: [{
	                        label: '# of Votes',
	                        data: summary,
	                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
	                        borderWidth: 1
	                    }]
	                },
	                options: {
	                    scales: {
	                        yAxes: [{
	                            ticks: {
	                                beginAtZero: true
	                            }
	                        }]
	                    }
	                }
	            });

	        },
	    });
	}

</script>
</html>