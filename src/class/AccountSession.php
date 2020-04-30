<?php

class AccountSession
{

    private $id_session;
    private $id_account;
    private $session_token;
    private $insert_time;
    private $is_active;

    private $username;
    private $password;

    private $cookie_name = "LS_MEMBER";

    public function __construct()
    {
        $database = new Database();
        $text = new Text();
        $cookie = $this->getCookie($this->cookie_name);
        if ($cookie !== null) {
            $database->query("SELECT id_session, id_account, session_token, insert_time, is_active FROM accounts_sessions WHERE session_token = ? AND is_active = 'Y'");
            $database->bind(1, $cookie);
            $result = $database->resultsetObject();
            if ($result && count(get_object_vars($result)) > 0) {
                foreach ($result as $key => $value) {
                    $this->$key = $text->utf8($value);
                }
            }
        }
    }

    private function getCookie($index)
    {
        try {
            if (isset($_COOKIE[$index])) {
                if ($_COOKIE[$index] !== null && $_COOKIE[$index] !== "") {
                    return $_COOKIE[$index];
                }
            }
        } catch (Exception $exception) {
            error_log("getCookie: " . $exception);
        }
        return null;
    }


    private function storeSessionCookie($id_account)
    {
        global $database;
        if (not_empty($id_account)) {

            $database = new Database();
            $token = new Token();
            $session_token = $token::v4();

            $database->query("INSERT INTO accounts_sessions (id_account, session_token) VALUES (?,?)");
            $database->bind(1, $id_account);
            $database->bind(2, $session_token);
            $database->execute();
            $last = $database->lastInsertId();
            if ($last > 0) {
                return $this->createSessionCookie($session_token);
            }
        }
        return false;
    }

    private function createSessionCookie($session_token)
    {
        $cookie_name = $this->cookie_name;
        if (isset($_COOKIE[$cookie_name])) {
            $this->cleanSession();
        }
        return setcookie($cookie_name, $session_token, time() + (86400 * 30), "/");
    }


    public function getIdSession()
    {
        return $this->id_session;
    }

    public function getIdAccount()
    {
        return $this->id_account;
    }

    public function getSessionToken()
    {
        return $this->session_token;
    }

    public function getInsertTime()
    {
        return $this->insert_time;
    }


    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getIsActive()
    {
        return $this->is_active;
    }


    public function createSession()
    {
        $database = new Database();
        $security = new Security();
        if (not_empty($this->username) && not_empty($this->password)) {
            $database->query("SELECT id_account, password FROM accounts WHERE username = ? OR email = ?");
            $database->bind(1, $this->username);
            $database->bind(2, $this->username);
            $resultset = $database->resultset();
            if (count($resultset) > 0) {
                $security->setIdAccount($resultset[0]['id_account']);
                $db_password = $security->decrypt($resultset[0]['password']);
                $post_password = $security->hash($this->password, false);


                if ($db_password === $post_password) return $this->storeSessionCookie($resultset[0]['id_account']);


            }
        }
        return false;
    }

    public function isLogged($cleanSessionWhenNotLogged = false)
    {
        if ($this->is_active === "Y") return true;
        if ($cleanSessionWhenNotLogged) $this->cleanSession();
        return false;
    }


    public function cleanSession()
    {
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                if ($name === $this->cookie_name) {
                    setcookie($name, '', time() - 1000);
                    setcookie($name, '', time() - 1000, '/');
                    unset($name);
                }
            }
        }
    }


    public function logoutFromAllSessions($id_account)
    {
        try {
            $database = new Database();
            $database->query("UPDATE accounts_sessions SET is_active = 'N' WHERE id_account = ?");
            $database->bind(1, $id_account);
            $database->execute();
        } catch (Exception $exception) {
            error_log($exception);
        }
    }


}
