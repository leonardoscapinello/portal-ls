<?php
$postback_sample = $_REQUEST;
$hotmart = new Hotmart($postback_sample);
file_put_contents("request.txt", print_r($_REQUEST, true));
$hotmart->purchase();
