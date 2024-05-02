<?php 
	include "controller.php";
	if(!isset($_SESSION['username']) && !isset($_SESSION['password'])){
		header("Location: admin/");
    	exit();
	}
	$data = fetchEventRegisterDetails();
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	<!-- DataTables CSS -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

	<!-- jQuery -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

	<!-- DataTables JS -->
	<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
	<style type="text/css">
		@import url(//fonts.googleapis.com/css?family=Lato:300:400);

	body {
		margin-left: 9%;
		margin-right: 9%;
	}

	form {
		background: linear-gradient(60deg, rgba(71, 238, 235, 0.07) 0%, rgba(0, 251, 247, 0.07) 100%);
	}

	table {
		background: linear-gradient(60deg, rgba(71, 238, 235, 0.07) 0%, rgba(0, 172, 193, 1) 100%);
	}

	h1 {
		font-family: 'Lato', sans-serif;
		font-weight: 300;
		letter-spacing: 2px;
		font-size: 48px;
	}

	p {
		font-family: 'Lato', sans-serif;
		letter-spacing: 1px;
		font-size: 14px;
		color: #333333;
	}

	.header {
		position: relative;
		text-align: left;
		padding-left: 10px;
		background: linear-gradient(60deg, rgba(71, 238, 235, 0.07) 0%, rgba(0, 172, 193, 1) 100%);
		color: black;
	}

	.logo {
		width: 400px;
		fill: white;
		padding-right: 15px;
		display: inline-block;
		vertical-align: top;
	}

	.inner-header {
		height: 34vh;
		width: 100%;
		margin: 0;
		padding: 0;
	}

	.flex {
		/*Flexbox for containers*/
		display: flex;
		justify-content: flex-start;
		align-items: baseline;
		text-align: center;
	}

	.waves {
		position: relative;
		width: 100%;
		height: 15vh;
		margin-bottom: -7px;
		/*Fix for safari gap*/
		min-height: 50px;
		max-height: 100px;
	}

	.content {
		position: relative;
		height: 20vh;
		text-align: center;
		background-color: white;
	}

	/* Animation */

	.parallax>use {
		animation: move-forever 25s cubic-bezier(.55, .5, .45, .5) infinite;
	}

	.parallax>use:nth-child(1) {
		animation-delay: -2s;
		animation-duration: 7s;
	}

	.parallax>use:nth-child(2) {
		animation-delay: -3s;
		animation-duration: 10s;
	}

	.parallax>use:nth-child(3) {
		animation-delay: -4s;
		animation-duration: 13s;
	}

	.parallax>use:nth-child(4) {
		animation-delay: -5s;
		animation-duration: 20s;
	}

	@keyframes move-forever {
		0% {
			transform: translate3d(-90px, 0, 0);
		}

		100% {
			transform: translate3d(85px, 0, 0);
		}
	}

	/*Shrinking for mobile*/
	@media (max-width: 768px) {
		.waves {
			height: 2vh;
			min-height: 40px;
			width: 100%;
		}

		.content {
			height: 30vh;
		}

		h1 {
			font-size: 24px;
		}

		.inner-header {
			height: 18vh;
			width: 100%;
			margin: 0;
			padding: 0;
		}

		.logo {
			width: 200px;
			fill: white;
			padding-right: 15px;
			display: inline-block;
			vertical-align: top;
		}

		h5 {
			font-family: 'Lato', sans-serif;
			font-weight: 280;
			letter-spacing: 1px;
			font-size: 12px;
		}
	}
		.float-button.login {
			position: fixed;
			top: 20px; /* Adjust the distance from the bottom */
			right: 20px; /* Adjust the distance from the right */
			background-color: #007bff;
			color: white;
			padding: 10px 20px;
			border-radius: 5px;
			text-decoration: none;
			transition: background-color 0.3s ease;
		}
		.float-button.register {
			position: fixed;
			top: 80px; /* Adjust the distance from the bottom */
			right: 20px; /* Adjust the distance from the right */
			background-color: #007bff;
			color: white;
			padding: 10px 20px;
			border-radius: 5px;
			text-decoration: none;
			transition: background-color 0.3s ease;
		}.float-button.export {
			position: fixed;
			top: 140px; /* Adjust the distance from the bottom */
			right: 20px; /* Adjust the distance from the right */
			background-color: #007bff;
			color: white;
			padding: 10px 20px;
			border-radius: 5px;
			text-decoration: none;
			transition: background-color 0.3s ease;
		}
		.float-button:hover {
			
		}
	</style>

</head>
<body style="padding-left: 9%;padding-right: 9%;">
	
	<div class="header">

		<!--Content before waves-->
		<div class="inner-header flex ">
			<img class="logo" src="DistrictThemeLogo.svg">
		</div>
		<div>
			<h3>RID 3234 District Training Assembly</h3>
			<h5>April 27, 2024 @ Hotel Green Park, Vadapalani, Chennai</h5>
		</div>

		<!--Waves Container-->
		<div>
			<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
				<defs>
					<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
				</defs>
				<g class="parallax">
					<use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
					<use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
					<use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
					<use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
				</g>
			</svg>
		</div>
		<!--Waves end-->

	</div>
	<table id="myDataTable" class="table">
	    <thead>
	        <tr>
	            <th>ID</th>
	            <th>Club Name</th>
	            <th>Name</th>
	            <th>Call Name</th>
	            <th>Type</th>
	            <th>Food Prefrence</th>
	            <th>Transaction Ref.</th>
	            <th>Designation</th>
	            <th>Collar Size</th>
	            <th>Action</th>
	            <!-- Add more table headers as needed -->
	        </tr>
	    </thead>
	    <tbody>
	    	<?php foreach($data as $row){ ?>
	        <tr>
	            <td><?php echo $row["id"]; ?></td>
	            <td><?php echo $row["clubName"]; ?></td>
	            <td><?php echo $row["name"]; ?></td>
	            <td><?php echo $row["callName"]; ?></td>
	            <td><?php echo $row["type"]; ?></td>
	            <td><?php echo $row["foodPrefrence"]; ?></td>
	            <td><?php echo $row["transaction_ref"]; ?></td>
	            <td><?php echo $row["designation"];?></td>
	            <td><?php echo $row["collar_size"];?></td>
	            <td><a href="<?php echo $row["receipt_path"]; ?>" target="new"><i class="fa fa-download"></i></a></td>
	            <!-- Add more table data rows as needed -->
	        </tr>
	    <?php }?>
	        <!-- More rows -->
	    </tbody>
	</table>
	<div class="btn float-button login" id="logout">Logout</div>
	<div class="btn float-button register" id="register">Register</div>
	<div class="btn float-button export" id="export">Export <i class='fas fa-file-export'></i></div>

</body>
<script type="text/javascript">
	$(document).ready(function() {

	    $('#myDataTable').DataTable({
	        "paging": true, // Enable pagination
	        "searching": true, // Enable search functionality
	        // Add more options as needed
	    });
	});

	$("#logout").click(function(e){
		e.preventDefault();

		if(confirm("Are you sure logout ?")){
			$.ajax({
		            url: 'session.php', // PHP script to handle setting the session
		            type: 'POST',
		            data: {"method":"unsetSession" }, // Data to be sent to the server
		            success: function(response) {
		                // Handle success if needed
		                window.location.href ="index.php";
		            },
		            error: function(xhr, status, error) {
		                // Handle errors if any
		                console.error('Error setting session value:', error);
		            }
		        });
		}
	});

	$("#register").click(function(e){
		e.preventDefault();

		window.location.href = "/";
	});
	$("#export").click(function (e) {
		window.location.href ="export.php"
	});

</script>
</html>