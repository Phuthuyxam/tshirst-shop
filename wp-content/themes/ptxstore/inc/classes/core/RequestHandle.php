<?php


class RequestHandle
{
    public static function get($key, $value = false) {
        return (!empty($_GET[$key])) ? $_GET[$key] : $value;
    }

    public static function post($key, $value = false) {
        return (!empty($_POST[$key])) ? $_POST[$key] : $value;
    }

    public static function cookie($key, $value = false) {
        return (!empty($_COOKIE[$key])) ? $_COOKIE[$key] : $value;
    }
}