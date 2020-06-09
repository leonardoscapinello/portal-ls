<?php
$scheduler = new SchedulerTransactions();
$serials = $scheduler->execute();
$data = array(
    "submit_key" => $auth,
    "status" => 200,
    "transactions" => $serials
);
header('Content-Type: application/json');
echo json_encode($data);
