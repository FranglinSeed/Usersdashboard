function onLogin() {
    localStorage.email = document.getElementById("email").value;
    loginForm.action = "main.php";
    loginForm.submit();
}

function onSignup() {
    loginForm.action = "signup.php";
    loginForm.submit();
}

function onBack() {
    signupForm.action = "index.php";
    signupForm.submit();
}

function onLogout(email) {
    if(email == "") email = localStorage.email;
    var paraStr = "paraMode=logout&paraStr=" + email;
    callJsonPhp(function(text){
        mainForm.action = "index.php";
        mainForm.submit();   
    },paraStr);    
}

function readTextFile(file, callback) {
    var rawFile = new XMLHttpRequest();
    rawFile.overrideMimeType("application/json");
    rawFile.open("GET", file, true);
    rawFile.onreadystatechange = function() {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            callback(rawFile.responseText);
        }
    }
    rawFile.send(null);
}

function callJsonPhp(callback, paraStr) {
    var r = new XMLHttpRequest();
    r.open("POST", "json_api.php?" + paraStr, true);
    r.onreadystatechange = function () {
        if (r.readyState === 4 && r.status == "200") {
            callback(r.responseText);
        }
    };
    r.send(null);
}
function isEmpty(str) {
    if(str==null || str == "" || str.length == 0) {
        return true
    }
    return false;
}

function AddZero(num) {
    return (num >= 0 && num < 10) ? "0" + num : num + "";
}
function onSignupUser() {
    const databasepath = "database.json";
    const email = document.getElementById('email').value;
    const name = document.getElementById('name').value;
    const role = document.getElementById('role').value;
    const pass = document.getElementById('password').value;
    const ip = document.getElementById('ipAddress').value;
    const agent = document.getElementById('userAgent').value;
    var temp = new Date();
    const curTime = [[AddZero(temp.getFullYear()),
        AddZero(temp.getMonth() + 1),
        temp.getFullYear()].join("-"), 
        [AddZero(temp.getHours()), 
        AddZero(temp.getMinutes()),
        AddZero(temp.getSeconds())].join(":")].join(" ");

    if(isEmpty(email) || isEmpty(name) || isEmpty(role) || isEmpty(pass)) {
        document.getElementById('errStr').innerHTML = "Input Error. Insert All Items.";
        return false;   
    }

    const newUser = {
        email: email,
        name:name,
        role:role,
        password:pass,
        reg_time:curTime,
        login_cnt:0,
        login_time:curTime,
        last_time:curTime,
        ip:ip,
        agent:agent,
        state:'offline'

    };

    var data = new Array;
    var hasSameUser = true;
    //usage:    
    document.getElementById('errStr').innerHTML = "";
    readTextFile(databasepath, function(text){
        if(text != "" && text != null) {
            data = JSON.parse(text);  
            for(let i = 0; i < data.length; i++) {
                item = data[i];
                hasSameUser = false;
                if(item['email'] == email) {
                    document.getElementById('errStr').innerHTML = "Same User exist. Insert correct UserInfo.";
                    hasSameUser = true;
                    break;
                }
            }
            // data.forEach(item => {
            //     hasSameUser = false;
            //     if(item['email'] == email) {
            //         document.getElementById('errStr').innerHTML = "Same User exist. Insert correct UserInfo.";
            //         hasSameUser = true;
            //         return false;
            //     }
            // });          
        }
        
        if(text == null || text == "" || hasSameUser == false) {
            data.push(newUser);        
            var result = JSON.stringify(data);
            var paraStr = "paraMode=signup&paraStr=" + result;
            callJsonPhp(function(text){
                if(text) {                
                    document.getElementById('errStr').innerHTML = "Sign up success.";
                } else {                
                    document.getElementById('errStr').innerHTML = "User Sign up error. Try again.";
                }
            },paraStr);
        }
    });       
}


function getOnlineUserList() {
    var data = new Array;
    var resultStr = '';
    var paraStr = "paraMode=getOnlineUser";
    callJsonPhp(function(text){
        if(text != "") {
            data = JSON.parse(text);  
            data.forEach(item => {
                resultStr += "<tr onclick=\"javascript:OnlineUserDetail(\'"+item['email']+"\',\'"+item['agent']+"\',\'"+item['reg_time']+"\',\'"+item['login_cnt']+"\')\">";
                resultStr += "<td>" + item['name'] + "</td>";
                resultStr += "<td>" + item['login_time'] + "</td>";
                resultStr += "<td>" + item['last_time'] + "</td>";
                resultStr += "<td>" + item['ip'] + "</td>";
                resultStr += "</tr>";
            });       
            document.getElementById("tb_onlineuserlist").innerHTML = resultStr;
        }
    },paraStr);
}

function OnlineUserDetail(email, agent, reg_time, login_cnt) {
    document.getElementById("dlg_email").innerHTML = email;
    document.getElementById("dlg_agent").value = agent;
    document.getElementById("dlg_regtime").value = reg_time;
    document.getElementById("dlg_logincnt").value = login_cnt;
    document.getElementById("detail_dialog").hidden = false;
}

function dialogClose() {
    document.getElementById("detail_dialog").hidden = true;
}