<?php
	include('models.php');
	include('validation.php');
	session_start();
	function message($message) {
	    // Set the file path for the log file
	    $logFile = 'log/error.log';

	    // Get the current date/time
	    $timestamp = date('Y-m-d H:i:s');

	    // Construct the log entry
	    $logEntry = "[$timestamp] $message\n";

	    // Open the log file in append mode or create it if it doesn't exist
	    if ($file = fopen($logFile, 'a')) {
	        // Write the log entry to the file
	        fwrite($file, $logEntry);
	        fclose($file); // Close the file handle
	    } else {
	        // Handle errors if unable to open the file
	        echo "Unable to open or create the log file.";
	        // You might want to log this failure elsewhere or handle it according to your needs
	    }
	}

	function getRotarianList($club_value = ""){
		try {
			$data = fetchRotariansList($club_value);
			
			$dropDownOptions = [];
			foreach ($data as $value) {
				$dropDownOptions[] = [
					"key" => $value["member_id"],
					"value" => $value["full_name"],
					"mobile"=> $value["phone_number"]
				];
			}
			return $dropDownOptions;
		} catch (Exception $e) {
			message($e);
		}
		
	}

	function getRotaryClubs($value='')
	{
		try {
			$data = fetchRotaryClubList();
			$dropDownOptions = [];
			foreach ($data as $value) {
				$dropDownOptions[] = [
					"key" => $value["club_name"],
					"value" => $value["club_name"]
				];
			}
			return $dropDownOptions;
		} catch (Exception $e) {
			message($e);
		}
	}

	function getRotaryTeams($value='')
	{
		try {
			$data = fetchRotaryTeamsList();
			$dropDownOptions = [];
			foreach ($data as $value) {
				$dropDownOptions[] = [
					"key" => $value["id"],
					"value" => $value["team_name"]
				];
			}
			return $dropDownOptions;
		} catch (Exception $e) {
			message($e);
		}
	}

	function getRotarianDetailsByID($id)
	{
		try {
			$data = fetchRotariansDetails($id);
			$data = [
				"mobile_no" => $data['phone_number'],
				"club_name" => $data['club_name'],
				"email_address" => $data['email_address'],
				"rotary_member_id" => $data["rotary_member_id"]
			];
			return $data;
		} catch (Exception $e) {
			message($e);
		}
	}

	function formatAndInsertData($formData,$rotarion_image)
	{
		try {
			$rotariansDetails = [];
			$annDetails = [];
			$annetteDetails = [];

			$rotarianValidationRule = [
				"rotarian_designation" => "string",
				"rotarian_classfication" => "string"
			];
			// message(json_encode($rotarion_image));
			/*$annValidationRule = [
				"ann_name" => "string",
				"ann_call_name" =>"string",
				"ann_checkVeg" => "notnull"
			];*/
			/*$annetteValidationRule = [
				"annette_name" => "string",
				"annette_call_name" =>"string",
				"annette_checkVeg" => "notnull"
			];*/
			/*$transactionData =[
				"rotaryClubListSearch" => $formData['rotaryClubListSearch'],
				"transactionRef" => $formData['transactionRef'],
				"transactionDate" => date("Y-m-d"),
				"totalAmount" => $formData['totalAmount'],
				"receipt" => $receipt
			];*/
			// $transactionValidateRule = [
			// 	"transactionRef" => "notnull",
			// 	"receipt" => "file",
			// 	"totalAmount" => "notnull"
			// ];
			// $transactionValidateResult = validateFormData($transactionData,$transactionValidateRule);
			$rotariansValidateResult = validateFormData($formData,$rotarianValidationRule);
			// $annValidateResult = validateFormData($formData,$annValidationRule);
			/*$annetteValidateResult = validateFormData($formData,$annetteValidationRule);*/

			if(($rotariansValidateResult["error"]==1) || ($annValidateResult["error"] == 1) || ($annetteValidateResult["error"] == 1)||$transactionValidateResult['error'] == 1){
				$validateErrors = [
					"rotarian" => $rotariansValidateResult["data"],
					"ann" => $annValidateResult["data"],
					"annette" => $annetteValidateResult["data"],
					"transaction" => $transactionValidateResult["data"]
				];
				return array("error" => 1,"message"=> "Invalid data.", "data" => $validateErrors);
			}else{
				/*$target_dir = "uploads/".$formData."/";
				$targetFile = $target_dir . basename($receipt["name"]);
				move_uploaded_file($receipt["tmp_name"], $targetFile);
				$transactionData["transactionRecipt"] =$targetFile;
				$transactionRecord = insertTransactionDetails($transactionData);*/
			}
			$team_id = $formData['rotaryClubListSearch'];
			$target_dir = "uploads/".$team_id."/";
			if (!is_dir($target_dir)){
				if (mkdir($target_dir)) {
					message("dir created successfully");
				}
			}
			for ($i=0; $i < count($formData['rotarianSearch']); $i++) { 
				
				$image = $rotarion_image;
				$targetFile = $target_dir . basename($image["name"][$i]);
				move_uploaded_file($image["tmp_name"][$i], $targetFile);
				
				$rotariansDetails[] = [
					"team_id" => $team_id,
					"team_member_id"=>$formData["team_member_id"][$i],
					"member_id" =>$formData['rotarianSearch'][$i],
					"rotarian_call_name"=> $formData['rotarian_call_name'][$i],
					"creator_mobile"=> $_SESSION['username'],
					"member_designation" => $formData['rotarian_designation'][$i],
					"classfication" => $formData['rotarian_classfication'][$i],
					"file_name" => basename($image["name"][$i]),
					"file_path" => $targetFile
				];
			}

			/*for ($i=0; $i < count($formData['ann_checkVeg']); $i++) { 
				$annDetails[] = [
					"ann_name" =>$formData['ann_name'][$i],
					"ann_call_name"=> $formData['ann_call_name'][$i],
					"foodPrefrence"=> $formData['ann_checkVeg'][$i],
					"ann_mobile"=> $formData['ann_mobile'][$i],
					"member_type" => 2,
					"ann_designation" => $formData['ann_designation'][$i],
					"collar_size" => $formData['annCollarSize'][$i],
					"fktransaction_id"=>$transactionRecord['id']
				];
			}*/

			/*for ($i=0; $i < count($formData['annette_checkVeg']); $i++) { 
				$annetteDetails[] = [
					"annette_name" =>$formData['annette_name'][$i],
					"annette_call_name"=> $formData['annette_call_name'][$i],
					"foodPrefrence"=> $formData['annette_checkVeg'][$i],
					"annette_mobile"=> $formData['annette_mobile'][$i],
					"member_type" => 3,
					"fktransaction_id"=>$transactionRecord['id']
				];
			}*/			

			insertRotarianTeamDetails($rotariansDetails);
			// insertRotariansDetails($rotariansDetails);
			// insertAnnDetails($annDetails);
			/*insertAnnetteDetails($annetteDetails);*/
			
			return array("error" => 0,"message"=> "Rotarians are register successfully!.", "data" => []);
		} catch (Exception $e) {
			message($e);
		}
		
	}

	function validateFormData($formData,$validationRule){
		try {
			$error = [];
			foreach($validationRule as $col => $rule){

				$data = $formData[$col];
				$rules = explode("|",$rule);
				foreach($rules as $entity){
					$result = validate($data,$entity);
					
					if($result["error"] == 1){
						if(!empty($result["data"]))
							$error[$col] = $result["data"]; 
					}
				}
			}
			if(count($error) > 0){
				return array("error" => 1,"message"=>"Invaid fields", "data" =>$error);
			}
			else{
				return array("error" => 0,"message"=>"Form verified", "data" =>[]);;
			}
		} catch (Exception $e) {
			message($e);
		}	
	}

	function fetchEventRegisterDetails()
	{
		return getEventRegisterDetails();
	}

	function fetchTransactionDetails()
	{
		return getTransactionDetails();
	}

	function saveSpouseFormData($data){
		$validationRule = [
			"rotarian_id" =>"notnull",
			"rotarion_dob"=>"notnull",
			"spouse_dob"=>"notnull",
			"spouse_email"=>"notnull",
			"spouse_name"=>"notnull",
			"spouse_phone"=>"notnull",
			"wedding_anniversary" =>"notnull"
		];

		$validationResult = validateFormData($data,$validationRule);
		if($validationResult["error"] == 1){
			return $validationResult;
		}else{
			return insertSpouseDetails($data);
		}
	}

	function fetchRotarianSpouseInfo($member_id)
	{
		$result = getRotarianSpouseDetails($member_id);

		if(count($result) > 0){
			return array("status"=>"success","message"=>"Rotarian Spouse details already updated.", "data"=>$result[0]);
		}else{
			return array("status"=>"failed","message"=>"Rotarian Spouse details doesn't exist.");
		}
	}

	function getRotarianTeamDetails($team_id){
		$data = fetchRotarianTeamDetails($team_id);
		return $data;
	}

	function validateSmsResponse($response)
	{
		switch ($response) {
			case '101':
				return array("status"=>"Faild","message"=>"Invalid user");
				break;
			case '102':
				return array("status"=>"Faild","message"=>"Invalid sender ID");
				break;
			case '103':
				return array("status"=>"Faild","message"=>"Invalid contact(s)");
				break;
			case '104':
				return array("status"=>"Faild","message"=>"Invalid route");
				break;
			case '105':
				return array("status"=>"Faild","message"=>"Invalid message");
				break;
			case '106':
				return array("status"=>"Faild","message"=>"Spam blocked");
				break;
			case '107':
				return array("status"=>"Faild","message"=>"Promotional block");
				break;
			case '108':
				return array("status"=>"Faild","message"=>"Low credits in the specified route");
				break;
			case '109':
				return array("status"=>"Faild","message"=>"Promotional route will be working from 9am to 8:45pm only");
				break;
			case '110':
				return array("status"=>"Faild","message"=>"Invalid DLT Template ID");
				break;
			default:
				return array("status"=>"Success","message"=>"OTP Send Successfully");
				break;
		}
	}