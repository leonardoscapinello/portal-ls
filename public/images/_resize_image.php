<?php

require '../../src/class/Text.php';
require '../../src/functions/get_request.php';
require '../../src/functions/notempty.php';
$source = get_request("src");
$width = get_request("wight");
$height = get_request("height");

function resize($originalFile, $newWidth)
{

    $info = getimagesize($originalFile);
    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image_create_func = 'imagecreatefromjpeg';
            $image_save_func = 'imagejpeg';
            $new_image_ext = 'jpeg';
            break;

        case 'image/png':
            $image_create_func = 'imagecreatefrompng';
            $image_save_func = 'imagepng';
            $new_image_ext = 'png';
            break;

        case 'image/gif':
            $image_create_func = 'imagecreatefromgif';
            $image_save_func = 'imagegif';
            $new_image_ext = 'gif';
            break;

        default:
            throw new Exception('Unknown image type.');
    }

    $img = $image_create_func($originalFile);
    list($width, $height) = getimagesize($originalFile);
    $newHeight = ($height / $width) * $newWidth;


    $width = intval($width);
    $height = intval($height);
    $newWidth = intval($newWidth);
    $newHeight = intval($newHeight);





    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    header('Content-Type: image/' . $new_image_ext);
    $image_save_func($tmp, null);
    imagedestroy($tmp);


}

if (file_exists($source)) {
    return resize($source, $width, $height);
}