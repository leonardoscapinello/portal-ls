<?php

class Scheduler
{
    private $id_notification;
    private $notification_serial;
    private $sender_name;
    private $sender_email;
    private $contact_name;
    private $contact_email;
    private $subject;
    private $content;
    private $content_unformatted;
    private $is_active;
    private $is_sent;
    private $insert_time;
    private $scheduled_time;
    private $sent_time;

    public function execute()
    {
        $notifications = array();
        try {
            $database = new Database();
            $database->query("SELECT * FROM `notifications` WHERE is_sent = 'N' AND sent_time IS NULL AND NOW() > scheduled_time LIMIT 10");
            $result = $database->resultset();
            for ($i = 0; $i < count($result); $i++) {
                $this->id_notification = $result[$i]['id_notification'];
                $this->notification_serial = $result[$i]['notification_serial'];
                $this->sender_name = $result[$i]['sender_name'];
                $this->sender_email = $result[$i]['sender_email'];
                $this->contact_name = $result[$i]['contact_name'];
                $this->contact_email = $result[$i]['contact_email'];
                $this->content = $result[$i]['content'];
                $this->subject = $result[$i]['subject'];
                $this->content_unformatted = $result[$i]['content_unformatted'];
                $this->is_active = $result[$i]['is_active'];
                $this->is_sent = $result[$i]['is_sent'];
                $this->insert_time = $result[$i]['insert_time'];
                $this->scheduled_time = $result[$i]['scheduled_time'];
                $this->sent_time = $result[$i]['sent_time'];
                $submit = $this->sendEmail();
                if ($submit) {
                    array_push($notifications, array("serial" => $this->notification_serial));
                    $this->markAsSent();
                }
                $this->cleanEverything();
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return $notifications;
    }

    private function sendEmail()
    {
        global $text;
        try {
            $email = new EmailNotification();
            $email->setContactName($text->base64_decode($this->contact_name));
            $email->setContactEmail($text->base64_decode($this->contact_email));
            $email->setSubject($text->base64_decode($this->subject));
            $email->setContent($text->base64_decode($this->content));
            $email->setSender("Leonardo");
            return $email->submit();;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    private function markAsSent()
    {
        try {
            $database = new Database();
            $database->query("UPDATE notifications SET is_sent = 'Y', sent_time = CURRENT_TIMESTAMP WHERE id_notification = ?");
            $database->bind(1, $this->id_notification);
            $database->execute();
        } catch (Exception $exception) {
            error_log($exception);
        }
    }


    private function cleanEverything()
    {
        $this->id_notification = null;
        $this->notification_serial = null;
        $this->sender_name = null;
        $this->sender_email = null;
        $this->contact_name = null;
        $this->contact_email = null;
        $this->content = null;
        $this->content_unformatted = null;
        $this->is_active = null;
        $this->is_sent = null;
        $this->insert_time = null;
        $this->scheduled_time = null;
        $this->sent_time = null;
    }
}