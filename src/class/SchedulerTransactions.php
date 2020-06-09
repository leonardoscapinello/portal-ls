<?php

class SchedulerTransactions
{
    private $account_key = "XmLbUih3CrBbqyIUkd2ediGPSMuWTq10438961";
    private $id_transaction;
    private $transaction_serial;
    private $id_account;
    private $hottok;
    private $transaction;
    private $payment_type;
    private $payment_engine;
    private $status_external;
    private $status_internal;
    private $prod;
    private $price;
    private $full_price;
    private $email;
    private $name;
    private $first_name;
    private $last_name;
    private $phone_checkout_local_code;
    private $phone_checkout_number;
    private $insert_time;
    private $is_active;
    private $is_processed;
    private $processed_time;
    private $source;


    public function execute()
    {
        $transactions = array();
        try {
            $database = new Database();
            $database->query("SELECT id_transaction,transaction_serial, status_external, status_internal, email, first_name, last_name, phone_checkout_local_code, phone_checkout_number FROM transactions WHERE (is_processed = 'N' AND processed_time IS NULL) AND hottok = ?");
            $database->bind(1, $this->account_key);
            $result = $database->resultset();
            for ($i = 0; $i < count($result); $i++) {
                $this->id_transaction = $result[$i]['id_transaction'];
                $this->transaction_serial = $result[$i]['transaction_serial'];
                $this->status_external = $result[$i]['status_external'];
                $this->status_internal = $result[$i]['status_internal'];
                $this->email = $result[$i]['email'];
                $this->first_name = $result[$i]['first_name'];
                $this->last_name = $result[$i]['last_name'];
                $this->phone_checkout_local_code = $result[$i]['phone_checkout_local_code'];
                $this->phone_checkout_number = $result[$i]['phone_checkout_number'];

                $this->worker();


                array_push($transactions, array("serial" => $this->transaction_serial));
                // $this->cleanEverything();
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return $transactions;

    }

    private function worker()
    {
        try {
            $status = !1;
            if ($this->status_internal === "payment_approved") $status = $this->paymentApproved();
            if ($this->status_internal === "order_cancelled") $status = $this->orderCancelled();
            if ($status) {
                $this->setTransactionAsProcessed();
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    private function paymentApproved()
    {
        global $account;
        global $license;
        $register_id = 0;
        try {
            $token = new Token();
            $purchase_notification = new PurchaseNotifications();
            if (notempty($this->email)) {
                $id_account = $account->getIdAccountByEmailOrUsername($this->email);
                if ($id_account <= 0) $id_account = -1; // SET DO -1 BECAUSE 0 GET SESSION USER
                $accountTransaction = new Accounts($id_account);
                if ($accountTransaction->userExists()) {
                    $register_id = $accountTransaction->getIdAccount();
                    $purchase_notification->activateLicenseToUser($accountTransaction->getEmail(), $accountTransaction->getFullName());
                } else {
                    $password = $token::tokenAlphanumeric(8);
                    $register_id = $account->register($this->email, $this->first_name, $this->last_name, $password, $this->phone_checkout_number);
                    if ($register_id) $purchase_notification->newAccount($accountTransaction->getEmail(), $accountTransaction->getFullName(), $password);
                }
            }
            if (notempty($register_id) && $register_id > 0) {
                $license->setUserLicense(2, $register_id);
            }
            return $register_id;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    private function orderCancelled()
    {
        global $account;
        global $license;
        $register_id = 0;
        try {
            $purchase_notification = new PurchaseNotifications();
            if (notempty($this->email)) {
                $id_account = $account->getIdAccountByEmailOrUsername($this->email);
                $accountTransaction = new Accounts($id_account);
                if ($accountTransaction->userExists()) {
                    $register_id = $accountTransaction->getIdAccount();
                    $purchase_notification->confirmPurchaseCancelled($accountTransaction->getEmail(), $accountTransaction->getFullName());
                }
            }
            if (notempty($register_id) && $register_id > 0) {
                $license->setUserLicense(1, $register_id);
            }
            return $register_id;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }


    private function setTransactionAsProcessed()
    {
        try {
            $database = new Database();
            $database->query("UPDATE transactions SET is_processed = 'Y', processed_time = CURRENT_TIMESTAMP WHERE id_transaction = ?");
            $database->bind(1, $this->id_transaction);
            $database->execute();
            return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function setStatusInternal($status_internal)
    {
        $this->status_internal = $status_internal;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }


}