<?php
header("Access-Control-Allow-Origin: *");

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

//ini_set('display_errors', 1);
//ini_set('error_log', "error_log");

$server = $_SERVER['SERVER_NAME'];
if ($server === "localhost") {
    $server = "http://localhost/lscapinello";
} else {
    $server = "https://" . $server;
}

define("DIRNAME", dirname(__FILE__) . "/");
define("DEPLOY_SERVER", "https://leonardoscapinello.com/");
define("SERVER_ADDRESS", $server . "/");
define("BLOG_ADDRESS", SERVER_ADDRESS . "blog/");
define("LOGIN_URL", SERVER_ADDRESS . "login");
define("REGISTER_URL", SERVER_ADDRESS . "cadastro");
define("LOGOUT_URL", SERVER_ADDRESS . "logout");
define("FINISH_REGISTER_URL", SERVER_ADDRESS . "cadastro/concluir");
define("STATIC_URL", SERVER_ADDRESS . "public/");
define("LAUNCH_ADDRESS", SERVER_ADDRESS . "launch/");
define("PROFILE_ADDRESS", SERVER_ADDRESS . "perfil");
define("PAGE_TITLE", "Leonardo Scapinello");
define("PAGE_TITLE_SERIES", "LS Séries");
define("VERSION", "1.0.0.0");


define("MONTHLY_SUB", "https://pay.hotmart.com/O27570351G?off=0mfqr1y5");
define("YEARLY_SUB", "https://pay.hotmart.com/O27570351G?off=iwa2cq2g");


require_once(DIRNAME . "../vendor/autoload.php");

require_once(DIRNAME . "/../functions/http_response_code.php");
require_once(DIRNAME . "/../functions/user_agent.php");
require_once(DIRNAME . "../functions/notempty.php");
require_once(DIRNAME . "../functions/XML2Array.php");
require_once(DIRNAME . "../functions/sanitize_output.php");
require_once(DIRNAME . "../functions/translate.php");
require_once(DIRNAME . "../functions/get_request.php");
require_once(DIRNAME . "../functions/is_selected.php");
require_once(DIRNAME . "../functions/get_page.php");
require_once(DIRNAME . "../functions/stringsafe.php");

require_once(DIRNAME . "/../class/Text.php");
require_once(DIRNAME . "/../class/URL.php");
require_once(DIRNAME . "/../class/Date.php");
require_once(DIRNAME . "/../class/Token.php");
require_once(DIRNAME . "/../class/Numeric.php");
require_once(DIRNAME . "/../class/Database.php");
require_once(DIRNAME . "/../vendor/leafo/lessphp/lessc.inc.php");
require_once(DIRNAME . "/../class/Accounts.php");
require_once(DIRNAME . "/../class/AccountSession.php");
require_once(DIRNAME . "/../class/AccountsLicense.php");
require_once(DIRNAME . "/../class/AccountsPreferences.php");
require_once(DIRNAME . "/../class/Security.php");
require_once(DIRNAME . "/../class/SocialAnalytics.php");
require_once(DIRNAME . "/../class/StaticCompiler.php");
require_once(DIRNAME . "/../class/Contents.php");
require_once(DIRNAME . "/../class/ContentsNotes.php");
require_once(DIRNAME . "/../class/ContentsPrint.php");
require_once(DIRNAME . "/../class/Series.php");
require_once(DIRNAME . "/../class/BlogIntelligence.php");
require_once(DIRNAME . "/../class/EmailNotification.php");
require_once(DIRNAME . "/../class/Landing.php");
require_once(DIRNAME . "/../class/ContentsViews.php");
require_once(DIRNAME . "/../class/BrowserDetection.php");
require_once(DIRNAME . "/../class/ExternalServiceList.php");
require_once(DIRNAME . "/../class/Scheduler.php");
require_once(DIRNAME . "/../class/Hotmart.php");
require_once(DIRNAME . "/../class/PurchaseNotifications.php");

require DIRNAME . '/../vendor/phpmailer/phpmailer/src/Exception.php';
require DIRNAME . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require DIRNAME . '/../vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

$static = new StaticCompiler();
$social = new SocialAnalytics();
$contents = new Contents();
$text = new Text();
$date = new Date();
$url = new URL();

$session = new AccountSession();
$account = new Accounts();
$license = new AccountsLicense();
$blogIntelligence = new BlogIntelligence();
$numeric = new Numeric();
$browser = new BrowserDetection();



//DISABLED BECAUSE GOING DO PRODUCTION



$next = get_request("next");
if (not_empty($next)) {
    $next = $text->base64_encode($next);
}


$account->storeSession();

ob_start("sanitize_output");