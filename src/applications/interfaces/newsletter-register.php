<?php
require_once("../../properties/index.php");

$nl = new Accounts();
$username = get_request("username");
$id_account = $nl->getIdAccountByEmailOrUsername($username);

if ($id_account === 0) {
    $id_account = $newsletter_register = $nl->register($username);
}


if ($id_account > 0) {
    $url->setCustomUrl(SERVER_ADDRESS . "cadastro/concluir");
    $url->removeQueryString(array("u"));

    if(not_empty($next)) {
        $arrays = array(
            "u" => $text->base64_encode($id_account),
            "next" => $next
        );
    }else{
        $arrays = array(
            "u" => $text->base64_encode($id_account),
            "nx" => "fw_" . date("dmYhis")
        );
    }
    header("Location: " . $url->addQueryString($arrays));
    die;
}else{
    header("Location: " . $_SERVER['HTTP_REFERER']);
    die;
}
