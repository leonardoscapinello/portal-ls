<?php
$postback_sample = $_REQUEST;
$transaction = new Transaction($postback_sample);
$transaction->setSource("hotmart");
$transaction->setStatusInternal("payment_approved");
$success = $transaction->insert();

if(!$success){
    header('HTTP/1.0 500 Internal Server Error');
    die;
}