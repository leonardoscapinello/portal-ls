<?php

class ExternalServiceList
{

    private $api_key = "aea22dac4a82736cca0a81ce8acca224-us10";
    private $list_id = "244ff91191";
    private $status = "subscribed";

    private $email;
    private $first_name;
    private $last_name;
    private $phone;

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }


    private function getDataCenterURL($member_id)
    {
        $data_center = substr($this->api_key, strpos($this->api_key, '-') + 1);
        return 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $this->list_id . '/members/' . $member_id;
    }

    public function subscribe()
    {
        try {

            $member_id = md5(strtolower($this->email));
            $data_url = $this->getDataCenterURL($member_id);

            $json = json_encode([
                'email_address' => $this->email,
                'status' => $this->status,
                'language' => "pt",
                'merge_fields' => [
                    'FNAME' => $this->first_name,
                    'LNAME' => $this->last_name,
                    'PHONE' => $this->phone
                ],


            ]);


            $ch = curl_init($data_url);
            curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $this->api_key);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return $httpCode;


        } catch (Exception $exception) {
            error_log($exception);
        }
    }

}