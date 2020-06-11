<?php

define("DIRNAME", dirname(__FILE__) . "/");

require '../../src/class/Text.php';
require '../../src/class/BrowserDetection.php';
require '../../src/class/Images.php';
require '../../src/functions/get_request.php';
require '../../src/functions/notempty.php';
require '../../src/vendor/autoload.php';

$images = new Images();
$src = get_request("src", true);
$width = get_request("width");
$user_agent = $_SERVER['HTTP_USER_AGENT'];
if (!notempty($src)) die;

$source = __DIR__ . "/" . $src;

if (file_exists($source) && is_file($source)) {

    $browser = new BrowserDetection();

    if ("Safari" !== $browser->getName() && "Internet Explorer" !== $browser->getName()) {
        $images->load($source);
        if (notempty($width)) $images->resizeToWidth($width);
        $images->header(IMAGETYPE_WEBP);
        $images->output(IMAGETYPE_WEBP);
    } else {
        $images->load($source);
        if (notempty($width)) $images->resizeToWidth($width);
        $images->header();
        $images->output();
    }


}
