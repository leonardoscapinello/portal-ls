<?php

class AccountsPreferences
{

    private $active_permissions = array();

    public function __construct($id_account = 0)
    {
        try {
            $database = new Database();
            $session = new AccountSession();
            $numeric = new Numeric();
            if (!$id_account || intval($id_account) === 0) $id_account = $session->getIdAccount();
            if (not_empty($id_account) && $numeric->is_number($id_account)) {
                $database->query("SELECT preference_key, preference_value FROM accounts_preferences WHERE id_account = ? AND (is_active = 'Y' AND delete_time IS NULL)");
                $database->bind(1, $id_account);
                $result = $database->resultset();
                if (count($result) > 0) {
                    for ($i = 0; $i < count($result); $i++) {
                        $item = array($result[$i]['preference_key'] => $result[$i]['preference_value']);
                        array_push($this->active_permissions, $item);
                    }
                }
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function updatePreferences(array $newPreferences = array())
    {
        global $account;
        try {
            $database = new Database();
            $database->query("UPDATE accounts_preferences SET is_active = 'N', delete_time = CURRENT_TIMESTAMP WHERE id_account = ?");
            $database->bind(1, $account->getIdAccount());
            $database->execute();
            if (count($newPreferences) > 0) {
                for ($i = 0; $i < count($newPreferences); $i++) {
                    $preference_key = str_replace("PREF_", "", $newPreferences[$i]);
                    $database->query("INSERT INTO accounts_preferences (id_account, preference_key, preference_value, is_active) VALUES (?,?,?,'Y')");
                    $database->bind(1, $account->getIdAccount());
                    $database->bind(2, $preference_key);
                    $database->bind(3, "Y");
                    $database->execute();
                }
            }
            return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function getActivePermissions()
    {
        return $this->active_permissions;
    }

    public function getPreferencesFieldsAttributes($key)
    {
        $array = $this->active_permissions;
        for ($i = 0; $i < count($array); $i++) {
            $key2look = str_replace("PREF_", "", $key);
            if (array_key_exists($key2look, $array[$i])) {
                return "name=\"" . $key . "\" id=\"" . $key . "\" checked=\"checked\"";
            }
        }
        return "name=\"" . $key . "\" id=\"" . $key . "\"";
    }

}