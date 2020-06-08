<?php
$postback_sample = $_REQUEST;
$hotmart = new Hotmart($postback_sample);
$hotmart->cancelledPurchase();