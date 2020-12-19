<?php include 'database.php';?>

<?php        
    $paraMode = (empty($_GET['paraMode']) ? '' : $_GET['paraMode']);
    $paraStr = (empty($_GET['paraStr']) ? '' : $_GET['paraStr']);
   
    $dbConnect = new DBManger();
    switch ($paraMode) {
        case "signup":
            $resultStr = $dbConnect->signup($paraStr);
            echo $resultStr;
            break;
        case "getUserList":
            $resultStr = $dbConnect->getUserList($paraStr);
            echo $resultStr;
            break;
        case "logout":
            $resultStr = $dbConnect->logout($paraStr);
            echo $resultStr;
            break;
        default:
            echo "paraMode is not defined.";
            break;
    }
    
?>