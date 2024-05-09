<?php
include 'controller.php';

$method = $_POST['target'];
$getData = $_POST['data'];

switch ($method) {
	case 'getRotarians':
		echo json_encode(getRotariansByClubID($getData['value']));
		break;
	case 'getRotarianDetail':
		echo json_encode(getRotariansDetails($getData['value']));
		break;
	case 'formSubmit':
		echo json_encode(saveFormData($_REQUEST));
		break;
	case 'calculateMemberRegistrationFee':
		echo json_encode(calculateMemberFees($getData['value']));
		break;
	case 'spouseFormSubmit':
		echo json_encode(spouseFormSubmit($getData));
		break;
	case 'spouseFormDetails':
		echo json_encode(spouseFormDetails($getData['value']));
		break;
	case 'userValid':
		echo json_encode(checkUserValid($getData['value']));
		break;
	default:
		return print("Undefined function...");
		break;
}

function getRotariansByClubID($value)
{
	$data = getRotarianList($value);
	return array("status" => "success", "data" => $data);
}

function getRotariansDetails($value)
{
	$data = getRotarianDetailsByID($value);
	return array("status" => "success", "data" => $data);
}

function saveFormData($data, $getFormCal = false)
{
	// $formData = [];
	// print_r($data);die();
	foreach ($data as $key => $value) {
		// if($key != 'rotaryClubListSearch'){
		$index = $key;
		if ($key == 'rotarion_image') {
			$formData['rotarion_image'] = $value;
		}
		if (isset($formData[$index])) {
			/*if (strpos($index, "rotarian_checkVeg") !== false) {
				$formData["rotarian_checkVeg"][] = $value;
			} elseif (strpos($index, "ann_checkVeg") !== false) {
				$formData["ann_checkVeg"][] = $value;
			} elseif (strpos($index, "annette_checkVeg") !== false) {
				$formData["annette_checkVeg"][] = $value;
			} else {*/
			$formData[$index] = $value;
			// }
		}else{
			$formData[$index] = $value;
		}


		// }

	}
	// print_r($formData);die();
	if ($getFormCal) {
		return $formData;
	}
	$result = formatAndInsertData($formData, $_FILES['rotarion_image']);
	if ($result["error"] == 1) {
		return $result;
	} else {
		return $result;
	}

	// return array("status"=>"success","message"=>"Data updated successfully","data"=>$result);
}

function calculateMemberFees($data)
{
	$formData = formDataArrange($data);
	$rotarian_sum = 0;
	$ann_sum = 0;
	$annette_sum = 0;
	$rotarian_sum = 15000;
	/* foreach ($formData['rotarianSearch[]'] as $rotarian) {
		if ($rotarian != "") {
			$rotarian_sum = $rotarian_sum + 4500;
		}
	} */
	foreach ($formData['ann_name[]'] as $ann) {
		if ($ann != "") {
			$ann_sum = $ann_sum + 1500;
		}
	}
	foreach ($formData['annette_name[]'] as $annette) {
		if ($annette != "") {
			$annette_sum = $annette_sum + 2500;
		}
	}
	$total = $rotarian_sum + $ann_sum + $annette_sum;


	return array("rotarian" => $rotarian_sum, "ann" => $ann_sum, "annette" => $annette_sum, "total" => $total);
}

function formDataArrange($data)
{
	$formData = [];
	foreach ($data as $form) {
		if ($form['name'] != 'rotaryClubListSearch') {
			$index = $form['name'];
			if (isset($formData[$index])) {
				if (strpos($index, "rotarian_checkVeg") !== false) {
					$formData["rotarian_checkVeg"][] = $form['value'];
				} elseif (strpos($index, "ann_checkVeg") !== false) {
					$formData["ann_checkVeg"][] = $form['value'];
				} elseif (strpos($index, "annette_checkVeg") !== false) {
					$formData["annette_checkVeg"][] = $form['value'];
				} elseif (strpos($index, "rotarianSearch")) {
					$formData["rotarianSearch"][] = $form['value'];
				} else {
					$formData[$index][] = $form['value'];
				}
			} else {
				if (strpos($index, "rotarian_checkVeg") !== false) {
					$formData["rotarian_checkVeg"][] = $form['value'];
				} elseif (strpos($index, "ann_checkVeg") !== false) {
					$formData["ann_checkVeg"][] = $form['value'];
				} elseif (strpos($index, "annette_checkVeg") !== false) {
					$formData["annette_checkVeg"][] = $form['value'];
				} elseif (strpos($index, "rotarianSearch")) {
					$formData["rotarianSearch"][] = $form['value'];
				} else {
					$formData[$index][] = $form['value'];
				}
			}
		}
	}
	return $formData;
}

function spouseFormSubmit($data){
	$result = [];
	$result = saveSpouseFormData($data);
	return $result;
}

function spouseFormDetails($member_id){
	return fetchRotarianSpouseInfo($member_id);
}
function checkUserValid($value){

	$data = getUserDetailsByPhone($value);
	$result = "";
	if((isset($data['status'])) && ($data['status'] == "success")){
		if(isset($data['data'][0])){
			$user = $data['data'][0];
			$user_role = $user["designation"];


			if(($user_role == "President") || ($user_role == "Secretary")){
				$result = json_encode(array("status"=>"success","message"=>"User is valid"));
			}
			else{
				$result = json_encode(array("status"=>"faild","message"=>"invalid user"));
			}

		}else{
			$result = json_encode(array("status"=>"faild","message"=>"User does not exist."));
		}
		
	}else{
		$result = json_encode($data);
	}

	return json_encode($data);
}
