<?php
require_once("../../properties/index.php");

$path = get_request("path");
$component = get_request("component");

$auth = get_request("oauth");

if ("13ea09f8-08af-4cb8-bfc9-a6c905d1b37c" !== $auth) {
    header('HTTP/1.0 403 Forbidden');
    die;
}

if (notempty($path) && notempty($component)) {
    $api = DIRNAME . "../applications/api/" . $path . "/" . $component . ".php";
    if (file_exists($api)) {
        require_once($api);
    } else {
        header('HTTP/1.0 404 Not Found');
        die;
    }
}