<?php
function clean($data){
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function isEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function isPhone($phone){
    return preg_match('/^[0-9]{7,15}$/', $phone);
}

function isLoggedIn(){
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin(){
    if(!isLoggedIn()){
        header("Location: login.php");
        exit;
    }
}
?>
