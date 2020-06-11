<?php

class ContentsPrint
{

    protected $max_letters = 1450;

    public function separatesTextBlocks($text)
    {
        $dom = new DOMDocument();
        $paragraphs = array();

        $prefix = "<lstext meta=\"%s\">";
        $suffix = "</lstext>";

        $text = preg_replace("%(<p[^>]*>.*?</p>)%i", sprintf($prefix, "paragraph") . "\${1}" . $suffix, $text);
        $text = preg_replace("%(<h1[^>]*>.*?</h1>)%i", sprintf($prefix, "heading1") . "\${1}" . $suffix, $text);
        $text = preg_replace("%(<h2[^>]*>.*?</h2>)%i", sprintf($prefix, "heading2") . "\${1}" . $suffix, $text);
        $text = preg_replace("%(<h3[^>]*>.*?</h3>)%i", sprintf($prefix, "heading3") . "\${1}" . $suffix, $text);
        $text = preg_replace("%(<h4[^>]*>.*?</h4>)%i", sprintf($prefix, "heading4") . "\${1}" . $suffix, $text);
        $text = preg_replace("%(<h5[^>]*>.*?</h5>)%i", sprintf($prefix, "heading5") . "\${1}" . $suffix, $text);
        $text = preg_replace("%(<h6[^>]*>.*?</h6>)%i", sprintf($prefix, "heading6") . "\${1}" . $suffix, $text);

        @$dom->loadHTML($text);
        foreach ($dom->getElementsByTagName('lstext') as $node) {
            $paragraphs[] = $dom->saveHTML($node);
        }
        return ($paragraphs);
    }

    public function countLetters($text)
    {
        return strlen($text);
    }

    public function preparePages($text)
    {
        $paragraphs = $this->separatesTextBlocks($text);
        $final_array = array();
        $counter = 0;
        $combine_string = "";

        for ($i = 0; $i < count($paragraphs); $i++) {

            // USADO PARA CONTAR CARACTERES
            $paragraph_notags = $paragraphs[$i];
            $paragraph_notags = preg_replace("/<p[^>]+\>|<\/p>/i", "", $paragraph_notags);
            $paragraph_notags = preg_replace("/<h1[^>]+\>|<\/h1>/i", "", $paragraph_notags);
            $paragraph_notags = preg_replace("/<h2[^>]+\>|<\/h2>/i", "", $paragraph_notags);
            $paragraph_notags = preg_replace("/<h3[^>]+\>|<\/h3>/i", "", $paragraph_notags);
            $paragraph_notags = preg_replace("/<h4[^>]+\>|<\/h4>/i", "", $paragraph_notags);
            $paragraph_notags = preg_replace("/<h5[^>]+\>|<\/h5>/i", "", $paragraph_notags);
            $paragraph_notags = preg_replace("/<h6[^>]+\>|<\/h6>/i", "", $paragraph_notags);
            $paragraph_notags = preg_replace("/<span[^>]+\>|<\/span>/i", "", $paragraph_notags);
            $text_words = $this->countLetters($paragraph_notags);


            $counter = ($counter + $text_words);
            $samePage = true;
            if ($counter > ($this->max_letters * 0.75)) {
                if (strpos($paragraphs[$i], "meta=\"paragraph\"") === false) {
                    $samePage = false;
                }
            }

            if ($counter <= $this->max_letters && $samePage) {
                $combine_string .= $paragraphs[$i];
            } else {
                // CLOSE LAST AND RESET
                array_push($final_array, $combine_string);
                $combine_string = "";
                $counter = 0;
                $text_words = $this->countLetters($paragraph_notags);
                $counter = ($counter + $text_words);
                $combine_string .= $paragraphs[$i];
            }
            if ($i === count($paragraphs) - 1) {
                array_push($final_array, $combine_string);
            }
        }
        return $final_array;
    }

    public function render($hash_content, $id_account, $filename = null)
    {
        global $database;
        global $account;
        global $url;
        try {

            if (!notempty($filename)) $filename = $account->getIdAccount() . "-" . $hash_content;

            $url = SERVER_ADDRESS . "series/print/" . $hash_content . "?filename=" . $filename;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
            curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpcode === 200) return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function PDFExists($filename)
    {
        $file = DIRNAME . "../../public/documents/" . $filename . ".pdf";
        return file_exists($file);
    }


}