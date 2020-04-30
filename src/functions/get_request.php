<?php

function get_request($index, $ignore_cookie = false)
{
    $tx = new Text();
    if (isset($_REQUEST[$index]) && $_REQUEST[$index] !== "") {
        if (strlen($_REQUEST[$index]) > 0) {
            return $_REQUEST[$index];
        }
    }
    if (!$ignore_cookie) {
        if (isset($_COOKIE[$index]) && $_COOKIE[$index] !== "") {
            if (strlen($_COOKIE[$index]) > 0) {
                return $tx->base64_decode($_COOKIE[$index]);
            }
        }
    }
    return null;

}

