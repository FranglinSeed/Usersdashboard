<?php 

$database_path = "database.json";
$handle = fopen($database_path, "a+");

function loginDB($email, $password) {
    $database_path = "database.json";
    $errStr = "";
    $hasUser = false;
    $state = "online";
    
    $jsonString = file_get_contents($database_path);
    $data = json_decode($jsonString, true);
    foreach ($data as $key => $entry) {
        if ($entry['email'] == $email) {
            $hasUser = true;
            if ($entry['password'] != $password) {
                $errStr = "Password incorrect. Try again !";
            }
            if ($entry['state'] == $state) {
                // $errStr = "Already Logined. Enter the other UserInfo !";
            }
        }
    }
    if (!$hasUser) {    //sign up automatically or not?
        $errStr = "Unregesitered User. Please Sign up !";   
    }
    return $errStr;
}

function updateLoginInfo($email) {
    $database_path = "database.json";
    $loginTime = date("Y-m-d H:i:s");    
    $lastUpdateTime = date("Y-m-d H:i:s");    
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $state = "online";
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $errStr = "";   
    $jsonString = file_get_contents($database_path);
    $data = json_decode($jsonString, true);
    foreach ($data as $key => $entry) {
        if ($entry['email'] == $email) {
            $data[$key]['login_cnt'] = intval($data[$key]['login_cnt']) + 1;
            $data[$key]['login_time'] = $loginTime;
            $data[$key]['last_time'] = $lastUpdateTime;
            $data[$key]['ip'] = $ipAddress;
            $data[$key]['agent'] = $user_agent;
            $data[$key]['state'] = $state;
        }
    }
    $newJsonString = json_encode($data);
    file_put_contents($database_path, $newJsonString);
}

?>