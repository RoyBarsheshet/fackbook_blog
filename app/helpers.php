<?php

if (!function_exists('old')) {

    function old($field_name) {

        return isset($_REQUEST[$field_name]) ? $_REQUEST[$field_name] : '';
    }

}
if (!function_exists('csrf_token')) {

    function csrf_token() {

        $token = sha1(rand(1, 1000) . 'Roy_fakebook_blog' . date('Y.m.d.H.i.s'));
        $_SESSION['token'] = $token;
        return $token;
    }

}
if (!function_exists('verify_user')) {

    function verify_user() {

        $is_user = false;
        if (isset($_SESSION['user_ip']) && $_SESSION['user_ip'] == $_SERVER['REMOTE_ADDR']) {
            if (isset($_SESSION['user_agent']) && $_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT']) {
                if (isset($_SESSION['user_id'])) {
                    $is_user = true;
                }
            }
        }
        return $is_user;
    }

}

function email_exist($link, $email) {
    $exist = false;
    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);
    if ($result && mysqli_num_rows($result) == 1) {
        $exist = true;
    }
    return $exist;
}

password_hash('123456', PASSWORD_BCRYPT);
