<?php
$first_name = get_request("first_name");
$last_name = get_request("last_name");
$email_address = get_request("email");
$phone = get_request("phone");

if (notempty($first_name) && notempty($last_name) && notempty($email_address) && notempty($phone)) {
    $reg = $account->register($email_address, $first_name, $last_name);
    if ($reg <= 0) {
        header("location: ../sua-empresa-online?error=Y");
        die;
    } else {

        $file_path = dirname(__FILE__) . "/coupons.txt";
        $lines_array = file($file_path);
        print_r($lines_array);
        if (count($lines_array) > 0) {
            $value = $lines_array[0];
            if ($value <= 0){
                header("location: ../sua-empresa-online?expired=Y");
                die;
            }

            if ($value <= 0) $value = 1;
            $file_handle = fopen($file_path, 'w');
            fwrite($file_handle, ($value - 1));
            fclose($file_handle);

            header("location: https://pay.hotmart.com/A36314150I?off=88s5kh6m&checkoutMode=10");
            die;

        }




    }
} else {
    header("location: ../sua-empresa-online");
    die;
}
