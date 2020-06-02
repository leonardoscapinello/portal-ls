<?php

class ContentsPrint
{

    public function separateParagraphs($text)
    {
        $dom = new DOMDocument();
        $paragraphs = array();
        $dom->loadHTML($text);
        foreach ($dom->getElementsByTagName('p') as $node) {
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
        $paragraphs = $this->separateParagraphs($text);
        $final_array = array();
        $counter = 0;
        $combine_string = "";

        for ($i = 0; $i < count($paragraphs); $i++) {
            $paragraph_notags = $paragraphs[$i];
            $paragraph_notags = preg_replace("/<p[^>]+\>|<\/p>/i", "", $paragraph_notags);
            $paragraph_notags = preg_replace("/<span[^>]+\>|<\/span>/i", "", $paragraph_notags);
            $text_words = $this->countLetters($paragraph_notags);
            $counter = ($counter + $text_words);
            if ($counter < 2000) {
                $combine_string .= $paragraphs[$i];
            } else {
                // CLOSE BEFORE AND RESET
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

            $url = SERVER_ADDRESS . "series/print/" . $hash_content . "?id_account=" . $id_account . "&filename=" . $filename;
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
            curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function PDFExists($filename)
    {
        $file = DIRNAME . "../../public/documents/" . $filename . ".pdf";
        return file_exists($file);
    }


}