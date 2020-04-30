<?php

class AccountsLicense
{

    private $id_license = 1;
    private $is_premium;
    private $license_name;
    private $insert_time;

    public function __construct()
    {
        global $text;
        global $account;
        $database = new Database();
        $session = new AccountSession();

        if ($session->isLogged()) {

            $id_license = $account->getIdLicense();

            $database->query("SELECT * FROM licenses WHERE id_license = ?");
            $database->bind(1, $id_license);
            $result = $database->resultsetObject();
            if ($result && count(get_object_vars($result)) > 0) {
                foreach ($result as $key => $value) {
                    $this->$key = $text->utf8($value);
                }
            }
        }
    }


    public function isPremium()
    {
        return $this->is_premium === "Y" ? true : false;
    }


    public function userCanAccessAllBooks()
    {
        return $this->getPermissionData("ACCESS_DIGITAL_BOOKS")[1];
    }

    public function getPermissionData($key)
    {
        global $text;
        $database = new Database();
        $session = new AccountSession();
        if ($session->isLogged()) {
            $database->query("SELECT permission_key, permission_value FROM licenses_permission WHERE id_license = ? AND permission_key = ?");
            $database->bind(1, $this->id_license);
            $database->bind(2, $key);
            $result = $database->resultset();
            if ($result && count($result) > 0) {
                $key = $result[0]['permission_key'];
                $value = $result[0]['permission_value'];
                if ($value === "Y") $value = true;
                if ($value === "N") $value = false;
                return array($key, $value);
            }
        }
        return array($key, false);
    }

    public function userCanAccessByPrivateLevel($private_level)
    {
        if ($private_level === "1") return true;
        $database = new Database();
        $session = new AccountSession();
        if ($session->isLogged()) {
            $database->query("SELECT permission_key FROM licenses_permission WHERE id_license = ? AND permission_key = ? AND permission_value = ?");
            $database->bind(1, $this->id_license);
            $database->bind(2, "CONTENT_PRIVATE_LEVEL");
            $database->bind(3, $private_level);
            $result = $database->resultset();
            if ($result && count($result) > 0) {
                return true;
            }
        }
        return false;
    }


}