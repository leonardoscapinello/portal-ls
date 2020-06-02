<?php

class SocialAnalytics
{

    private $google_tagManager = "GTM-P75P74L";
    private $google_analytics = "UA-162090744-1";

    private $facebook_pixel = array(
        "website" => "718959562261662"
    );
    private $facebook_meta = array(
        "uri" => "https://www.facebook.com/oleonardoscapinello",
        "entity_id" => "100048923713721"
    );



    public function getGoogleAnalyticsScript_Head($google_analytics = null)
    {
        if ($google_analytics === null) $google_analytics = $this->google_tagManager;
        if ($google_analytics === null) return null;
        $script = "<!-- Global site tag (gtag.js) - Google Analytics -->";
        $script .= "<script async src=\"https://www.googletagmanager.com/gtag/js?id=" . $google_analytics . "\"></script>";
        $script .= "<script>";
        $script .= "window.dataLayer = window.dataLayer || [];";
        $script .= "function gtag(){dataLayer.push(arguments);}";
        $script .= "gtag('js', new Date());";
        $script .= "gtag('config', '" . $google_analytics . "');";
        $script .= "</script>";
        return $script;
    }

    public function getGoogleTagManagerScript_Head($google_tagManager = null)
    {
        if ($google_tagManager === null) $google_tagManager = $this->google_tagManager;
        if ($google_tagManager === null) return null;
        $script = "<!-- Google Tag Manager -->";
        $script .= "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':";
        $script .= "new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],";
        $script .= "j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=";
        $script .= "'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);";
        $script .= "})(window,document,'script','dataLayer','" . $google_tagManager . "');</script>";
        $script .= "<!-- End Google Tag Manager -->";
        return $script;
    }

    public function getGoogleTagManagerScript_Body($google_tagManager = null)
    {
        if ($google_tagManager === null) $google_tagManager = $this->google_tagManager;
        if ($google_tagManager === null) return null;
        $script = "<!-- Google Tag Manager (noscript) -->";
        $script .= "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':";
        $script .= "<noscript><iframe src=\"https://www.googletagmanager.com/ns.html?id=" . $google_tagManager . "\"";
        $script .= "height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>";
        $script .= "<!-- End Google Tag Manager (noscript) -->";
        return $script;
    }

    public function getFacebookPixel_Head($pixel_name_or_id, $custom_track = "PageView")
    {
        $pixel_id = $pixel_name_or_id;
        if (array_key_exists($pixel_id, $this->facebook_pixel)) {
            $pixel_id = $this->facebook_pixel[$pixel_name_or_id];
        }
        $script = "<!-- Facebook Pixel Code -->";
        $script .= "<script>";
        $script .= "!function(f,b,e,v,n,t,s)";
        $script .= "{if(f.fbq)return;n=f.fbq=function(){n.callMethod?";
        $script .= "n.callMethod.apply(n,arguments):n.queue.push(arguments)};";
        $script .= "if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';";
        $script .= "n.queue=[];t=b.createElement(e);t.async=!0;";
        $script .= "t.src=v;s=b.getElementsByTagName(e)[0];";
        $script .= "s.parentNode.insertBefore(t,s)}(window, document,'script',";
        $script .= "'https://connect.facebook.net/en_US/fbevents.js');";
        $script .= "fbq('init', '" . $pixel_id . "');";
        $script .= "fbq('track', '" . $custom_track . "');";
        $script .= "</script>";
        $script .= "<noscript>";
        $script .= "<img height=\"1\" width=\"1\" style=\"display:none\"";
        $script .= "src=\"https://www.facebook.com/tr?id=" . $pixel_id . "&ev=PageView&noscript=1\"";
        $script .= "/></noscript>";
        $script .= "<!-- End Facebook Pixel Code -->";
        return $script;
    }

    public function getFacebookTrack_Body($custom_track = "PageView", $js_object = "")
    {
        if ($js_object === "") return "<script>fbq('track', '" . $custom_track . "');</script>";
        return "<script>fbq('track', '" . $custom_track . "',  " . $js_object . ");</script>";
    }

    /**
     * @return string
     */
    public function getGoogleAnalytics(): string
    {
        return $this->google_analytics;
    }

    public function extractCommonWords($string)
    {
        $stopWords = array('eu', 'um', 'sobre', 'uns', 'e', 'estamos', 'como', 'no', 'se', 'por', 'com', 'de', 'por', 'é', 'isso', 'foi', 'o que', 'quando', 'onde', 'quem', 'será', 'o', 'www');

        $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
        $string = trim($string); // trim the string
        $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
        $string = strtolower($string); // make it lowercase

        preg_match_all('/\b.*?\b/i', $string, $matchWords);
        $matchWords = $matchWords[0];

        foreach ($matchWords as $key => $item) {
            if ($item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3) {
                unset($matchWords[$key]);
            }
        }
        $wordCountArr = array();
        if (is_array($matchWords)) {
            foreach ($matchWords as $key => $val) {
                $val = strtolower($val);
                if (isset($wordCountArr[$val])) {
                    $wordCountArr[$val]++;
                } else {
                    $wordCountArr[$val] = 1;
                }
            }
        }
        arsort($wordCountArr);
        $wordCountArr = array_slice($wordCountArr, 0, 10);
        return $wordCountArr;
    }


}