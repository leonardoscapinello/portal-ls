<?php

class Accounts_MailChimp
{

    //  private $api_key = "aea22dac4a82736cca0a81ce8acca224-us10"; // LEONARDOSCAPINELLO OLD API KEY
    private $api_key = "2dcdd594c0d40c501708c3b5785b5ce4-us10";
    // private $list_id = "244ff91191"; // LEONARDOSCAPINELLO OLD API KEY
    private $list_id = "2ee977cab2";
    private $status = "subscribed";

    private $email;
    private $first_name;
    private $last_name;
    private $phone;

    public function __construct($email_address, $first_name, $last_name, $phone = null)
    {
        try {
            $this->email = $email_address;
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->phone = $phone;
            return $this->subscribe();
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    private function getDataCenterURL($member_id)
    {
        $data_center = substr($this->api_key, strpos($this->api_key, '-') + 1);
        return 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $this->list_id . '/members/' . $member_id;
    }


    private function subscribe()
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
            $result_json = json_decode($result);
            if (200 === $httpCode) {
                return true;
            }
            if (400 === $httpCode) {
                $this->inactiveByFake($result_json->detail);
                return "400-fake-detection";
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    private function inactiveByFake($detail)
    {
        try {
            $database = new Database();
            $database->query("UPDATE accounts SET is_active = 'N', sync_error = ? WHERE email = ?");
            $database->bind(1, $detail);
            $database->bind(2, $this->email);
            $database->execute();
            return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

}