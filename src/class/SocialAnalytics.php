<?php

class SocialAnalytics
{

    private $google_analytics = "UA-162090744-1";
    private $facebook_pixel = "718959562261662";
    private $activecampaign_id = "610624866";
    private $outbrain = "007d13e3db487184cd08ef006f6a529493";
    private $linkeding_insight = "2293801";


    private $facebook_meta = array(
        "uri" => "https://www.facebook.com/oleonardoscapinello",
        "entity_id" => "100048923713721"
    );

    private $facebook = false;
    private $activeCampaign = false;
    private $mailChimp = false;
    private $linkedIn = false;
    private $googleAnalytics = false;
    private $body_tags;
    private $head_tags;

    private function getGoogleAnalytics_Head($id)
    {
        if ($id === null) $google_analytics = $this->$id;
        if ($id === null) return null;
        $script = "<!-- Global site tag (gtag.js) - Google Analytics -->";
        $script .= "<script async src=\"https://www.googletagmanager.com/gtag/js?id=" . $id . "\"></script>";
        $script .= "<script>";
        $script .= "window.dataLayer = window.dataLayer || [];";
        $script .= "function gtag(){dataLayer.push(arguments);}";
        $script .= "gtag('js', new Date());";
        $script .= "gtag('config', '" . $id . "');";
        $script .= "</script>";
        return $script;
    }

    private function getFacebookPixel_Head($id, $custom_track = "PageView")
    {
        if ($id === null) $id = $this->facebook_pixel;
        if ($id === null) return null;
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
        $script .= "fbq('init', '" . $id . "');";
        $script .= "fbq('track', '" . $custom_track . "');";
        $script .= "</script>";
        $script .= "<noscript>";
        $script .= "<img height=\"1\" width=\"1\" style=\"display:none\"";
        $script .= "src=\"https://www.facebook.com/tr?id=" . $id . "&ev=PageView&noscript=1\"";
        $script .= "/></noscript>";
        $script .= "<!-- End Facebook Pixel Code -->";
        return $script;
    }


    private function getFacebookTrack_Body($custom_track = "PageView", $js_object = "")
    {
        if ($js_object === "") return "<script>fbq('track', '" . $custom_track . "');</script>";
        return "<script>fbq('track', '" . $custom_track . "',  " . $js_object . ");</script>";
    }

    private function getMailChimpStatic_Body()
    {
        return "<script id=\"mcjs\">!function (c, h, i, m, p) {m = c.createElement(h), p = c.getElementsByTagName(h)[0], m.async = 1, m.src = i, p.parentNode.insertBefore(m, p)}(document, \"script\", \"https://chimpstatic.com/mcjs-connected/js/users/1bdc1f491a693ce497e967ebe/bc61fea27526592f33d98ba01.js\");</script>";
    }

    private function getOutBraing_Body($id)
    {
        if ($id === null) $id = $this->outbrain;
        if ($id === null) return null;
        $script = "<script data-obct type=\"text/javascript\">";
        $script .= "/** DO NOT MODIFY THIS CODE**/";
        $script .= "!function(_window, _document) {";
        $script .= "var OB_ADV_ID='" . $id . "';";
        $script .= "if (_window.obApi) {var toArray = function(object) {return Object.prototype.toString.call(object) === '[object Array]' ? object : [object];};_window.obApi.marketerId =";
        $script .= "toArray(_window.obApi.marketerId).concat(toArray(OB_ADV_ID));return;}";
        $script .= "var api = _window.obApi = function() {api.dispatch ? api.dispatch.apply(api, arguments) : api.queue.push(arguments);};api.version = '1.1';api.loaded = true;api.marketerId = ";
        $script .= "OB_ADV_ID;api.queue = [];var tag = _document.createElement('script');tag.async = true;tag.src = '//amplify.outbrain.com/cp/obtp.js';tag.type = 'text/javascript';var script = ";
        $script .= "_document.getElementsByTagName('script')[0];script.parentNode.insertBefore(tag, script);}(window, document);";
        $script .= "obApi('track', 'PAGE_VIEW');";
        $script .= "</script>";
        return $script;
    }

    private function getLinkedIn_Body($id)
    {
        if ($id === null) $id = $this->linkeding_insight;
        if ($id === null) return null;
        $script = "<script type=\"text/javascript\">";
        $script .= "_linkedin_partner_id = \"" . $id . "\";";
        $script .= "window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];";
        $script .= "window._linkedin_data_partner_ids.push(_linkedin_partner_id);";
        $script .= "</script><script type=\"text/javascript\">";
        $script .= "(function(){var s = document.getElementsByTagName(\"script\")[0];";
        $script .= "var b = document.createElement(\"script\");";
        $script .= "b.type = \"text/javascript\";b.async = true;";
        $script .= "b.src = \"https://snap.licdn.com/li.lms-analytics/insight.min.js\";";
        $script .= "s.parentNode.insertBefore(b, s);})();";
        $script .= "</script>";
        $script .= "<noscript>";
        $script .= "<img height=\"1\" width=\"1\" style=\"display:none;\" alt=\"\" src=\"https://px.ads.linkedin.com/collect/?pid=" . $id . "&fmt=gif\" />";
        $script .= "</noscript>";
        return $script;
    }

    private function getActiveCampaign_Body($id)
    {
        if ($id === null) $id = $this->activecampaign_id;
        if ($id === null) return null;
        $script = "<script type=\"text/javascript\">";
        $script .= "(function(e,t,o,n,p,r,i){e.visitorGlobalObjectAlias=n;e[e.visitorGlobalObjectAlias]=e[e.visitorGlobalObjectAlias]||function(){(e[e.visitorGlobalObjectAlias].q=e[e.visitorGlobalObjectAlias].q||[]).push(arguments)};e[e.visitorGlobalObjectAlias].l=(new Date).getTime();r=t.createElement(\"script\");r.src=o;r.async=true;i=t.getElementsByTagName(\"script\")[0];i.parentNode.insertBefore(r,i)})(window,document,\"https://diffuser-cdn.app-us1.com/diffuser/diffuser.js\",\"vgo\");";
        $script .= "vgo('setAccount', '" . $id . "');";
        $script .= "vgo('setTrackByDefault', true);";
        $script .= "vgo('process');";
        $script .= "</script>";
        return $script;
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

    public function getGoogleAnalytics(): string
    {
        return $this->google_analytics;
    }


    public function facebook($custom_track = "PageView", $custom_id = null)
    {
        if (notempty($custom_id)) $this->facebook_pixel = $custom_id;
        $this->body_tags .= $this->getFacebookTrack_Body($custom_track);
        $this->head_tags .= $this->getFacebookPixel_Head($this->facebook_pixel, $custom_track);
    }

    public function activeCampaign($custom_id = null)
    {
        if (notempty($custom_id)) $this->activecampaign_id = $custom_id;
        $this->body_tags .= $this->getActiveCampaign_Body($this->activecampaign_id);
    }

    public function mailChimp()
    {
        $this->body_tags .= $this->getMailChimpStatic_Body();
    }

    public function googleAnalytics($custom_id = null)
    {
        if (notempty($custom_id)) $this->google_analytics = $custom_id;
        $this->head_tags .= $this->getGoogleAnalytics_Head($this->google_analytics);
    }

    public function linkedIn($enabled = true, $custom_id = null)
    {
        $this->linkedIn = $enabled;
        if (notempty($custom_id)) $this->linkeding_insight = $custom_id;
        $this->body_tags .= $this->getLinkedIn_Body($this->linkeding_insight);
    }

    public function getBodyTags()
    {
        return $this->body_tags;
    }

    public function getHeadTags()
    {
        return $this->head_tags;
    }

}