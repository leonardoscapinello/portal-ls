<?php

class Accounts_ActiveCampaign
{


    /* IMPORTANT NOTE
    *
     *  On the Connector.class.php, inside ActiveCampaign.class.php
     *  i needed update line 70, from
			$url .= "?api_key=" . $this->api_key;
     *  to
     *  	$url .= "&api_key=" . $this->api_key;
     *  because output format bug
     */
//
    //private $api_url = "https://leonardoscapinello.api-us1.com";
    //private $api_key = "dc3b631e0f592da070cd070e400f2c24259ee201ac502d35469a29c17e290722d269d58e";

    private $api_url = "https://lsgo.api-us1.com";
    private $api_key = "22e7697cdf6c8d98b8a51ffed96f66fd078ba7a3181dddab6c401ea9b1592539ddf51b09";

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
    }

    private function subscribe()
    {
        try {

            $ac = new ActiveCampaign($this->api_url, $this->api_key);
            $ac->output = "json";
            $ac->version(2);
            $list_id = 1;
            $contact = array(
                "email" => $this->email,
                "first_name" => $this->first_name,
                "last_name" => $this->last_name,
                "phone" => $this->phone,
                "p[{$list_id}]" => $list_id,
                "status[{$list_id}]" => 1,
            );
            $contact_sync = $ac->api("contact/sync", $contact);
            if ($contact_sync->http_code === 200) {
                return true;
            }

        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

}