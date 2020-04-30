<?php
if (!function_exists('notempty')){
    include("../../../properties/index.php");
}
if (!$session->isLogged()) {
    header("location: " . LOGIN_URL . "?next=" . $text->base64_encode($url->getActualURL()));
    die;
}
?>
