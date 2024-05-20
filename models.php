<?php
	include 'db.php';

	function fetchRotariansList($club_value = "")
	{
		
		$data = [];
		$where = "";
		if($club_value != "")
			$where = "WHERE club_name = '".$club_value."'";
		$sql = "SELECT 
					member_id,
					full_name,
					phone_number 
				FROM rotary_members_new
				".$where." order by full_name";
		$result = $GLOBALS['conn']->query($sql);

		if ($result->num_rows > 0) {
		  // output data of each row
		  	while($row = $result->fetch_assoc()) {
		    	$data[] = $row;
		  	}
		  	return $data;
		} else {
		  return [];
		}
	}

	function fetchRotaryClubList()
	{
		$data = [];
		$sql = "SELECT distinct club_name FROM rotary_members_new";
		$result = $GLOBALS['conn']->query($sql);

		if ($result->num_rows > 0) {
		  // output data of each row
		  	while($row = $result->fetch_assoc()) {
		    	$data[] = $row;
		  	}
		  	return $data;
		} else {
		  echo "0 results";
		}
	}

	function fetchRotaryTeamsList()
	{
		$data = [];
		$sql = "SELECT id,team_name FROM rotary_team";
		$result = $GLOBALS['conn']->query($sql);

		if ($result->num_rows > 0) {
		  // output data of each row
		  	while($row = $result->fetch_assoc()) {
		    	$data[] = $row;
		  	}
		  	return $data;
		} else {
		  echo "0 results";
		}
	}


	function fetchRotariansDetails($value)
	{
		$data =[];
		$sql = "SELECT * from rotary_members_new where member_id = {$value}";
		$result = $GLOBALS['conn']->query($sql);

		if ($result->num_rows > 0) {
		  // output data of each row
		  	while($row = $result->fetch_assoc()) {
		    	$data[] = $row;
		  	}
		  	return $data[0];
		}
	}

	function insertRotariansDetails($data)
	{
		foreach ($data as $row) {
			if($row['rotarianSearch'] != ""){
			    $sql = "INSERT INTO register_event (name, call_name,type, food_preference, mobile,fktransaction_id,designation,collar_size) VALUES ('".$row['rotarianSearch']."','".$row['rotarian_call_name']."',1,{$row['foodPrefrence']},'".$row['rotarian_mobile']."',".$row['fktransaction_id'].",'".$row['rotarian_designation']."','".$row['collar_size']."')";
			    
			    if ($GLOBALS['conn']->query($sql) !== TRUE) {
			        message("Error: " . $sql . "<br>" . $GLOBALS['conn']->error);
			    }
			}
		}
	}

	function insertRotarianTeamDetails($data){
		$conn = $GLOBALS['conn'];
		foreach ($data as $row) {
			if($row['team_member_id'] == ""){
				$sql =" INSERT INTO rotary_team_members (team_id, member_id, member_designation, creator_mobile, classfication,file_name,file_path) VALUES ('".$row['team_id']."','".$row['member_id']."','".$row['member_designation']."','".$row['creator_mobile']."','".$row['classfication']."','".$row['file_name']."','".$row['file_path']."')";
			}else{
				$fileSQL =" ";
				if($row['file_name'] != ""){
					$fileSQL = ",file_name = '".$row['file_name']."',file_path = '".$row['file_path']."'";
				}
				$sql = "
					UPDATE rotary_team_members SET
					team_id = '".$row['team_id']."',
					member_id = '".$row['member_id']."',
					classfication = '".$row['classfication']."',
					member_designation = '".$row['member_designation']."',
					creator_mobile = '".$row['creator_mobile']."',
					date_madified = '".date('Y-m-d H:i:s')."'".$fileSQL."
					WHERE id = '".$row['team_member_id']."'
				";
			}
			

			if ($conn->query($sql) !== TRUE) {
		        message("Error: " . $sql . "<br>" . $conn->error);
		    }
		}
	}
	function insertTransactionDetails($data){
		$conn = $GLOBALS['conn'];
	    $sql = "INSERT INTO rotary_transactions (transaction_ref, receipt_path,transaction_date, total_amount, registerer_id, registerer_email, registerer_mobile,registerer_gst) VALUES ('".$data['transactionRef']."','".$data['transactionRecipt']."','".$data['transactionDate']."','".$data['totalAmount']."','".$data['rotaryClubListSearch']."','".$data['registerer_email']."','".$data['registerer_mobile']."','".$data['registerer_gst']."')";
	    
	    
	    if ($conn->query($sql) !== TRUE) {
	        message("Error: " . $sql . "<br>" . $conn->error);
	    }else{
	    	return array("id" => $conn->insert_id);
	    }
	    

	}
	function insertAnnDetails($data)
	{
		foreach ($data as $row) {
			if($row['ann_name'] != ""){
			    $sql = "INSERT INTO register_event (name, call_name,type, food_preference, mobile,fktransaction_id,designation,collar_size) VALUES ('".$row['ann_name']."','".$row['ann_call_name']."',2,{$row['foodPrefrence']},'".$row['ann_mobile']."',".$row['fktransaction_id'].",'".$row['ann_designation']."',".$row['collar_size'].")";
			    
			    if ($GLOBALS['conn']->query($sql) !== TRUE) {
			        message("Error: " . $sql . "<br>" . $GLOBALS['conn']->error);
			    }
			}
		}
	}
	function insertAnnetteDetails($data)
	{
		foreach ($data as $row) {
			if($row['annette_name'] != ""){
			    $sql = "INSERT INTO register_event (name, call_name,type, food_preference, mobile, fktransaction_id) VALUES ('".$row['annette_name']."','".$row['annette_call_name']."',3,{$row['foodPrefrence']},'".$row['annette_mobile']."',".$row['fktransaction_id'].")";
			    
			    if ($GLOBALS['conn']->query($sql) !== TRUE) {
			        message("Error: " . $sql . "<br>" . $GLOBALS['conn']->error);
			    }
			}
		}
	}

	function getEventRegisterDetails()
	{
		$data =[];
		$sql ="
				SELECT 
				    re.register_event_id AS id,
				    CASE 
				        WHEN re.type = 1 THEN (SELECT full_name FROM rotary_members_new WHERE member_id = re.name)
				        ELSE re.name
				    END AS name,
				    re.call_name AS callName,
				    CASE 
				        WHEN re.type = 1 THEN 'Rotarian'
				        WHEN re.type = 2 THEN 'Ann'
				        ELSE 'Annette'
				    END AS type,
				    CASE 
				        WHEN re.food_preference = 1 THEN 'Veg'
				        ELSE 'Non-Veg'
				    END AS foodPreference,
				    CASE 
				        WHEN re.type = 1 THEN (SELECT phone_number FROM rotary_members_new WHERE member_id = re.name)
				        ELSE re.mobile
				    END AS mobile,
				    rt.transaction_ref AS transaction_ref,
				    rt.receipt_path AS receipt_path,
				    (SELECT full_name FROM rotary_members_new WHERE member_id = rt.registerer_id) AS registrerName,
				    rt.registerer_id AS clubName,
				    rt.registerer_gst AS gst,
				    re.designation AS designation,
				    CASE 
				        WHEN re.collar_size = 1 THEN '34'
				        WHEN re.collar_size = 2 THEN '36'
				        WHEN re.collar_size = 3 THEN '38'
				        WHEN re.collar_size = 4 THEN '40'
				        WHEN re.collar_size = 5 THEN '42'
				        WHEN re.collar_size = 6 THEN '44'
				        WHEN re.collar_size = 7 THEN '46'
				        WHEN re.collar_size = 8 THEN '48'
				        ELSE ''
				    END AS collar_size
				FROM 
				    register_event re
				LEFT JOIN 
				    rotary_transactions rt ON re.fktransaction_id = rt.transaction_id
    			";
    	$result = $GLOBALS['conn']->query($sql);

		if ($result->num_rows > 0) {
		  // output data of each row
		  	while($row = $result->fetch_assoc()) {
		    	$data[] = $row;
		  	}
		  	return $data;
		} else {
		  echo "0 results";
		}
	}

	function getTransactionDetails()
	{
		$data =[];
		$sql ="
				SELECT 
						rt.transaction_id as id,
						rt.transaction_ref as transactionRef,
						rt.total_amount as amount,
						rt.transaction_date as date,
						rt.receipt_path as receipt_path,
						(select full_name from rotary_members_new where member_id = rt.registerer_id) as registrerName,
						(select club_name from rotary_members_new where member_id = rt.registerer_id) as clubName,
						rt.registerer_email as email,
						rt.registerer_mobile as mobile,
						rt.registerer_gst as gst
				FROM rotary_transactions rt
    			";
    	$result = $GLOBALS['conn']->query($sql);

		if ($result->num_rows > 0) {
		  // output data of each row
		  	while($row = $result->fetch_assoc()) {
		    	$data[] = $row;
		  	}
		  	return $data;
		} else {
		  echo "0 results";
		}
	}

	function insertSpouseDetails($data){

		if(count(getRotarianSpouseDetails($data['rotarian_id'])) > 0){
			$sql = "UPDATE rotary_spouse_details 
			SET 
				spouse_name='".$data['spouse_name']."',
				spouse_dob_day ='".$data['spouse_dob_day']."',
				spouse_dob_month ='".$data['spouse_dob_month']."',
				member_dob_day ='".$data['rotarion_dob_day']."',
				member_dob_month ='".$data['rotarion_dob_month']."',
				wedding_anniversary = '".$data['wedding_anniversary']."',
				spouse_phone = '".$data['spouse_phone']."'
			WHERE member_id = '".$data['rotarian_id']."'";
		}else{

	    	$sql = "INSERT INTO rotary_spouse_details (member_id, spouse_name,spouse_dob_day, spouse_dob_month, member_dob_day, member_dob_month, wedding_anniversary,spouse_phone) VALUES ('".$data['rotarian_id']."','".$data['spouse_name']."','".$data['spouse_dob_day']."','".$data['spouse_dob_month']."','".$data['rotarion_dob_day']."','".$data['rotarion_dob_month']."','".$data['wedding_anniversary']."','".$data['spouse_phone']."')";
		}
		
	    if ($GLOBALS['conn']->query($sql) !== TRUE) {
	        message("Error: " . $sql . "<br>" . $GLOBALS['conn']->error);
	        return array("error"=>1,"message"=>"Faild insert data.");
	    }else{
	    	return array("error"=>0,"message"=>"record inserted successfully");
	    }
	}

	function getRotarianSpouseDetails($rotarian_id)
	{
		$sql = "SELECT *
				FROM rotary_spouse_details
				WHERE member_id = '".$rotarian_id."'";

		$result = $GLOBALS['conn']->query($sql);
		if ($result->num_rows > 0) {
		  // output data of each row
		  	while($row = $result->fetch_assoc()) {
		    	$data[] = $row;
		  	}
		  	return $data;
		} else {
		  return [];
		}
	}

	function fetchRotarianTeamDetails($team_id){
		$sql = "SELECT 
					* 
				FROM rotary_team_members rtm
				LEFT JOIN rotary_members_new rm
				ON rm.member_id = rtm.member_id
				WHERE rtm.team_id = '".$team_id."'";
		$result = $GLOBALS['conn']->query($sql);
		if ($result->num_rows > 0) {
		  // output data of each row
		  	while($row = $result->fetch_assoc()) {
		    	$data[] = $row;
		  	}
		  	return array("status"=>"success","message"=>"Successfully fetched given team details.","data"=>$data);
		} else {
		 	return array("status"=>"failed","message"=>"Team does not decleared","data"=>[]);
		}

	}

	function getUserDetailsByPhone($mobile_no)
	{
		$data =[];
		$sql ="
				SELECT 
				*
				FROM rotary_members_new rmn
				LEFT JOIN register_event re
				ON rmn.member_id = re.name
				WHERE rmn.phone_number = '${mobile_no}'";
    	$result = $GLOBALS['conn']->query($sql);

		if ($result->num_rows > 0) {
		  // output data of each row
		  	while($row = $result->fetch_assoc()) {
		    	$data[] = $row;
		  	}
		  	return array("status"=>"success","message"=>"User is there given number.","data"=>$data);
		} else {
		 	return array("status"=>"faild","message"=>"User does not exist");
		}
	}