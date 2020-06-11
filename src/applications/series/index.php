<?php
require_once("../../../src/properties/index.php");
$less = new lessc;
$less->compileFile(DIRNAME . "../../public/less/series.less", DIRNAME . "../../public/stylesheet/ls.series.css");
$static->add(DIRNAME . "../../public/stylesheet/reset.css");
$static->add(DIRNAME . "../../public/stylesheet/container.css");
$static->add(DIRNAME . "../../public/stylesheet/ls.series.css");
$static->add(DIRNAME . "../../public/stylesheet/owl.carousel.css");
$static->add(DIRNAME . "../../public/stylesheet/owl.theme.default.css");
$static->add(DIRNAME . "../../public/fonts/gilroy/Gilroy.css");
$static->add(DIRNAME . "../../public/stylesheet/fontawesome.all.min.css");
$static->setOutputPath(DIRNAME . "../../public/stylesheet/");
 $static->replace("../images/", DEPLOY_SERVER . "public/images/");
 $static->replace("../fonts/", DEPLOY_SERVER . "public/fonts/");
$static->minifyStyleSheet("ls.series");

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

    $image = $static->loadBlog($contents->getCoverImage(), 700);
    if (!notempty($image)) {
        $image = $static->loadSeries($contents->getCoverImage(), $series->getShortKey(), 700);
    }
    $title = $contents->getTitle() . " - " . $series->getSerieName();
    $description = $series->getSeasonDescription();
    $cover_image = "";
    $keywords = $contents->getKeywords() . ", leonardo scapinello séries, marketing digital, aprenda sobre negócios, escola de negócios, escola de marketing, consultoria de marketing";
}


// INITIALIZE SOCIAL METRIC
$social->googleAnalytics();
$social->facebook();
$social->linkedIn();
$social->activeCampaign();
$social->mailChimp();
?>
<!doctype html>
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
    <?= $social->getHeadTags(); ?>
    <style type="text/css">
        .loader {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            position: absolute;
            top: calc(50% - 25px);
            left: calc(50% - 25px);
            vertical-align: middle;
            transform: translate(-50%, -50%);
            background: #FFFFFF;
        }


        .loader,
        .loader:before,
        .loader:after {
            animation: 1s infinite ease-in-out;
        }

        .loader:before,
        .loader:after {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
        }


        /* Loader 9 & 10 */

        .loader-9 {
            background-color: white;
            animation: loader9 0.4s infinite linear;
        }

        .loader-9:before {
            content: '';
            width: 80%;
            height: 80%;
            background-color: white;
            top: 20%;
            left: 20%;
            box-shadow: 5px -3px 0 rgba(229, 9, 20, 1),
            5px 5px 0 rgba(229, 9, 20, 0.5),
            -3px 5px 0 rgba(229, 9, 20, 0.3),
            -5px -5px 0 rgba(229, 9, 20, 0.1);
        }

        .loader-9:after {
            content: '';
            border: 3px solid white;
            background: #FFFFFF;
            z-index: 2;
            top: -3px;
            left: -3px;
        }

        @keyframes loader9 {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .ld-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #FFFFFF;
            z-index: 9999;
        }

        .ld-container img {
            position: absolute;
            top: calc(50%);
            left: calc(50%);
            transform: translate(-50%, -50%);
            width: 35px;
        }

    </style>

    <?php /* $social->getGoogleAnalyticsScript_Head(); ?>
    <?= $social->getFacebookPixel_Head("webiste");*/ ?>
</head>
<body>
<div class="ld-container">
    <div class="loader loader-9"></div>
    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACcAAAAnCAYAAACMo1E1AAABSElEQVRYhe3Wu0olQRDG8Z/iDREXAxPByEAEAxEFAx9iwcAH2NRYBBMTUSNjn8FAMTYzEDRQBGGDDTYQAxfBSLzghYEWegfPgRlaj2D/oWBquqvqo2uqGZlMJpPJfG96sYxzPOIl2FLdU+lIdJwD2MdkyvbUEbeJ8cj/ia3UwtQUN4XZyB/CXOQXLT3EQ/D/fqa4MsUptkf+PHYS5P0vaaocPQly1uYgmsTCxvAc+bfYwMhXEPcDe6V3L0Fw8e39QlcrxQ3i6B2Bb/YH060SV9CJBZw1EHiF/laJi5nAOq5Lexe/grg3inZfRnt3qxRKcZU04x8uovXuKsEpLuEV3Ifnu+APhymdKQ3C7wT1mlJua2w3IXC2wdVSaWI/uq0xqziuEpDql6kZJ1jDdtXAthrFRtHXYO0Jp2F9JAzDdY0amUwmk8k0Aq8NKmK71NtPuQAAAABJRU5ErkJggg==">
</div>
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
<?= $static->printCSS("ls.series.min.css") ?>
<?= $social->getBodyTags(); ?>
<?= $static->load("jquery.min.js"); ?>
<?= $static->load("owl.carousel.min.js"); ?>
<?= $static->load("jquery.mask.min.js"); ?>
<?= $static->load("jquery.withinviewport.js"); ?>
<?= $static->load("withinviewport.js"); ?>
<?= $static->load("leonardoscapinello.js"); ?>
<?= $static->load("lseries.js"); ?>
<script type="text/javascript">
    $(window).on("load", function () {
        $(".ld-container").fadeOut(200);
    });
    $(window).bind("beforeunload", function () {
        $(".ld-container").fadeIn(200);
    });
</script>
<?php /*$social->getFacebookTrack_Body(); ?>
<?= $social->getMailChimpStatic_Body();*/ ?>
</body>
</html>
