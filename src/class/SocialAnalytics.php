<?php

class SocialAnalytics
{

    private $google_tagManager = "GTM-P75P74L";
    private $google_analytics = "UA-162090744-1";

    private $facebook_pixel = array(
        "website" => "208143977128540"
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


        $script = null;
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


        $script = null;
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


        $script = null;
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


        $script = null;
        return $script;
    }

    public function getFacebookTrack_Body($custom_track = "PageView", $js_object = "")
    {
        if ($js_object === "") return "<script>fbq('track', '" . $custom_track . "');</script>";


        $script = null;
        return "<script>fbq('track', '" . $custom_track . "',  " . $js_object . ");</script>";
    }

    /**
     * @return string
     */
    public function getGoogleAnalytics(): string
    {
        return $this->google_analytics;
    }



}