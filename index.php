<?php
include('controller.php');
$login = False;
if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
	$login = True;
}

$rotarian_list = getRotarianList();
$rotaryClubList = getRotaryClubs();
?>
<html style="overflow-x:hidden">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

	<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.css" rel="stylesheet" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.full.js"></script>
	<script src="script.js"></script>
</head>
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
	select{
		width: -webkit-fill-available;
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
		body {
    		margin-left: 1%;
    		margin-right: 1%;
    	}
	}

	:root {
		--bs-border-color: black;
		--danger: red;
	}

	.required-color {
		color: var(--danger);
	}

	.error {
		color: var(--danger);
	}

	.dotted {
		border: 0;
		border-bottom: 2px dotted;
	}

	.textBox {
		width: fit-content !important;
	}

	.input-group>.form-control {
		margin-top: -5px !important;
	}

	.float-button.login {
		position: fixed;
		top: 20px;
		/* Adjust the distance from the bottom */
		right: 20px;
		/* Adjust the distance from the right */
		background-color: #007bff;
		color: white;
		padding: 10px 20px;
		border-radius: 5px;
		text-decoration: none;
		transition: background-color 0.3s ease;
	}

	.loading {
		position: fixed;
		top: 50%;
		/* Adjust the distance from the bottom */
		right: 50%;
		/* Adjust the distance from the right */
		left: 50%;
		bottom: 50%;
		background-color: transparent;
		color: white;
		padding: 10px 20px;
		border-radius: 5px;
		text-decoration: none;
		transition: background-color 0.3s ease;
		display: none;
	}

	.float-button.register {
		position: fixed;
		top: 80px;
		/* Adjust the distance from the bottom */
		right: 20px;
		/* Adjust the distance from the right */
		background-color: #007bff;
		color: white;
		padding: 10px 20px;
		border-radius: 5px;
		text-decoration: none;
		transition: background-color 0.3s ease;
	}

	.select2-container--default .select2-selection--single {
		border: 1px solid black;
	}

	.form-control {
		border: 1px solid var(--bs-border-color);
	}

	.disabled {
		pointer-events: none;
		/* Disable pointer events */
		opacity: 0.5;
	}
</style>

<body class="">
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
	<div>

		<form id="rotarianRegister" method="post">
			<input type="hidden" name="target" value="formSubmit">
			<input type="hidden" name="data" value="">

			<div style="padding-left: 3.5%;padding-right: 3.5%">

				<div class="form-group row">
					<div class="col">
						<label for="rotary_club_name" class="col-sm-2 col-form-label ">
							<h5 class="required">Rotary Club of</h5>
						</label>
						<select style="width: 100%" name="rotaryClubListSearch" id="rotaryClubListSearch" class="rotaryClubListSearch form-select">
							<option value=""></option>
							<?php foreach ($rotaryClubList as $option) { ?>
								<option value="<?php echo $option['key']; ?>"><?php echo $option['value']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<br>
				<div style="overflow:auto">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Board</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#ann" type="button" role="tab" aria-controls="profile" aria-selected="false">Others</button>
						</li>
					</ul>

					<div class="tab-content" id="myTabContent" style="overflow:auto">
						<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							<table class="table table-bordered table-hover" id="rotarianTable">
								<thead>
									<tr>
										<th scope="col">Sl.No</th>
										<th scope="col">Name</th>
										<th scope="col">Call Name</th>
										<th scope="col">Veg / Non-Veg</th>
										<th scope="col">Mobile</th>
										<th scope="col">Designation</th>
										<th scope="col">Collar Size</th>
									</tr>
								</thead>
								<tbody>

								</tbody>

							</table>

							<!-- <button type= "button" class="btn btn-info" id="add-rotrain" style="float: right;">Add</button> -->

						</div>
						<div class="tab-pane fade"  style="overflow:auto" id="ann" role="tabpanel" aria-labelledby="profile-tab">

							<table class="table table-bordered table-hover" id="annTable">
								<thead>
									<tr>
										<th scope="col">Sl.No</th>
										<th scope="col">Name</th>
										<th scope="col">Call Name</th>
										<th scope="col">Veg / Non-Veg</th>
										<th scope="col">Mobile</th>
										<th scope="col">Designation</th>
										<th scope="col">Collar Size</th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
							<button type="button" class="btn btn-info" id="add-ann" style="float: right;">Add</button>

						</div>
					</div>
				</div>
			</div>
			<div style="padding-left: 3.5%;padding-right: 3.5%;overflow:auto">
				<table class="table table-bordered table-hover" id="paymentTable">
					<thead>
						<tr>
							<th scope="col">Category</th>
							<th scope="col">Board (Per Club)</th>
							<th scope="col">Addl. Rotarian (per Head)</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">Registration Charges for Board</th>
							<td id="rotarianTotal">15000</td>
							<td id="annTotal">1500</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div style="text-align: center;padding-left: 3.5%;padding-right: 3.5%">
				<h5>Payment to be made in the form of Cheque / DD / NEFT / RTGS/UPI to</h5>
				<h4>Shri Visual Systems. - GPay: 9940068357
					Account No. 602305030162. ICICI Bank. IFSC Code: ICIC0006023</h4>
				<hr>
				<h4>PAYMENT DETAILS</h4>
				<div style="text-align:left;">
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group disabled">
								<label class="required" for="totalAmount">AMOUNT :</label>
								<input type="text" class="form-control dotted" name="totalAmount" id="totalAmount">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label for="transactionRef" class="required">CHEQUE No. / DD. No. / Transaction ID :</label>
								<input type="text" class="form-control dotted" name="transactionRef" id="transactionRef">
							</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label for="formFile" class="form-label required">Payment Confirmation </label>
								<input class="form-control" type="file" name="receipt" id="formFile">
							</div>
						</div>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="input-group" style="text-align: right;">
					<button type="submit" class="btn btn-primary" class="submit">Submit</button>
				</div>
			</div>
			<b>
				<hr>
			</b>
			<div class="row" style="text-align: center;">
				<div class="col-6">
					<h4>For Registration Contact:</h4>
					<h3> Rtn. Sriram Seshadri @ 9884017217</h3>
				</div>
				<div class="col-6">
					<h4>For any other matter related to District Training Assembly do contact:</h4>
					<h3>Rtn. AN Rajasekaran @ 9600099018 </br>
						DGE Rtn. N S Saravanan @ 9840096896</br>
						PDG Rtn J Sridhar @ 9790839030</br>
						Rtn. R Saptagiri @ 98411101610</br>
					</h3>
				</div>


			</div>

		</form>
	</div>
	<?php if ($login == False) { ?>
		<!-- <div class="float-button btn btn-primary login" id="login"> Admin</div> -->
	<?php } else { ?>
		<div class="btn float-button login" id="logout">Exit</div>
		<div class="btn float-button register" id="manage">manage</div>
	<?php } ?>
	<div class="loading"><img src="loading.gif" style="height: 40px;width: 40px;"></div>
</body>
<script type="text/javascript">
	var optionsvalues = <?php echo json_encode($rotarian_list); ?>;
	var rowHtml = "";
	var rotarianRowCount = 1;
	var annRowCount = 1;
	var annetteRowCount = 1;
	var optionsHTML = "";
	var collar_size = "<option value='0'>~~Select~~</option>\
						<option value='1'>XS/34</option>\
						<option value='2'>S/36</option>\
						<option value='3'>M/38</option>\
						<option value='4'>L/40</option>\
						<option value='5'>XL/42</option>\
						<option value='6'>2XL/44</option>\
						<option value='7'>3XL/46</option>\
						<option value='8'>4XL/48</option>";
	$(document).ready(function() {
		$('.required').append("<span class='required-color'>*</span>");
		clearErrors();
	});

	function calculateMemberRegistrationFee() {
		var data = $("form").serializeArray();
		$.ajax({
			url: "ajax.php",
			method: "post",
			data: {
				"target": "calculateMemberRegistrationFee",
				"data": {
					"value": data
				}
			},
			success: function(res) {
				var response = JSON.parse(res);
				/*$("#rotarianTotal").html(response.rotarian);				
				$("#annTotal").html(response.ann);				
				$("#annetteTotal").html(response.annette);*/
				$("#totalAmount").val(response.total);
			}
		});
	}

	function getRotarianHTML(count, designation) {
		rotarianRowHtml = "<tr>\
							<th scope='row'>" + count + "</th>\
							<td>\
								<select style='width: 100%' name ='rotarianSearch[]' id='rotarianSearch_" + count + "' class='rotarianSearch form-select'>" + optionsHTML;

		/*$.each(optionsvalues,function(index,value) {
			rotarianRowHtml += "<option value='"+value.key+"'>"+value.value+"</option>";
		});*/

		rotarianRowHtml += "</select>\
						</td>\
						<td><input type='text' class='form-control textBox' name='rotarian_call_name[]'id='rotarian_call_name" + count + "'></td>\
						<td>\
						<div class='form-check'>\
						<input class='form-check-input' type='radio' name='rotarian_checkVeg_" + count + "' value='1' id='rotarian_checkVeg" + count + "' checked>\
						<label class='form-check-label' for='rotarian_checkVeg" + count + "'>Veg</label>\
						</div>\
						<div class='form-check'>\
						<input class='form-check-input' type='radio' name='rotarian_checkVeg_" + count + "' value='2' id='rotarian_checkNonVeg" + count + "' >\
						<label class='form-check-label' for='rotarian_checkNonVeg" + count + "'>Non-Veg</label>\
						</div>\
						</td>\
						<td><input type='text' class='mobile form-control textBox' name='rotarian_mobile[]'id='rotarian_mobile" + count + "'></td>\
						<td class='designation'><input type='text' class='form-control textBox disabled' name='rotarian_designation[]'id='rotarian_designation" + count + "' value = '" + designation + "'></td>\
						<td><select style='width: auto' name ='rotarianCollarSize[]' id='rotarianCollarSize_" + count + "' class='rotarianCollarSize form-select'>" + collar_size+"</select></td>\
						</tr>";
		return rotarianRowHtml;
	}

	function getAnnHTML(count) {
		rotarianRowHtml = "<tr>\
							<th scope='row'>" + count + "</th>\
							<td>\
								<input type='text' class='ann_name form-control textBox' name='ann_name[]'id='ann_name_" + count + "'>\
						</td>\
						<td><input type='text' class='form-control textBox ann_call_name' name='ann_call_name[]'id='ann_call_name_" + count + "'></td>\
						<td>\
						<div class='form-check'>\
						<input class='form-check-input' type='radio' name='ann_checkVeg_" + count + "' value='1' id='checkVeg" + count + "' checked>\
						<label class='form-check-label' for='checkVeg" + count + "'>Veg</label>\
						</div>\
						<div class='form-check'>\
						<input class='form-check-input' type='radio' name='ann_checkVeg_" + count + "' value='2' id='checkNonVeg" + count + "' >\
						<label class='form-check-label' for='checkNonVeg" + count + "'>Non-Veg</label>\
						</div>\
						</td>\
						<td ><input type='text' class='form-control textBox' name='ann_mobile[]'id='ann_mobile" + count + "'></td>\
						<td ><input type='text' class='form-control textBox' name='ann_designation[]'id='ann_designation" + count + "'></td>\
						<td>\
						<select style='width: auto' name ='annCollarSize[]' id='annCollarSize_" + count + "' class='annCollarSize form-select'>" + collar_size+"</select></td>\
						</tr>";
		return rotarianRowHtml;
	}
	/*function getAnnetteHTML(count) {
		rotarianRowHtml = "<tr>\
						<th scope='row'>"+count+"</th>\
						<td>\
							<input type='text' class='form-control textBox annette_name' name='annette_name[]'id='annette_name_"+count+"'>\
					</td>\
					<td><input type='text' class='form-control textBox annette_call_name' name='annette_call_name[]'id='annette_call_name_"+count+"'></td>\
					<td>\
					<div class='form-check'>\
					<input class='form-check-input' type='radio' name='annette_checkVeg_"+count+"' value='1' id='annetteCheckVeg"+count+"' checked>\
					<label class='form-check-label' 
for='annetteCheckVeg"+count+"'>Veg</label>\
					</div>\
					<div class='form-check'>\
					<input class='form-check-input' type='radio' name='annette_checkVeg_"+count+"' value='2' id='annetteCheckNonVeg"+count+"' >\
					<label class='form-check-label' for='annetteCheckNonVeg"+count+"'>Non-Veg</label>\
					</div>\
					</td>\
					<td><input type='text' class='form-control textBox' name='annette_mobile[]'id='annette_mobile"+count+"'></td>\
					</tr>";
		return rotarianRowHtml;
	}*/

	function resetRotarian() {
		$(".rotarianSearch").change(function() {

			calculateMemberRegistrationFee();
			var rotarianMemberId = $(this).val();
			var element = $(this);
			$.ajax({
				url: "ajax.php",
				method: "post",
				data: {
					"target": "getRotarianDetail",
					"data": {
						"value": rotarianMemberId
					}
				},
				success: function(res) {
					var response = JSON.parse(res);
					if (response.status = "success") {
						var data = response.data;
						// console.log(data.mobile_no);

						element.closest("tr").find(".mobile").val(data.mobile_no);

					}
				}
			});
		});

		$(".ann_name").on("change", function() {
			calculateMemberRegistrationFee();
		});
		/*$(".annette_name").on("change",function(){
			calculateMemberRegistrationFee();
		});	*/


	}



	$(document).ready(function() {
		var rotarianTableElement = $("#rotarianTable");
		var annTableElement = $("#annTable");
		// var annetteTableElement = $("#annetteTable");
		var designation = {
			1: "President",
			2: "Secretary",
			3: "Treasurer",
			4: "Dir.-Club Service",
			5: "Dir.-Vocational Service",
			6: "Dir.-Comm Development",
			7: "Dir.Comm Health",
			8: "Dir.Youth Service",
			9: "Dir.Int. Service",
			10: "Chair-Mem. Development",
			11: "Chair-Foundation",
			12: "Chair-DEI",
			13: "Chair-Public Image",
			14: "Sergeant at Arms"
		}
		for (var key in designation) {
			if (designation.hasOwnProperty(key)) {
				rotarianTableElement.find('tbody').append(getRotarianHTML(key, designation[key]));

				/*annetteTableElement.find('tbody').append(getAnnetteHTML(annetteRowCount));*/
				rotarianRowCount++;

				/*annetteRowCount++;*/
			}
		}
		for (var i = 4; i >= 0; i--) {
			annTableElement.find('tbody').append(getAnnHTML(annRowCount));
			annRowCount++;
		}
		/*$('.rotarianSearch').select2();*/
		$('.rotaryClubListSearch').select2();
		/*$('.registerer_club').select2();
		$('.registerer_name').select2();*/
		/*$('.rotarianCollarSize').select2();
		$('.annCollarSize').select2();*/
		resetRotarian();

	});
	$("#add-rotrain").click(function() {
		var rotarianTableElement = $("#rotarianTable");


		rotarianTableElement.find('tbody').append(getRotarianHTML(rotarianRowCount));
		rotarianRowCount++;
		resetRotarian();
		$('.rotarianSearch').select2();
	});

	$("#add-ann").click(function() {
		var annTableElement = $("#annTable");


		annTableElement.find('tbody').append(getAnnHTML(annRowCount));
		annRowCount++;
		$('.rotarianSearch').select2();
		resetRotarian();
	});

	/*$("#add-annette").click(function () {
		var annetteTableElement = $("#annetteTable");
		

		annetteTableElement.find('tbody').append(getAnnetteHTML(annetteRowCount));
		annetteRowCount++;
		$('.rotarianSearch').select2();
		
		resetRotarian();
	});*/
	$("#login").click(function(e) {
		window.location.href = "admin/";
	});
	$("#manage").click(function(e) {
		window.location.href = "manageData.php";
	});
	$("#logout").click(function(e) {
		e.preventDefault();

		if (confirm("Are you sure logout ?")) {
			$.ajax({
				url: 'session.php', // PHP script to handle setting the session
				type: 'POST',
				data: {
					"method": "unsetSession"
				}, // Data to be sent to the server
				success: function(response) {
					// Handle success if needed
					window.location.href = "index.php";
				},
				error: function(xhr, status, error) {
					// Handle errors if any
					console.error('Error setting session value:', error);
				}
			});
		}
	});
</script>
<script src="script.js"></script>

</html>
