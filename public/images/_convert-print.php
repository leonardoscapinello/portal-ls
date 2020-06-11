<?php
header('Pragma: public');
header('Cache-Control: max-age=86400');
header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));

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


    $browser_allowed = ($browser->getName() === "Chrome" || $browser->getName() === "Firefox" || $browser->getName() === "Opera");
    $is_mobile = $browser->isMobile();


    list($nwidth, $nheight) = getimagesize($source);

    if (!notempty($width)) {
        $width = $nwidth;
    }

    $name = pathinfo($source);
    $converted_filename = $name['filename'] . "-" . $width . "-" . md5($name['dirname']) . "." . $name['extension'];
    $converted_filename_path = __DIR__ . "/_converted/" . $converted_filename;


    if (!file_exists($converted_filename_path) || !is_file($converted_filename_path)) {
        $images->load($source);
        $images->resizeToWidth($width);
        $images->save($converted_filename);
    }
    if (file_exists($converted_filename_path) && is_file($converted_filename_path)) {

        $images->load($converted_filename_path);
        $images->header();
        if (!$browser_allowed || $is_mobile) {
            $images->output();
        } else {
            $images->output(IMAGETYPE_WEBP);
        }
    }


}
