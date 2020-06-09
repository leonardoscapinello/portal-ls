<?php
$postback_sample = $_REQUEST;
$hotmart = new Hotmart($postback_sample);
$hotmart->cancelledPurchase();
file_put_contents("request2.txt", print_r($postback_sample, true));