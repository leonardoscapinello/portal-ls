<?php


class Accounts
{

    private $id_account;
    private $id_license;
    private $username;
    private $email;
    private $password;
    private $first_name;
    private $last_name;
    private $document;
    private $phone_number;
    private $insert_time;
    private $is_active;
    private $is_premium;

    private $is_active_default = "N";
    private $is_customer = "N";
    private $user_exists = false;
    private $register_notifications = true;

    public function __construct($id_account = 0)
    {

        global $text;
        $database = new Database();
        $session = new AccountSession();
        $numeric = new Numeric();
        if (!$id_account || intval($id_account) === 0) $id_account = $session->getIdAccount();
        if (not_empty($id_account) && $numeric->is_number($id_account)) {
            $database->query("SELECT * FROM accounts ac LEFT JOIN licenses li ON li.id_license = ac.id_license WHERE id_account = ?");
            $database->bind(1, $id_account);
            $result = $database->resultsetObject();
            if ($result && count(get_object_vars($result)) > 0) {
                foreach ($result as $key => $value) {
                    $this->$key = $text->utf8($value);
                }
                $this->user_exists = true;
            }
        }
    }

    public function resetPassword($new, $confirm_new, $notify = true)
    {
        global $session;
        try {
            $email = new EmailNotification();
            $security = new Security();
            $db_a = new Database();
            $numeric = new Numeric();
            if (strlen($new) > 5 && strlen($confirm_new) > 5) {
                if ($new === $confirm_new) {
                    if (notempty($this->getIdAccount())) {
                        if ($numeric->isIdentity($this->getIdAccount())) {
                            $security->setIdAccount($this->getIdAccount());
                            $pw = $security->hash($confirm_new, false);
                            $pw = $security->encrypt($pw);
                            $db_a->query("UPDATE accounts SET password = ?, is_active = 'Y' WHERE id_account = ?");
                            $db_a->bind(1, $pw);
                            $db_a->bind(2, $this->getIdAccount());
                            $db_a->execute();

                            if ($notify) {
                                $email->subject("Foi você? Sua senha foi alterada recentemente.");
                                $email->contact($this->getFirstName(), $this->getEmail());
                                $email->paragraph("Recentemente sua senha foi alterada dentro do portal LS, essa alteração foi feita por você mesmo?");
                                $email->paragraph("Caso você não tenha solicitado essa alteração, entre em contato com nosso suporte em suporte@flexwei.com para te ajudarmos com o caso e recuperar acesso a sua conta.");
                                $email->preheader("Se você alterou sua senha, descongele sua conta agora.");
                                $email->save();
                            }

                            $session->logoutFromAllSessions($this->getIdAccount());
                            return true;
                        }
                    }
                }
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }


    // $first_name, $last_name, $email_address, $password, $phone = null
    public function register($email_address, $first_name = null, $last_name = null, $password = null, $phone = null)
    {
        global $security;
        global $text;
        try {
            $email = new EmailNotification();
            $database = new Database();
            $phone = preg_replace("/[^0-9]/", "", $phone);
            if (strlen($email_address) < 6) return -1;
            $database->query("SELECT id_account, username, email FROM accounts WHERE username = ? OR email = ?");
            $database->bind(1, $email_address);
            $database->bind(2, $email_address);
            $r = $database->resultset();
            if (count($r) > 0) return $r[0]['id_account'];

            $database->query("INSERT INTO accounts (username, email, first_name, last_name, phone_number, is_active, id_license) VALUES (?,?,?,?,?,?,1)");
            $database->bind(1, $email_address);
            $database->bind(2, $email_address);
            $database->bind(3, $first_name);
            $database->bind(4, $last_name);
            $database->bind(5, $phone);
            $database->bind(6, $this->is_active_default);
            $database->execute();
            $id = $database->lastInsertId();

            if ($this->register_notifications) {
                if (not_empty($password)) {
                    $tmp_account = new Accounts($id);
                    $tmp_account->resetPassword($password, $password, false);
                    $email->subject("Quero te dar as boas-vindas pessoalmente.");
                    $email->contact($first_name, $email_address);
                    $email->paragraph("Olá, Leonardo aqui.");
                    $email->paragraph("Quero te dar as boas-vindas ao portal <b>LS</b> e te dizer que a partir de agora você tem um forte aliado em busca da sua excelencia no mercado digital.");
                    $email->paragraph("Quero aproveitar a oportunidade para te lembrar: <b>Publicamos conteúdo novo toda semana</b> para que você tenha sempre em mãos, informação de qualidade e relevante para melhorar seu desempenho no mercado digital.");
                    $email->paragraph("Preparamos tudo para que você possa acessar de forma simples e rápida, sem enrolação e dificuldade.");
                    $email->button("Fazer Login", LOGIN_URL . "?u=" . base64_encode($id));
                    $email->paragraph("Nos vemos no Portal LS!");
                    $email->save();
                } else {
                    $email->subject("Quero te dar as boas-vindas pessoalmente.");
                    $email->contact($first_name, $email_address);
                    $email->paragraph("Olá, Leonardo aqui.");
                    $email->paragraph("Quero te dar as boas-vindas ao portal <b>LS</b>.");
                    $email->paragraph("Pelo que vi aqui, ainda está faltando <b>algumas informações para você finalizar seu cadastro.</b> Mas fique tranquilo, são informações básicas e em menos de 2 minutos você já pode acessar sua conta.");
                    $email->button("Concluir meu cadastro.", LOGIN_URL . "?u=" . base64_encode($id));
                    $email->paragraph("Quero aproveitar a oportunidade para te lembrar: <b>Publicamos conteúdo novo toda semana</b> para que você tenha sempre em mãos, informação de qualidade e relevante para melhorar seu desempenho no mercado digital.");
                    $email->paragraph("Preparamos tudo para que você possa acessar de forma simples e rápida, sem enrolação e dificuldade.");
                    $email->paragraph("Nesse momento é muito importante que você conclua seu cadastro, combinado?");
                    $email->paragraph("Nos vemos no Portal LS!");
                    $email->save();
                }
            }
            return $id;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function update($id_account, $first_name, $last_name, $phone, $password, $username, $id_license = "id_license")
    {
        global $text;
        try {

            $this->storeSession();

            $database = new Database();
            $phone = preg_replace("/[^0-9]/", "", $phone);
            if (strlen($username) < 6) return -1;
            if (strlen($first_name) < 2) return -2;
            if (strlen($last_name) < 2) return -3;
            if (strlen($phone) < 6) return -4;
            $database->query("UPDATE accounts SET first_name = ?, last_name = ?, phone_number = ?, username = ?, email = ?, id_license = " . $id_license . " WHERE id_account = ?");
            $database->bind(1, $first_name);

            $database->bind(2, $last_name);
            $database->bind(3, $phone);
            $database->bind(4, $username);
            $database->bind(5, $username);
            $database->bind(6, $id_account);
            $database->execute();
            if (not_empty($id_account) && not_empty($password)) {
                $tmp_account = new Accounts($id_account);
                $tmp_account->resetPassword($password, $password);
            }


            return $id_account;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }


    public function getIdAccountByEmailOrUsername($email_address)
    {
        try {
            $database = new Database();
            $database->query("SELECT id_account FROM accounts WHERE username = ? OR email = ?");
            $database->bind(1, $email_address);
            $database->bind(2, $email_address);
            $r = $database->resultset();
            if ($r) return $r[0]['id_account'];
        } catch (Exception $exception) {
            error_log($exception);
        }
        return 0;
    }


    public function isCustomer()
    {
        if ($this->is_customer === "Y") return true;
        return false;
    }

    public function getIdAccount()
    {
        return $this->id_account;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getFullName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function getNameFirstLetter()
    {
        return substr($this->first_name, 0, 1);
    }

    public function getDocument()
    {
        return $this->document;
    }

    public function getMaskedDocument()
    {
        global $numeric;
        global $text;
        $document = $numeric->zeroFill($this->document, 11);
        $document = $text->mask($document, "###.###.###-##");
        return $document;
    }

    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    public function getMaskedPhoneNumber()
    {
        global $text;
        return $text->mask($this->getPhoneNumber(), "+## (##) #.####-####");
    }

    public function getInsertTime()
    {
        return $this->insert_time;
    }

    public function isActive()
    {
        return $this->is_active === "Y" ? true : false;
    }

    public function isPremium()
    {
        return $this->is_premium === "Y" ? true : false;
    }

    public function setIdAccount($id_account)
    {
        $this->id_account = $id_account;
    }

    /**
     * @return mixed
     */
    public function getIdLicense()
    {
        return $this->id_license;
    }

    /**
     * @return bool
     */
    public function userExists(): bool
    {
        return $this->user_exists;
    }

    public function registerNotification($bool)
    {
        $this->register_notifications = false;
    }


    public function storeSession()
    {
        global $text;
        $sess = array("email", "username", "first_name", "last_name", "phone");
        for ($i = 0; $i < count($sess); $i++) {
            $current = $sess[$i];
            $request = get_request($current, true);
            if ($request !== null) {
                setcookie($current, $text->base64_encode($request), time() + (86400 * 30), "/");
            }

        }
    }


}