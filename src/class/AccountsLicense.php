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


    public function userCanAccessByKey($key)
    {
        $database = new Database();
        $session = new AccountSession();
        if ($session->isLogged()) {
            $database->query("SELECT permission_key, permission_value FROM licenses_permission WHERE id_license = ? AND permission_key = ?");
            $database->bind(1, $this->id_license);
            $database->bind(2, $key);
            $result = $database->resultset();
            if ($result && count($result) > 0) {
                $value = $result[0]['permission_value'];
                if ($value === "Y") $value = true;
                if ($value === "N") $value = false;
                return $value;
            }
        }
        return false;
    }


    public function setUserLicense($id_license, $id_account)
    {
        try {
            $database = new Database();
            $database->query("UPDATE accounts SET id_license = ? WHERE id_account = ?");
            $database->bind(1, $id_license);
            $database->bind(2, $id_account);
            $database->execute();
            return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function isPremium()
    {
        return $this->userCanAccessByKey("PREMIUM_PRIVILEGES") === "Y" ? true : false;
    }

    public function userCanAccessAllBooks()
    {
        return $this->userCanAccessByKey("PREMIUM_EBOOKS") === "Y" ? true : false;
    }


}