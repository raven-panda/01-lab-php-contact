<?php
    function check_session_state() {
        if (!isset($_SESSION['token']) || empty($_SESSION['token']) || !isset($_SESSION['token_time']) || empty($_SESSION['token_time']) || $_SESSION['token_time'] < time()) {
            return false;
        } else {
            return true;
        }
    }
?>