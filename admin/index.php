<?php
	include "../controller.php";

	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		header("Location: ../manageData.php");
    	exit();
	}
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Registration form Sangamam to Directory Details</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
		<link rel="stylesheet" href="../node_modules/mdbootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../node_modules/mdbootstrap/css/mdb.min.css">
		<link rel="stylesheet" href="../node_modules/mdbootstrap/css/style.css">

		<script type="text/javascript" src="../node_modules/mdbootstrap/js/jquery.min.js"></script>
		<script type="text/javascript" src="../node_modules/mdbootstrap/js/popper.min.js"></script>
		<script type="text/javascript" src="../node_modules/mdbootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../node_modules/mdbootstrap/js/mdb.min.js"></script>
		<script type="text/javascript" src="../script.js"></script>

		<style>
			#snackbar {
			  	visibility: hidden;
			  	min-width: 250px;
			  	margin-left: -125px;
			  	background-color: #333;
			  	color: #fff;
			  	text-align: center;
			  	border-radius: 2px;
			  	padding: 16px;
			  	position: fixed;
			  	z-index: 1;
			  	left: 50%;
			  	bottom: 30px;
			  	font-size: 17px;
			}

			#snackbar.show {
			  	visibility: visible;
			  	-webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
			  	animation: fadein 0.5s, fadeout 0.5s 2.5s;
			}

			@-webkit-keyframes fadein {
			  	from {bottom: 0; opacity: 0;} 
			  	to {bottom: 30px; opacity: 1;}
			}

			@keyframes fadein {
			  	from {bottom: 0; opacity: 0;}
			  	to {bottom: 30px; opacity: 1;}
			}

			@-webkit-keyframes fadeout {
			  	from {bottom: 30px; opacity: 1;} 
			  	to {bottom: 0; opacity: 0;}
			}

			@keyframes fadeout {
			  	from {bottom: 30px; opacity: 1;}
			  	to {bottom: 0; opacity: 0;}
			}
		</style>
	</head>
	<body>
		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-6 text-center mb-5">
						<h2 class="heading-section"></h2>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-md-7 col-lg-5">
						<div class="login-wrap p-4 p-md-5">
							<div class="icon d-flex align-items-center justify-content-center">
								<span class="fa fa-user-o"></span>
							</div>
							<h3 class="text-center mb-4">Sign In</h3>
							<form action="" id="login" method="post" class="login-form">
								<div class="form-group">
									<input type="text" class="form-control rounded-left" id="username" name="username" placeholder="Mobile No" required>
									<div id="sendOtp" class="btn btn-success" name="send_otp">Send</div>
								</div> 
								<div class="form-group d-flex">
									<input type="password" class="form-control rounded-left" id="password" name="password" placeholder="OTP" required>
								</div>
								<div class="form-group">
									<button type="submit" name="submit" id="login_submit" class="form-control btn btn-primary rounded submit px-3">Login</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div id="snackbar"></div>
	</body>
	<script type="text/javascript">
		function validateMobileNumber(mobileNumber) {
		    // Regular expression to match a typical 10-digit mobile number
		    var regex = /^[0-9]{10}$/;
		    if(regex.test(mobileNumber)){
		    	$.ajax({
		    		url:"../ajax.php",
		    		type:"POST",
		    		data:{
		    			"target":"userValid",
						"data" : {"value":mobileNumber}
		    		},
		    		success: function (response) {
		    			var result = JSON.parse(response);
		    			result = JSON.parse(result);
		    			if(result.status == "success"){
		    				if(result.data[0]){
		    					sendOtp();
		    					var msg = "OTP sending...";
		    					toast(msg);
		    				}
		    				else{
		    					alert("User does not exist");
		    				}
		    			}else{
		    				alert(result.message);
		    			}
		    		}
		    	});
		    }
		}
		function sendOtp(){
			var user = $("#username").val()
			$.ajax({
	            url: '../session.php', // PHP script to handle setting the session
	            type: 'POST',
	            data: { "phoneNo":user,
	            		"method":"sendOtp" }, // Data to be sent to the server
	            success: function(response) {
	                /*Handle success if needed*/
	                
	                responseData = JSON.parse(response);
	                if(responseData.status == "Success"){
	                	$("#sendOtp").hide();
	                	$("#password").show();
						$("#username").attr("readonly", true);
						$("#login_submit").show();
	                }

	                
	                
	            },
	            error: function(xhr, status, error) {
	                // Handle errors if any
	                console.error('Error setting session value:', error);
	            }
	        });
		}

		$(document).ready(function(){
			$("#password").hide();
			$("#login_submit").hide();
		});
		$("#sendOtp").click(function(e){
			e.preventDefault();

			var user = $("#username").val();
			validateMobileNumber(user)
			// /*if(validateMobileNumber(user)){

			// 	$.ajax({
		    //         url: '../session.php', // PHP script to handle setting the session
		    //         type: 'POST',
		    //         data: { "phoneNo":user,
		    //         		"method":"sendOtp" }, // Data to be sent to the server
		    //         success: function(response) {
		    //             /*Handle success if needed
		    //             window.location.href = "../manageData.php";*/
		    //             responseData = JSON.parse(response);
		    //             if(responseData.status == "Success"){
		    //             	$("#sendOtp").hide();
		    //             	$("#password").show();
			// 				$("#username").attr("readonly", true);
			// 				$("#login_submit").show();

		    //             }

		                
		                
		    //         },
		    //         error: function(xhr, status, error) {
		    //             // Handle errors if any
		    //             console.error('Error setting session value:', error);
		    //         }
		    //     });
			// }else{
			// 	console.log("Invalid mobile number")
			// }*/


			

		});

		$("#login").on("submit",function(e){
			e.preventDefault();

			var user = $("#username").val();
			var pass = $("#password").val();
			var data ={
				"username" : user,
				"password":pass
				}
			$.ajax({
	            url: '../session.php', // PHP script to handle setting the session
	            type: 'POST',
	            data: { "setSession":data,
	            		"method":"setSession" }, // Data to be sent to the server
	            success: function(response) {
	                var result = JSON.parse(response);
	                if(result.status == 'success'){
	                	toast("OTP successfully verified");
	                	setTimeout(function(){ window.location.href = "../index.php"; }, 3000);
	                	
	                }else{
	                	toast(result.message);
	                }
	            },
	            error: function(xhr, status, error) {
	                // Handle errors if any
	                console.error('Error setting session value:', error);
	            }
	        });
		});
	</script>
</html>
