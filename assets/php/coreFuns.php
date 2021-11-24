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

    // Verify Old password
    function verifyOldPw($userId, $oldPw)
    {
        global $db;
        $pw = md5($oldPw);
        $sql = "SELECT * FROM `_users` WHERE `user_id` = '$userId' AND `pin` = '$pw'";
        $res = $db->query($sql);
        if ($res->fetchArray()) {
            return true;
        }
        else {
            return false;
        }
    }

    // Set new password
    function setNewPassword($userId, $pw)
    {
        global $db;
        $pw = md5($pw);
        $sql = "UPDATE `_users` SET `pin` = '$pw' WHERE `user_id` = '$userId'";
        $res = $db->exec($sql);
        if ($res) {
            return true;
        }
        else {
            return false;
        }
    }

?>