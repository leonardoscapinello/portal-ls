<?php


class AccountsExternalSync
{

    private $id_account;

    public function __construct()
    {
        try {
            $database = new Database();
            $database->query("SELECT id_account FROM accounts WHERE is_active = 'Y' AND is_sync = 'N'");
            $result = $database->resultset();
            for ($i = 0; $i < count($result); $i++) {
                $this->id_account = $result[$i]['id_account'];
                $this->sync();
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    private function sync()
    {
        try {

            $account = new Accounts($this->id_account);

            $mailChimp = new Accounts_MailChimp(
                $account->getEmail(),
                $account->getFirstName(),
                $account->getLastName(),
                $account->getPhoneNumber()
            );
            $activeCampaign = new Accounts_ActiveCampaign(
                $account->getEmail(),
                $account->getFirstName(),
                $account->getLastName(),
                $account->getPhoneNumber()
            );
            if ($mailChimp && $activeCampaign) {
                $this->processed();
            }

        } catch (Exception $exception) {
            error_log($exception);
        }
    }


    public function processed()
    {
        try {
            $database = new Database();
            $database->query("UPDATE accounts SET is_sync = 'Y', sync_date = CURRENT_TIMESTAMP WHERE id_account = ?");
            $database->bind(1, $this->id_account);
            $database->execute();
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

}