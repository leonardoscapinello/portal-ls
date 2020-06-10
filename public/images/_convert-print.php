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
            'fail' => 'original',
            'fail-when-fail-fails' => 'throw',
            //'reconvert' => false,         // if true, existing (cached) image will be discarded
            //'serve-original' => false,    // if true, the original image will be served rather than the converted
            //'show-report' => false,       // if true, a report will be output rather than the raw image
            'serve-image' => [
                'headers' => [
                    'cache-control' => true,
                    'content-length' => true,
                    'content-type' => true,
                    'expires' => false,
                    'last-modified' => true,
                    'vary-accept' => false
                ],
                'cache-control-header' => 'public, max-age=31536000',
            ],
            'redirect-to-self-instead-of-serving' => false,
            'convert' => [
                'quality' => 'auto',
            ],
        ]);
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
}