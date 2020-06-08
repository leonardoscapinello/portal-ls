<?php
$scheduler = new Scheduler();
$serials = $scheduler->execute();
$data = array(
    "submit_key" => $auth,
    "status" => 200,
    "notifications" => $serials
);
header('Content-Type: application/json');
echo json_encode($data);
