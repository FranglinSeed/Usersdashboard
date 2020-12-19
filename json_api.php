<?php
    $database_path = "database.json";
    $paraMode = (empty($_GET['paraMode']) ? '' : $_GET['paraMode']);
    $paraStr = (empty($_GET['paraStr']) ? '' : $_GET['paraStr']);
    if($paraMode == "signup") {
        if( !empty($paraStr) ) {
            file_put_contents($database_path, $paraStr);
            echo true;
        }
        echo false;
    }

    if($paraMode == "getOnlineUser") {
        $state = "online";
        $resultStr = "";   
        $fileterArray = array();
        $jsonString = file_get_contents($database_path);
        $data = json_decode($jsonString, true);
        foreach ($data as $key => $entry) {
            if ($entry['state'] == $state) {
                array_push($fileterArray, $entry);
            }
        }
        echo json_encode($fileterArray);
    }

    if($paraMode == "logout") {
        $state = "offline";
        $lastUpdateTime = date("Y-m-d H:i:s");    
        $jsonString = file_get_contents($database_path);
        $data = json_decode($jsonString, true);
        foreach ($data as $key => $entry) {
            if ($entry['email'] == $paraStr) {
                $data[$key]['last_time'] = $lastUpdateTime;
                $data[$key]['state'] = $state;
            }
        }
        $newJsonString = json_encode($data);
        file_put_contents($database_path, $newJsonString);
        echo true;
    }
    
?>