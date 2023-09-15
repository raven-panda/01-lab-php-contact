<?php
    session_start();
    function check_session_state() {
        if (isset($_SESSION['token']) && !empty($_SESSION['token']) && isset($_SESSION['token_time']) && !empty($_SESSION['token_time']) && $_SESSION['token_time'] > time()) {
            return true;
        } else {
            return false;
        }
    }
    function check_remember_state() {
        if (isset($_COOKIE['token']) && !empty($_COOKIE['token'])) {
            return true;
        } else {
            return false;
        }
    }
?>