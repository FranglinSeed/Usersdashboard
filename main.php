<?php include 'header.php';?>
<?php include 'database.php';?>

<script language="javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        getUserList("online");
        setInterval(function(){ getUserList("online"); }, 3000);
    });
</script>

<?php
    $email = (empty($_POST['email']) ? '' : $_POST['email']);
    $password = (empty($_POST['password']) ? '' : $_POST['password']);

    if(empty($email) || empty($password)) {
        $queryPara = "err=Empy Input Error!!!";
        $url = "index.php?".$queryPara;
        header("HTTP/1.1 301 Moved Permanently"); 
        header("Location: $url");
    } else {
        $dbConnect = new DBManger();
        $errStr = $dbConnect->loginDB($email, $password);

        if(!empty($errStr)) {
            $queryPara = "err=".$errStr;
            $url = "index.php?".$queryPara;
            header("HTTP/1.1 301 Moved Permanently"); 
            header("Location: $url");    
        } else {
            $dbConnect->updateLoginInfo($email);            
        }
    }
?>

  
<div class="bannar">
    <h3>Welcome to Our web-site : <span><?php echo $email; ?></span></h3>
    <input type="submit" value="Log Out" onclick="javascript:onLogout('<?php echo $email; ?>');">        
</div>  
<div class="main">
    <form action="/" method="post" name="mainForm" onsubmit="event.preventDefault()">  
    <h2>Online User List</h2>
        <table style="width:100%">
            <thead>
                <th>Username</th>
                <th>Login time</th>
                <th>Last update time</th>
                <th>User IP</th>
            </thead>
            <tbody id="tb_onlineuserlist">
            </tbody>
        </table>
        <br/><br/>
        <input type="button" value="Show All Users" onclick="javascript:toggleUserShow();">
        <br/><br/>        
        <table style="width:100%; display:none;" id="table_userlist">
            <thead>
                <th>Username</th>
                <th>Email</th>
                <th>RegTime</th>
                <th>LastTime</th>
                <th>User IP</th>
                <th>STATE</th>
            </thead>
            <tbody id="tb_userlist">
            </tbody>
        </table>
    </form>     
</div>

<div class="dialog" id="detail_dialog" hidden>
    <div class="login">
        <h2 id="dlg_email">Sign Up</h2>
        <div>
            <label>User-Agent</label>
            <input type="text" id="dlg_agent" value="" disabled>
        </div>            
        <div>
            <label>RegTime</label>
            <input type="text" id="dlg_regtime" value="" disabled>
        </div>    
        <div>
            <label>LoginCount</label>
            <input type="text" id="dlg_logincnt" value="" disabled>
        </div>   
        <div class="login-bottom">                        
            <input type="submit" value="Close" onclick="javascript:dialogClose()">
        </div>
    </div> 
</div>
<?php include 'footer.php';?>
        