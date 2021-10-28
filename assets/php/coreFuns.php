<?php
session_start();
	// Sanitize
	function clean($str)
    {
        return preg_replace('/[^\.\@\,\-\_A-Za-z0-9 ]/', '', $str);
    }

    // Send 4 digit OTP to a number
    function sendOTP($number, $otp)
    {
        $url = "https://www.fast2sms.com/dev/bulkV2?authorization=pfi0vJA5asH4QrFtbx2y8MZWkd3nRqKlNCBXeoDgczIYGTjOLw3MKAvON7ZuPR8L2kFsSJrfqIE4ndGB&route=v3&sender_id=TXTIND&language=english&flash=0";

        $msg = "Your OTP for EM is: ".$otp;

        $url = $url."&numbers=".$number."&message=".urlencode($msg);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $res = curl_exec($curl);
        $response = json_decode($res, true);
        if ($response['return'] == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    // Display alert
    function alertUser($msg)
    {
    	echo "<div class='alert alert-danger'>".$msg."</div>";
    }

    function getCurrentMonth()
    {
    	return date('m');
    }

    // Get month by date string
    function getMonthByFullDate($date)
    {
        $arr = explode('-', $date);
        return $arr[1];
    }

    // Get year by date string
    function getYearByFullDate($date)
    {
        $arr = explode('-', $date);
        return $arr[0];
    }


?>