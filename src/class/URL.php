<?php

class URL
{

    private $custom_url = "";

    private $accents = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ', 'á', 'é', 'í', 'ó', 'ú');
    private $noAccents = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'B', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'p', 'y', 'a', 'e', 'i', 'o', 'u');

    private function act()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    /**
     * @param string $custom_url
     */
    public function setCustomUrl(string $custom_url)
    {
        $this->custom_url = $custom_url;
    }


    public function getActualURL()
    {
        if (not_empty($this->custom_url)) {
            return $this->custom_url;
        }
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function getActualURLAsNext()
    {
        return base64_encode($this->getActualURL());
    }

    public function addQueryString($array)
    {
        $url = $this->getActualURL();
        if ($this->queryStringExists($url)) {
            return $url . "&" . http_build_query($array);
        } else {
            return $url . "?" . http_build_query($array);
        }
    }

    public function removeQueryString($array_of_keys)
    {
        $url = $this->getActualURL();
        if (is_array($array_of_keys)) {
            foreach ($array_of_keys as $key) {
                $url = preg_replace('/(?:&|(\?))' . $key . '=[^&]*(?(1)&|)?/i', "$1", $url);
                $url = rtrim($url, '?');
                $url = rtrim($url, '&');
            }
        } else {
            $url = preg_replace('/(?:&|(\?))' . $array_of_keys . '=[^&]*(?(1)&|)?/i', "$1", $url);
            $url = rtrim($url, '?');
            $url = rtrim($url, '&');
        }

        return $url;
    }

    private function queryStringExists($url)
    {
        if (false !== strpos($url, '?')) {
            return true;
        }
        return false;
    }


    public function friendly($value)
    {
        global $text;
        try {

            $html = new \Html2Text\Html2Text($value);
            $value = $html->getText();

            $value = $text->utf8($value);
            $value = $text->lowercase($value);


            // Convert all dashes to hyphens
            $value = str_replace('—', '-', $value);
            $value = str_replace('‒', '-', $value);
            $value = str_replace('―', '-', $value);

            // Convert underscores and spaces to hyphens
            $value = str_replace('_', '-', $value);
            $value = str_replace(' ', '-', $value);

            $value = htmlspecialchars_decode($value);
            $value = html_entity_decode($value);

            $value = str_replace($this->accents, $this->noAccents, $value);

            $value = preg_replace('/[^A-Za-z0-9-]+/', '', $value);

            do {
                $value = str_replace('--', '-', $value);
            } while (mb_substr_count($value, '--') > 0);

            return $value;
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

}