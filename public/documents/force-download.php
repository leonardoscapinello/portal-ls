<?php
ini_set('display_errors', 1);
require_once("../../src/properties/index.php");
$allow = true;

$f = get_request("f");
$hash = get_request("hash");


// EXTERNAL DOWNLOAD
if (notempty($f)) {

    $file = $text->base64_decode(get_request("f"));
    header("location: " . $file);

// INTERNAL DOWNLOAD
} elseif (notempty($hash)) {


    if (!$session->isLogged()) {
        header("location: " . LOGIN_URL . "?content_fire=download&next=" . $url->getActualURLAsNext());
    }

    $contentsPrint = new ContentsPrint();
    $contents = new Contents();
    $contents->loadByHash($hash);

    $composite = $account->getFullName() . $account->getIdAccount() . "-" . $contents->getTitle();
    $filename = $url->friendly($composite);


    if (true || !$contentsPrint->PDFExists($filename)) {
        echo $contentsPrint->render($hash, $account->getIdAccount(), $filename);
    }
    $just_filename = $filename;
    $filename = DIRNAME . "../../public/documents/" . $filename . ".pdf";
    if ($contentsPrint->PDFExists($just_filename) && $allow) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filename));
        // header("Content-Encoding: gzip");
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header("Content-Length: " . filesize($filename));
        header('Content-Transfer-Encoding: binary');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=1, pre-check=1');
        ob_get_clean();
        readfile($filename);
        exit;
    }
}
