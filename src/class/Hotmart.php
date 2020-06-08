<?php

class Hotmart
{
    private $account_key = "XmLbUih3CrBbqyIUkd2ediGPSMuWTq10438961";

    private $id_transaction;
    private $id_account;
    private $callback_type;
    private $hottok;
    private $currency;
    private $transaction;
    private $xcod;
    private $payment_type;
    private $payment_engine;
    private $status;
    private $prod;
    private $prod_name;
    private $producer_name;
    private $producer_document;
    private $producer_legal_nature;
    private $transaction_ext;
    private $purchase_date;
    private $confirmation_purchase_date;
    private $currency_code_from;
    private $currency_code_from_;
    private $original_offer_price;
    private $offer_payment_mode;
    private $warranty_date;
    private $receiver_type;
    private $aff_cms_rate_currency;
    private $aff_cms_rate_commission;
    private $aff_cms_rate_conversion;
    private $installments_number;
    private $cms_marketplace;
    private $cms_vendor;
    private $off;
    private $price;
    private $full_price;
    private $has_co_production;
    private $email;
    private $name;
    private $first_name;
    private $last_name;
    private $phone_checkout_local_code;
    private $phone_checkout_number;
    private $sck;
    private $insert_time;
    private $is_active;

    private $postback;

    public function __construct(Array $postback = array())
    {
        if (!empty($postback)) {
            $this->postback = $postback;
            foreach ($postback as $key => $value) {
                if ($key === "productOfferPaymentMode") $key = "offer_payment_mode";
                if (property_exists('Hotmart', $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    private function insert()
    {
        try {
            $date = new Date();
            $date->setCustomDateFormat("Y-m-d H:i:s");
            $token = new Token();
            $this->id_account = null;
            $transaction_serial = $token::v4() . "-" . $token::v4();
            $database = new Database();
            $database->query("INSERT INTO transactions (id_account, transaction_serial, callback_type, hottok, currency, `transaction`, xcod, payment_type, payment_engine, status, prod, prod_name, producer_name, producer_document, producer_legal_nature, transaction_ext, purchase_date, confirmation_purchase_date, currency_code_from, currency_code_from_, original_offer_price, offer_payment_mode, warranty_date, receiver_type, aff_cms_rate_currency, aff_cms_rate_commission, aff_cms_rate_conversion, installments_number, cms_marketplace, cms_vendor, off, price, full_price, has_co_production, email, `name`, first_name, last_name, phone_checkout_local_code, phone_checkout_number, sck, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $database->bind(1, $this->id_account);
            $database->bind(2, $transaction_serial);
            $database->bind(3, $this->callback_type);
            $database->bind(4, $this->hottok);
            $database->bind(5, $this->currency);
            $database->bind(6, $this->transaction);
            $database->bind(7, $this->xcod);
            $database->bind(8, $this->payment_type);
            $database->bind(9, $this->payment_engine);
            $database->bind(10, $this->status);
            $database->bind(11, $this->prod);
            $database->bind(12, $this->prod_name);
            $database->bind(13, $this->producer_name);
            $database->bind(14, $this->producer_document);
            $database->bind(15, $this->producer_legal_nature);
            $database->bind(16, $this->transaction_ext);
            $database->bind(17, $date->formatDate($this->purchase_date, true));
            $database->bind(18, $date->formatDate($this->confirmation_purchase_date, true));
            $database->bind(19, $this->currency_code_from);
            $database->bind(20, $this->currency_code_from_);
            $database->bind(21, $this->original_offer_price);
            $database->bind(22, $this->offer_payment_mode);
            $database->bind(23, $date->formatDate($this->warranty_date, true));
            $database->bind(24, $this->receiver_type);
            $database->bind(25, $this->aff_cms_rate_currency);
            $database->bind(26, $this->aff_cms_rate_commission);
            $database->bind(27, $this->aff_cms_rate_conversion);
            $database->bind(28, $this->installments_number);
            $database->bind(29, $this->cms_marketplace);
            $database->bind(30, $this->cms_vendor);
            $database->bind(31, $this->off);
            $database->bind(32, $this->price);
            $database->bind(33, $this->full_price);
            $database->bind(34, ($this->has_co_production ? "Y" : "N"));
            $database->bind(35, $this->email);
            $database->bind(36, $this->name);
            $database->bind(37, $this->first_name);
            $database->bind(38, $this->last_name);
            $database->bind(39, $this->phone_checkout_local_code);
            $database->bind(40, $this->phone_checkout_number);
            $database->bind(41, $this->sck);
            $database->bind(42, "Y");
            $database->execute();
            return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function purchase()
    {
        global $account;
        global $license;
        $register_id = 0;
        try {
            $token = new Token();
            $purchase_notification = new PurchaseNotifications();
            $this->insert();
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
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function cancelledPurchase()
    {
        global $account;
        global $license;
        $register_id = 0;
        try {
            $purchase_notification = new PurchaseNotifications();
            $this->insert();
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
        } catch (Exception $exception) {
            error_log($exception);
        }
    }


}