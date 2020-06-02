<?php


require '../../src/class/Text.php';
require '../../src/functions/get_request.php';
require '../../src/functions/notempty.php';
require '../../src/vendor/autoload.php';

use WebPConvert\WebPConvert;

$src = get_request("src", true);
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if (!notempty($src)) die;

$source = __DIR__ . "/" . $src;
$destination = __DIR__ . "/webp/" . $src . '.webp';

if (stripos($user_agent, 'Safari') !== false) {

    if (file_exists($source)) {
        $size = getimagesize($source);
        $fp = fopen($source, 'rb');
        if ($size && $fp) {
            header('Content-Type: ' . $size['mime']);
            header('Content-Length: ' . filesize($source));
            fpassthru($fp);
            exit;
        }
    }

} else {

    try {
        WebPConvert::serveConverted($source, $destination, [
            'fail' => 'original',     // If failure, serve the original image (source). Other options include 'throw', '404' and 'report'
            //'show-report' => true,  // Generates a report instead of serving an image

            'serve-image' => [
                'headers' => [
                    'cache-control' => true,
                    'vary-accept' => true,
                ],
                'cache-control-header' => 'max-age=2',
            ],

            'convert' => [
                // all convert option can be entered here (ie "quality")
            ],
        ]);
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}