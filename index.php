<?php include 'header.php';?>

<?php 
    $err_str = (empty($_GET['err']) ? '' : $_GET['err']);
?>
<div class="main">
    <form action="main.php" name="loginForm" method="post" onsubmit="event.preventDefault()">                
        <div class="login">
            <h2>Log in</h2>
            <div>
                <label>Email Address</label>
                <input type="text" id="email" value="" name="email" placeholder="test@example.com">
            </div>
            <div>
                <label>Password</label>
                <input type="password" id="password" value="" name="password" placeholder="password">
            </div>                    
            <div class="error"><p><?php echo $err_str; ?></p></div>
            <div class="login-bottom">                        
                <input type="submit" value="Log In" onclick="javascript:onLogin()">       
                <input type="submit" value="Sign Up" onclick="javascript:onSignup()">
            </div>
        </div>      
    </form>     
</div>

<?php include 'footer.php';?>
        