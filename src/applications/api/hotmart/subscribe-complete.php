<?php
$postback_sample = $_REQUEST;


$hotmart = new Hotmart($postback_sample);
$hotmart->purchase();
file_put_contents("request.txt", print_r($postback_sample, true));
