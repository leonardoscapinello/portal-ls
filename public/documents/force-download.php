<?php
require_once("../../src/properties/index.php");

$allow = true;


// EXTERNAL DOWNLOAD
if (get_request("f") !== null) {

    $file = $text->base64_decode(get_request("f"));

    header("location: " . $file);

// INTERNAL DOWNLOAD
} elseif (get_request("hash")) {

    $id_account = get_request("id_account");
    $hash = get_request("hash");


    $contentsPrint = new ContentsPrint();
    $contents = new Contents();
    $contents->loadByHash($hash);
    $account = new Accounts($id_account);

    $composite = $account->getFullName() . $account->getIdAccount() . "-" . $contents->getTitle();
    $filename = $url->friendly($composite);


    if (true || !$contentsPrint->PDFExists($filename)) {
        $contentsPrint->render($hash, $id_account, $filename);
    }

    $just_filename = $filename;
    $filename = DIRNAME . "../../public/documents/" . $filename . ".pdf";

    if ($contentsPrint->PDFExists($just_filename)) {
        if ($allow) {
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
}