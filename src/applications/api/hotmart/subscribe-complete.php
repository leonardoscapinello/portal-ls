<?php
$post = $_POST;
$get = $_GET;

file_put_contents("request.txt", print_r($_REQUEST, true));