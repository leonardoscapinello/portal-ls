<?php


use PHPMailer\PHPMailer\PHPMailer;

class EmailNotification
{
    private $contacts = array();
    private $elements = array();

    private $subject;
    private $sender = "Leonardo";
    private $preheader;
    private $content;
    private $contact_name;
    private $contact_email;

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setSender(string $sender)
    {
        $this->sender = $sender;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function setContactName($contact_name)
    {
        $this->contact_name = $contact_name;
    }

    public function setContactEmail($contact_email)
    {
        $this->contact_email = $contact_email;
    }


    public function paragraph($text)
    {
        $element = "<p>" . $text . "</p>";
        $this->add($element);
    }

    public function button($text, $link)
    {
        $element = "<br /><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"btn btn-primary\"> <tbody> <tr> <td align=\"left\"> <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"> <tbody> <tr> <td> <a href=\"" . $link . "\" target=\"_blank\">" . $text . "</a></td> </tr> </tbody> </table> </td> </tr> </tbody> </table><br />";
        $this->add($element);
    }

    public function breakLine()
    {
        $element = "<br/>";
        $this->add($element);
    }

    public function image($source, $alt)
    {
        $element = "<img src=\"" . $source . "\" alt=\"" . $alt . "\" style=\"display: block\">";
        $this->add($element);
    }

    public function heading($text)
    {
        $element = "<h3>" . $text . "</h3>";
        $this->add($element);
    }

    public function subject($subject)
    {
        $this->subject = $subject;
    }

    public function preheader($preheader)
    {
        $this->preheader = $preheader;
    }

    public function contact($name, $email)
    {
        array_push($this->contacts, array(
            "name" => $name,
            "email" => $email
        ));
    }

    public function countdown($datetime, $textColorRGB = "255,255,255")
    {
        $datetimeSplit = explode(" ", $datetime);
        $image = SERVER_ADDRESS . "media/countdown/" . $datetimeSplit[0] . "/" . $datetimeSplit[1] . "?textColor=" . $textColorRGB;
        $this->image($image, "Contador Regressivo até " . date("d/m/Y H:i:s", strtotime($datetime)));
    }

    public function save($template = "default.html")
    {
        global $text;
        try {
            $token = new Token();
            $notification_serial = $token::v4() . "-" . $token::tokenAlphanumeric(32);
            $database = new Database();
            $contacts = $this->contacts;

            for ($i = 0; $i < count($contacts); $i++) {
                $contact_name = $contacts[$i]['name'];
                $contact_email = $contacts[$i]['email'];
                $subject = $this->subject;
                $preheader = $this->preheader;
                $elements = $this->elements;
                $template = @file_get_contents(DIRNAME . "../notifications/" . $template);
                if (notempty($contact_name) && notempty($contact_email)) {
                    $content_unformatted = "";
                    for ($x = 0; $x < count($elements); $x++) {
                        $content_unformatted .= $elements[$x][0];
                    }
                    if ($content_unformatted) {
                        $content = $template;
                        $content = str_replace("{{logo}}", "<img src=\"" . STATIC_URL . "images/leonardo-scapinello-white-background.png\" alt=\"LS\">", $content);
                        $content = str_replace("{{content}}", $content_unformatted, $content);
                        $content = str_replace("{{name}}", $contact_name, $content);
                        $content = str_replace("{{email}}", $contact_email, $content);
                        $content = str_replace("{{subject}}", $subject, $content);
                        $content = str_replace("{{preheader}}", $preheader, $content);
                        $database->query("INSERT INTO notifications (notification_serial, sender_name, sender_email, contact_name, contact_email, subject, content, content_unformatted) VALUES (?,?,?,?,?,?,?,?)");
                        $database->bind(1, $notification_serial);
                        $database->bind(2, $text->base64_encode($this->sender));
                        $database->bind(3, $text->base64_encode($this->fromFix("leonardo")));
                        $database->bind(4, $text->base64_encode($contact_name));
                        $database->bind(5, $text->base64_encode($contact_email));
                        $database->bind(6, $text->base64_encode($subject));
                        $database->bind(7, $text->base64_encode($content));
                        $database->bind(8, $text->base64_encode($content_unformatted));
                        $database->execute();
                    }
                }
            }

        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function submit()
    {
        global $mail;
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Host = "smtp.office365.com";
            $mail->Port = 587;
            $mail->IsHTML(true);
            $mail->Username = "leonardoscapinello@outlook.com";
            $mail->Password = "25pD86zhh8x6@";
            $mail->CharSet = 'utf-8';
            $mail->Subject = $this->subject;
            $mail->setFrom("leonardoscapinello@outlook.com", $this->sender . " do Portal LS");
            $content = $this->content;
            $mail->addAddress($this->contact_email, $this->contact_name);
            $mail->Body = $content;
            $sent = $mail->send();
            $mail->clearAllRecipients();
            return $sent;
        } catch (\PHPMailer\PHPMailer\Exception  $exception) {
            error_log($exception);
        }
        return false;
    }


    private function add($element)
    {
        array_push($this->elements, array($element));
    }

    private function fromFix($s)
    {
        $s = str_replace(" ", ".", $s);
        $s = str_replace("@", ".", $s);
        $s = strtolower($s);
        return $s . "@leonardoscapinello.com";
    }


}