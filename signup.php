<?php include 'header.php';?>

<?php include 'database.php';?>

<div class="main">
    <form action="" method="post" name="signupForm" onsubmit="event.preventDefault()">                
        <div class="login">
            <h2>Sign Up</h2>
            <div>
                <label>Email Address</label>
                <input type="text" id="email" value="" name="email" placeholder="test@example.com">
            </div>            
            <div>
                <label>Name</label>
                <input type="text" id="name" value="" name="name" placeholder="name">
            </div>    
            <div>
                <label>Role</label>
                <input type="text" id="role" value="admin" name="role" placeholder="role">
            </div>                
            <div>
                <label>Password</label>
                <input type="password" id="password" value="" name="password" placeholder="password">
            </div>                    
            <div style="display:none;">
                <input type="hidden" id="ipAddress" value="<?php echo $_SERVER['REMOTE_ADDR'] ?>" >
                <input type="hidden" id="userAgent" value="<?php echo $_SERVER['HTTP_USER_AGENT'] ?>" >
            </div>
            <div class="error"><p id="errStr"></p></div>
            <div class="login-bottom">                        
                <input type="submit" value="Sign Up" onclick="javascript:onSignupUser()">
                <input type="submit" value="Back" onclick="javascript:onBack()">
            </div>
        </div> 
    </form>     
</div>


<?php include 'footer.php';?>
        