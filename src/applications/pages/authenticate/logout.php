<?php
if ($session->isLogged()) {
    $session->cleanSession();
    header("location: " . SERVER_ADDRESS);
    die;
}

?>