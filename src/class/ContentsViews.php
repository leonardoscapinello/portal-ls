<?php

class ContentsViews
{

    private $id_content_view;
    private $id_content;
    private $id_account;
    private $ip_address;
    private $browser;
    private $insert_time;

    public function add()
    {
        global $account;
        global $contents;
        try {

            $vdb = new Database();
            $browser = new BrowserDetection();

            $id_account = $account->getIdAccount();
            $id_content = $contents->getIdContent();
            $browser_name = $browser->getName();
            $browser_version = $browser->getVersion();
            $client_os = $browser->getPlatform();
            $client_os_version = $browser->getPlatformVersion(true);
            $client_os_vname = $browser->getPlatformVersion();
            $client_os_bits = $browser->is64bitPlatform() ? "x86" : "x64";
            $is_robot = $browser->isRobot() ? "Y" : "N";
            $ip_address = $this->get_user_ip_address();


            $vdb->query("INSERT INTO contents_views (id_content, id_account, ip_address, browser_name, browser_version, client_os, client_os_version, client_os_vname, client_os_bits, is_robot) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $vdb->bind(1, $id_content);
            $vdb->bind(2, $id_account);
            $vdb->bind(3, $ip_address);
            $vdb->bind(4, $browser_name);
            $vdb->bind(5, $browser_version);
            $vdb->bind(6, $client_os);
            $vdb->bind(7, $client_os_version);
            $vdb->bind(8, $client_os_vname);
            $vdb->bind(9, $client_os_bits);
            $vdb->bind(10, $is_robot);
            $vdb->execute();


        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function getViews()
    {
        global $contents;
        try {
            $vdb = new Database();
            $id_content = $contents->getIdContent();
            $vdb->query("SELECT COUNT(id_content_view) views FROM contents_views WHERE id_content = ?");
            $vdb->bind(1, $id_content);
            $result = $vdb->single();
            if (count($result) > 0) {
                return $result['views'];
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    private function get_user_ip_address($return_type = NULL)
    {
        $ip_addresses = array();
        $ip_elements = array(
            'HTTP_X_FORWARDED_FOR', 'HTTP_FORWARDED_FOR',
            'HTTP_X_FORWARDED', 'HTTP_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_CLUSTER_CLIENT_IP',
            'HTTP_X_CLIENT_IP', 'HTTP_CLIENT_IP',
            'REMOTE_ADDR'
        );


        foreach ($ip_elements as $element) {
            if (isset($_SERVER[$element])) {
                if (!is_string($_SERVER[$element])) {
                    // Log the value somehow, to improve the script!
                    continue;
                }
                $address_list = explode(',', $_SERVER[$element]);
                $address_list = array_map('trim', $address_list);
                // Not using array_merge in order to preserve order
                foreach ($address_list as $x) {
                    $ip_addresses[] = $x;
                }
            }
        }


        if (count($ip_addresses) == 0) {
            return FALSE;

        } elseif ($return_type === 'array') {
            return $ip_addresses;

        } elseif ($return_type === 'single' || $return_type === NULL) {
            return $ip_addresses[0];
        }

    }


}