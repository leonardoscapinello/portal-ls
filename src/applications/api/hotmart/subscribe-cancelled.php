<?php
$postback_sample = $_REQUEST;
$transaction = new Transaction($postback_sample);
$transaction->setSource("hotmart");
$transaction->setStatusInternal("order_cancelled");
$transaction->insert();
