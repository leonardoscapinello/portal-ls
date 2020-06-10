<?php
require_once("./src/properties/index.php");

$links_list = array(
    array(
        "title" => "Organize seu Instagram",
        "url" => "https://ls-go.com/planilha",
        "icon" => "far fa-download",
        "tags" => array(
            array(
                "text" => "Planilha Grátis",
                "color" => "green"
            )
        ),
        "locked" => false
    ),
    array(
        "title" => "Grupo do Leonardo no Telegram",
        "url" => "https://ls-go.com/telegram",
        "icon" => "fab fa-telegram-plane",
        "tags" => array(
            array(
                "text" => "Grupo VIP",
                "color" => "blue"
            )
        ),
        "locked" => false
    ),
    array(
        "title" => "Notes: Temporada 1",
        "url" => "https://ls-go.com/H4PAJS",
        "icon" => "far fa-chevron-right",
        "tags" => array(
            array(
                "text" => "Série Exclusiva",
                "color" => "purple"
            )
        ),
        "locked" => true
    ),
)

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Núvem de Links - <?= PAGE_TITLE ?></title>
    <meta name="description" content="Links rápidos para acessar os conteúdos em destaque do site Leonardo Scapinello"/>
    <meta name="subject" content="Núvem de Links - <?= PAGE_TITLE ?>">
    <meta name="copyright" content="Leonardo Scapinello">
    <meta name="language" content="pt-BR">
    <meta name="robots" content="index,follow"/>
    <meta name="Classification" content="educacional, escola, school">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global"/>
    <meta name="rating" content="General"/>
    <meta name="author" content="Leonardo Scapinello, portal@lsgo.me">
    <meta name="url" content="<?= $url->getActualURL() ?>">
    <meta name="identifier-URL" content="<?= $url->getActualURL() ?>">
    <meta name="og:title" content="Núvem de Links - <?= PAGE_TITLE ?>"/>
    <meta name="og:type" content="article"/>
    <meta name="og:url" content="<?= $url->getActualURL() ?>"/>
    <meta name="og:image" content="<?= $contents->getCoverImage() ?>"/>
    <meta name="og:site_name" content="Leonardo Scapinello"/>
    <meta name="og:description"
          content="Links rápidos para acessar os conteúdos em destaque do site Leonardo Scapinello"/>
    <meta name="og:email" content="leonardo@flexwei.com"/>
    <meta name="google-analytics" content="<?= $social->getGoogleAnalytics() ?>"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="yes" name="apple-touch-fullscreen"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="application-name" content="Núvem de Links"/>
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

        .link-view-wrapper {
            background: #0c0c0c;
        }

        .link-view-container {
            display: block;
            width: 100%;
        }

        .header {
            position: relative;
        }

        .link-container {
            background: #FFFFFF;
            padding: 20px;
            border-radius: 5px;
            position: relative;
            display: flex;
            flex-direction: column;
            -webkit-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.75);
            -moz-box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.75);
            box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.75);
            transition: all .4s;
        }

        .link-container:not(:first-child) {
            margin-top: 20px;
        }

        .personal-image {
            background: url('<?=$static->load("leonardoscapinello-small-linkview.png")?>');
            width: 191px;
            height: 158px;
            position: absolute;
            right: 0;
            top: -40px;
        }

        .link-container:hover {
            cursor: pointer;
            background: #f0f0f0;
        }

        .link-container .link-column {
            width: calc(100% - 40px);
            flex-shrink: 0;
        }

        .link-container .link-column-small {
            display: inline-flex;
            width: 40px;
            align-self: stretch;
            position: relative;
        }


        .link-container:hover .link-column-small i {
            font-size: 1.1em;
        }


        .link-container .link-column-small i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: all .4s;
        }

        .link-container .link-column .link-title {
            font-weight: 700;
            font-size: 1.1em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            -webkit-text-stroke: 0.45px rgba(0, 0, 0, 0.1);
            text-shadow: #fff 0 1px 1px;
        }

        .link-container .link-column .link-url {
            overflow: hidden;
            font-weight: 600;
            font-size: .7em;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            -webkit-text-stroke: 0.45px rgba(0, 0, 0, 0.1);
            text-shadow: #fff 0 1px 1px;
            color: rgba(0, 0, 0, .25);
            width: calc(100% - 30px);
            white-space: nowrap;
            text-overflow: ellipsis;
            margin: 5px 0;
        }

        .company {
            margin: 60px 0;
        }

        ul.tags_vi {
            display: block;
            margin: 8px 0 0 0;
            text-align: left !important;
        }

        ul.tags_vi li {
            display: inline-block;
            font-size: .7em;
            font-weight: 700;
            margin: 0 6px 0 0 !important;
        }


        .tag {
            border-radius: 5px;
            padding: 3px 7px;
            background: #F7F7F8;
            color: #000;
        }

        .tag.green {
            background: #daffcc;
            color: #30b300;
        }

        .tag.blue {
            background: #ccf2ff;
            color: #0086b3;
        }

        .tag.purple {
            background: #e4d2f9;
            color: #5e16b6;
        }

        .tag.pink {
            background: #fccfe9;
            color: #c20a75;
        }

        .locked {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, .5);
            z-index: 9999;
            cursor: default;
        }

        .locked i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #ffffff;
            font-size: 30px;
            text-shadow: rgba(0, 0, 0, .1) 0 1px 1px;
        }

        .locked ~ .row {
            filter: grayscale(100%);
        }

        a {
            color: inherit !important;
        }

    </style>
    <?= $static->load("stylesheet.min.css"); ?>
    <?php /* $social->getGoogleAnalyticsScript_Head(); ?>
    <?= $social->getFacebookPixel_Head("website"); */ ?>
</head>
<body class="link-view-wrapper">
<div id="wrapper">
    <div>
        <div class="container">
            <div class="row">
                <div class="offset-4"></div>
                <div class="col-xl-4 col-lg-4 col-sm-12">

                    <div class="header">
                        <a href="<?= SERVER_ADDRESS ?>">
                            <div class="company">
                                <img src="<?= $static->load("leonardo-scapinello-white-background.svg") ?>"/>
                            </div>
                        </a>
                        <div class="personal-image"></div>
                    </div>

                    <div class="link-view-container">
                        <?php for ($i = 0;
                                   $i < count($links_list);
                                   $i++) {
                            $locked = $links_list[$i]['locked'];

                            $go = "";
                            if (!$locked) {
                                $go = "onClick=\"go('" . $links_list[$i]['url'] . "');return false;\"";
                            }

                            ?>
                            <div class="link-container" <?= $go ?>>
                                <?php if ($locked) { ?>
                                    <div class="locked">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                <?php } ?>
                                <div class="row">
                                    <div class="link-column">
                                        <div class="link-title"><?= $links_list[$i]['title'] ?></div>
                                        <div class="link-url">
                                            <?php if (!$locked) { ?>
                                                <?= $links_list[$i]['url'] ?>
                                            <?php } else { ?>
                                                conteúdo bloqueado
                                            <?php } ?>
                                        </div>
                                        <ul class="tags_vi">
                                            <?php
                                            $tags = $links_list[$i]['tags'];
                                            for ($x = 0; $x < count($tags); $x++) { ?>
                                                <li class="tag <?= $tags[$x]['color'] ?>"><?= $tags[$x]['text'] ?></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="link-column-small">
                                        <i class="<?= $links_list[$i]['icon'] ?>"></i>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <div class="offset-4"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function go(url) {
        window.location.href = url;
    }
</script>
</body>
</html>
