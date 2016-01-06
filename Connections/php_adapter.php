<?php
if (!function_exists("session_register")) {
    function session_register($name) {
        if (!isset($_SESSION[$name]) && isset($GLOBALS[$name])) {
            $_SESSION[$name] = $GLOBALS[$name];
        }
    }
}