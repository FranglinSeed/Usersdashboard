<?php 

class DBManger {
    // Properties
    private $database_path;
    private $handle;

    function __construct() {
        $this->database_path = "database.json";
        $this->handle = fopen($this->database_path, "a+");  
    }

    function loginDB($email, $password) {
        $errStr = "";
        $hasUser = false;
        $state = "online";
        
        $jsonString = file_get_contents($this->database_path);
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
        $loginTime = date("Y-m-d H:i:s");    
        $lastUpdateTime = date("Y-m-d H:i:s");    
        $ipAddress = $_SERVER['REMOTE_ADDR'];
        $state = "online";
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $errStr = "";   
        $jsonString = file_get_contents($this->database_path);
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
        file_put_contents($this->database_path, $newJsonString);
    }

    function getUserList($paraStr) {
        $resultStr = "";   
        $fileterArray = array();
        $jsonString = file_get_contents($this->database_path);
        $data = json_decode($jsonString, true);
        foreach ($data as $key => $entry) {
            if($paraStr == "all") {
                array_push($fileterArray, $entry);
            } else {                
                if ($entry['state'] == $paraStr) {
                    array_push($fileterArray, $entry);
                }
            }
        }
        return json_encode($fileterArray);
    }

    function logout($paraStr) {
        $state = "offline";
        $lastUpdateTime = date("Y-m-d H:i:s");    
        $jsonString = file_get_contents($this->database_path);
        $data = json_decode($jsonString, true);
        foreach ($data as $key => $entry) {
            if ($entry['email'] == $paraStr) {
                $data[$key]['last_time'] = $lastUpdateTime;
                $data[$key]['state'] = $state;
            }
        }
        $newJsonString = json_encode($data);
        file_put_contents($this->database_path, $newJsonString);
        return true;
    }

    function signup($paraStr) {
        if( !empty($paraStr) ) {
            file_put_contents($this->database_path, $paraStr);
            return true;
        }
        return false;
    }
  }
?>