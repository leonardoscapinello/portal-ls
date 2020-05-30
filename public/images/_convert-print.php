<?php


require '../../src/class/Text.php';
require '../../src/functions/get_request.php';
require '../../src/functions/notempty.php';
require '../../src/vendor/autoload.php';

use WebPConvert\WebPConvert;

$src = get_request("src", true);

if (!notempty($src)) die;

$source = __DIR__ . "/" . $src;
$destination = __DIR__ . "/webp/" . $src . '.webp';

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