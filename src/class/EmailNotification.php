<?php


class EmailNotification
{
    private $contacts = array();
    private $elements = array();

    private $subject;
    private $sender = "Leonardo";
    private $preheader;

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

    public function send($template = "default.html")
    {
        global $mail;
        try {
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
            $mail->Password = "2ABkuizPJw2A";

            $mail->CharSet = 'utf-8';
            $mail->Subject = $this->subject;
            //$mail->setFrom($this->fromFix($this->sender), $this->sender . " do Portal LS");
            $mail->setFrom("leonardoscapinello@outlook.com", $this->sender . " do Portal LS");

            $template = @file_get_contents(DIRNAME . "../notifications/" . $template);

            $users = $this->contacts;
            $content = $content_r = "";
            $elements = $this->elements;


            if ($template !== null && $template !== "") {
                for ($i = 0; $i < count($users); $i++) {

                    $content = $template;
                    $content_r = "";

                    for ($x = 0; $x < count($elements); $x++) {
                        $content_r .= $elements[$x][0];
                    }

                    $content = str_replace("{{logo}}", "<img src=\"".STATIC_URL . "images/leonardo-scapinello-white-background.png\" alt=\"LS\">", $content);
                    $content = str_replace("{{content}}", $content_r, $content);
                    $content = str_replace("{{name}}", $users[$i]['name'], $content);
                    $content = str_replace("{{email}}", $users[$i]['email'], $content);
                    $content = str_replace("{{subject}}", $this->subject, $content);
                    $content = str_replace("{{preheader}}", $this->preheader, $content);

                    $mail->addAddress($users[$i]['email'], $users[$i]['name']);
                    $mail->Body = $content;
                    $mail->send();

                    $mail->clearAllRecipients();
                }
            }

            return true;

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