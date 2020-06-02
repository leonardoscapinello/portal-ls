<?php
require_once("../../../src/properties/index.php");
//$less = new lessc;
//$less->compileFile(DIRNAME . "../../public/less/series.less", DIRNAME . "../../public/stylesheet/ls.series.css");
//$static->add(DIRNAME . "../../public/stylesheet/reset.css");
//$static->add(DIRNAME . "../../public/stylesheet/container.css");
//$static->add(DIRNAME . "../../public/stylesheet/ls.series.css");
//$static->add(DIRNAME . "../../public/stylesheet/tooltip.css");
//$static->add(DIRNAME . "../../public/stylesheet/bootoast.css");
//$static->add(DIRNAME . "../../public/stylesheet/owl.carousel.css");
//$static->add(DIRNAME . "../../public/stylesheet/owl.theme.default.css");
//$static->add(DIRNAME . "../../public/stylesheet/switch.css");
//$static->add(DIRNAME . "../../public/fonts/gilroy/Gilroy.css");
//$static->add(DIRNAME . "../../public/fonts/imperial/imperial.css");
//$static->add(DIRNAME . "../../public/stylesheet/fontawesome.all.min.css");
//$static->setOutputPath(DIRNAME . "../../public/stylesheet/");
//$static->replace("../images/", "../../public/images/");
//$static->replace("../fonts/", "../../public/fonts/");
//$static->minifyStyleSheet("ls.series");

$ct_main = get_request("ct_main");
$author = new Accounts(1);/* ==================== LOAD SERIES AND EPISODES VARIABLES */;

$series = new Series();
$serie_url = get_request("serie_url");
$season_short_key = get_request("season_short_key");
$episode = get_request("episode");

$title = "Página Inicial";
$description = "Aprenda sobre marketing, negócios e direito digital com conteúdo escrito e organizado de forma prática e inteligente";
$cover_image = "";
$keywords = "séries, episodios, leonardo scapinello séries, marketing digital, aprenda sobre negócios, escola de negócios, escola de marketing, consultoria de marketing";

if ($ct_main === "view-serie") {
    if (!notempty($serie_url) || !notempty($season_short_key)) {
        header("location: " . SERVER_ADDRESS . "series");
        die;
    }
    $loaded = $series->loadSeasonFromSerieURL($serie_url, $season_short_key);
    if (!$loaded) {
        header("location: " . SERVER_ADDRESS . "series");
        die;
    }
    $contents = new Contents(true);
    $contents->loadById($series->getIdContent());

    $extracted = "";
    $commons = $social->extractCommonWords($description);
    foreach ($commons as $key => $value) {
        $extracted .= $key . ", ";
    }
    $title = $series->getSerieName() . " Temporada " . $series->fixSeasonLevel($series->getSeasonLevel());
    $description = $series->getSeasonDescription();
    $cover_image = "";
    $keywords = $extracted . "leonardo scapinello séries, marketing digital, aprenda sobre negócios, escola de negócios, escola de marketing, consultoria de marketing";


} elseif ($ct_main === "view-episode") {
    if (!notempty($serie_url) || !notempty($season_short_key) || !notempty($episode)) {
        header("location: " . SERVER_ADDRESS . "series");
        die;
    }
    $loaded = $series->loadEpisode($episode, $season_short_key);
    if (!$loaded) {
        header("location: " . SERVER_ADDRESS . "series");
        die;
    }

    $days_to_launch = $date->getDaysOfDifference(date("Y-m-d"), $series->getLaunchDate());


    $contents = new Contents(true);
    $contents->loadById($series->getIdContent());
    $contentNote = new ContentsNotes();
    $content_edited = $contentNote->getContent($contents->getIdContent());

    $image = $static->loadBlog($contents->getCoverImage());
    if (!notempty($image)) {
        $image = $static->loadSeries($contents->getCoverImage(), $series->getShortKey());
    }

    $title = $contents->getTitle() . " - " . $series->getSerieName();
    $description = $series->getSeasonDescription();
    $cover_image = "";
    $keywords = $contents->getKeywords() . ", leonardo scapinello séries, marketing digital, aprenda sobre negócios, escola de negócios, escola de marketing, consultoria de marketing";


}

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?> | <?= PAGE_TITLE_SERIES ?></title>
    <meta name="description" content="<?= $description ?>"/>
    <meta name="keywords" content="<?= $keywords ?>">
    <meta name="subject" content="<?= $title ?>">
    <meta name="copyright" content="Leonardo Scapinello">
    <meta name="language" content="pt-BR">
    <meta name="robots" content="index,follow"/>
    <meta name="Classification" content="educacional, escola, school">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global"/>
    <meta name="rating" content="General"/>
    <meta name="author" content="<?= $author->getFullName() ?>, <?= $author->getEmail() ?>">
    <meta name="url" content="<?= $url->getActualURL() ?>">
    <meta name="identifier-URL" content="<?= $url->getActualURL() ?>">
    <meta name="og:title" content="<?= $title ?> - <?= PAGE_TITLE ?>"/>
    <meta name="og:type" content="article"/>
    <meta name="og:url" content="<?= $url->getActualURL() ?>"/>
    <meta name="og:image" content="<?= $cover_image ?>"/>
    <meta name="og:site_name" content="Leonardo Scapinello"/>
    <meta name="og:description" content="<?= $description ?>"/>
    <meta name="og:email" content="leonardo@flexwei.com"/>
    <meta name="google-analytics" content="<?= $social->getGoogleAnalytics() ?>"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="yes" name="apple-touch-fullscreen"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="application-name" content="<?= $title ?>"/>
    <meta name="msapplication-tooltip" content="<?= PAGE_TITLE ?>"/>
    <link rel="shortcut icon" href="<?= SERVER_ADDRESS ?>favicon.ico"/>
    <style type="text/css">
        .fp-loader {
            background: rgba(255, 255, 255, .5);
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
        }

        .fp-loader .loader-center {
            background: #FFFFFF;
            border-radius: 5px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            padding: 10px 30px;
            -webkit-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.25);
            -moz-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.25);
            box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.25);
        }

        .fp-loader .loader-center p {
            font-family: 'Arial', sans-serif !important;
            text-transform: lowercase;
            font-size: 14px;
            margin-top: 5px;
        }

    </style>

    <?= $static->load("ls.series.min.css") ?>
    <?=$social->getGoogleTagManagerScript_Head(); ?>
    <?=$social->getGoogleAnalyticsScript_Head(); ?>
    <?=$social->getFacebookPixel_Head(); ?>
</head>
<body>
<div id="wrapper">
    <?php if ($ct_main === "view-serie") {
        require_once(DIRNAME . "../applications/series/view-serie.php");
    } elseif ($ct_main === "view-episode") {
        require_once(DIRNAME . "../applications/series/view-episode.php");
    } else {
        require_once(DIRNAME . "../components/series/header-featured.php");
        require_once(DIRNAME . "../components/series/featured.php");
        require_once(DIRNAME . "../components/series/promote-serie.php");
    }
    require_once(DIRNAME . "../components/footer.php");
    ?>
</div>

<?= $static->load("jquery.min.js"); ?>
<?= $static->load("owl.carousel.min.js"); ?>
<?= $static->load("jquery.mask.min.js"); ?>
<?= $static->load("jquery.withinviewport.js"); ?>
<?= $static->load("withinviewport.js"); ?>
<?= $static->load("leonardoscapinello.js"); ?>
<?= $static->load("lseries.js"); ?>
<?=$social->getGoogleTagManagerScript_Body(); ?>
<?=$social->getFacebookTrack_Body(); ?>
</body>
</html>
