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
    list($nwidth, $nheight) = getimagesize($source);

    if (!notempty($width)) {
        $width = $nwidth;
    }


    if ("Chrome" !== $browser->getName() || "Firefox" === $browser->getName()) {
        $images->load($source);
        $images->resizeToWidth($width);
        $images->header(IMAGETYPE_WEBP);
        $images->output(IMAGETYPE_WEBP);
    } else {
        $images->load($source);
        //* NEEDED BECAUSE PNG RESIZE PUT BLACK BACKGROUND ON TRANSPARENT IMAGE
        if ($images->image_type !== IMAGETYPE_PNG) {
            $images->resizeToWidth($width);
            $images->header();
            $images->output();
        } else {
            $images->header();
            echo file_get_contents($source);
        }
    }


}
