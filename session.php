<?php
include "controller.php";
// Start the session

function sendOTP($mobile,$otp)
{
    $data = array(
        "key" => "dd51cf7f902acaa51f6d20ebff2ad934",
        "route" => 7,
        "sender" => "PIXCSS",
        "number" => $mobile,
        "sms" => $otp." is your Sirudanyam.com verification code PIXCSS",
        "templateid" =>"1707168820328291905"
    );
    $api_url = "http://login.olasms.in/api/smsapi?".http_build_query($data);

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => $api_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        'Cookie: ci_session=1fpkk0dn3eclq86hvio4qs47pdfeuk78'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $responseResult = validateSmsResponse($response);
    if($responseResult['status'] = "Success"){
        $_SESSION['mobile'] = $mobile;
        $_SESSION['otp'] = $otp;
    }
    return $responseResult;

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['method']) && ($_POST['method'] == "setSession"))
    {
        if (isset($_POST['setSession'])) {
            $userData = $_POST['setSession'];
            if(($userData['username'] == $_SESSION['mobile']) && ($userData['password'] == $_SESSION['otp'])){
                foreach($_POST['setSession'] as $key => $value)
                    $_SESSION[$key] = $value;
            echo json_encode(array("status"=>"success","message"=>"User session activated successfully!"));
            }else{
               echo json_encode(array("status"=>"faild","message"=>"Invalid OTP")); 
            }
            
        } else {
            echo "No session value provided";
        }
    }elseif(isset($_POST['method']) && ($_POST['method'] == "unsetSession")){

        if (isset($_POST['method'])) {
                session_unset();
            echo "Session value set successfully";
        } else {
            echo "No session value provided";
        }

    }elseif (isset($_POST['method']) && ($_POST['method'] == "sendOtp")) {

        $otp = rand(100000,999999);
        $mobile = $_POST['phoneNo'];
        $result = sendOTP($mobile,$otp);
        echo json_encode($result);
    }
} else {
    echo "Invalid request method";
}
