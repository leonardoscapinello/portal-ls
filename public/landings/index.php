<?php require_once("../../src/properties/index.php");
$landing = new Landing();
$license = new AccountsLicense();

// INITIALIZE SOCIAL METRIC
$social->googleAnalytics();
$social->facebook();
$social->linkedIn();
$social->activeCampaign();
$social->mailChimp();

$expired = (date("Y-m-d H:i:s") > $landing->getExpireDate());

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $landing->getTitle() ?> - <?= PAGE_TITLE ?></title>
    <meta name="description" content="<?= $landing->getDescription() ?>"/>
    <meta name="subject" content="<?= $landing->getTitle() ?>">
    <meta name="copyright" content="Leonardo Scapinello">
    <meta name="language" content="pt-BR">
    <meta name="robots" content="index,follow"/>
    <meta name="Classification" content="educacional, escola, school">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global"/>
    <meta name="rating" content="General"/>
    <meta name="url" content="<?= $url->getActualURL() ?>">
    <meta name="identifier-URL" content="<?= $url->getActualURL() ?>">
    <meta name="og:title" content="<?= $landing->getTitle() ?> - <?= PAGE_TITLE ?>"/>
    <meta name="og:type" content="article"/>
    <meta name="og:url" content="<?= $url->getActualURL() ?>"/>
    <meta name="og:site_name" content="Leonardo Scapinello"/>
    <meta name="og:description" content="<?= $landing->getDescription() ?>"/>
    <meta name="og:email" content="leonardo@flexwei.com"/>
    <meta name="google-analytics" content="<?= $social->getGoogleAnalytics() ?>"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="yes" name="apple-touch-fullscreen"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="application-name" content="<?= $landing->getTitle() ?>"/>
    <meta name="msapplication-tooltip" content="<?= PAGE_TITLE ?>"/>
    <link rel="shortcut icon" href="<?= SERVER_ADDRESS ?>favicon.ico"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;800&display=swap" rel="stylesheet">
    <?= $static->load("gilroy/Gilroy.ttf"); ?>
    <link href="<?= LAUNCH_ADDRESS ?>stylesheet/ls.default.css" type="text/css" rel="stylesheet">
    <?= $social->getHeadTags(); ?>
    <?= $static->printCSS("aos.css") ?>
    <?= $static->printCSS("container.css") ?>
    <?= $landing->loadGlobalAsset("ls.default.css") ?>
    <?= $landing->loadAsset("skin.css") ?>
    <?php /*$social->getGoogleAnalyticsScript_Head(); ?>
    <?= //$social->getFacebookPixel_Head("website");*/ ?>
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
            box-shadow: 5px -3px 0 rgba(44, 195, 107, 1),
            5px 5px 0 rgba(44, 195, 107, 0.5),
            -3px 5px 0 rgba(44, 195, 107, 0.3),
            -5px -5px 0 rgba(44, 195, 107, 0.1);
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

        body.premium #wrapper .ld-container {
            background: #0D1633 !important;
        }

        body.premium #wrapper .ld-container:after {
            content: "PREMIUM";
            color: rgba(195, 151, 63, 1);
            position: absolute;
            top: calc(50% + 50px);
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 4px;
        }


        body.premium #wrapper .ld-container .loader-9:before {
            width: 90%;
            height: 90%;
            top: 10%;
            left: 10%;
            box-shadow: 5px -3px 0 rgba(195, 151, 63, 1),
            5px 5px 0 rgba(195, 151, 63, 0.5),
            -3px 5px 0 rgba(195, 151, 63, 0.3),
            -5px -5px 0 rgba(195, 151, 63, 0.1) !important;
        }

    </style>
    <?= $static->printCSS("global.css") ?>

</head>
<body class="<?= $license->isPremium() ? "premium" : "default" ?>">
<div id="skrollr-body">
    <div id="wrapper">

        <?php if ($expired) { ?>
            <div class="fm-dialog-overlay"></div>
            <div class="fm-dialog confirmation-dialog" id="msgDialog">
                <div class="fm-dialog-header">
                    <div class="fm-dialog-title"><span>Oferta Encerrada</span></div>
                    <div class="fm-dialog-close hidden"></div>
                    <div class="clear"></div>
                </div>
                <div class="fm-notification-body">
                    <div class="fm-notification-info">
                        <p>Agradecemos seu interesse nessa oferta, mas não está mais disponível. Faça parte do <b>Canal
                                no
                                Telegram</b> para receber em primeira mão quando essa oferta estiver disponível.</p>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="fm-notifications-bottom grey-bg">
                    <a href="<?= TELEGRAM_CHANNEL ?>" class="button default-green-button semi-big right confirm"><span>Entrar no Telegram</span></a>
                    <a href="<?= SERVER_ADDRESS ?>" class="button default-white-button semi-big right cancel"><span>Fechar</span></a>
                    <div class="clear"></div>
                </div>
            </div>
        <?php } ?>

        <div class="ld-container">
            <div class="loader loader-9"></div>
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACcAAAAnCAYAAACMo1E1AAABSElEQVRYhe3Wu0olQRDG8Z/iDREXAxPByEAEAxEFAx9iwcAH2NRYBBMTUSNjn8FAMTYzEDRQBGGDDTYQAxfBSLzghYEWegfPgRlaj2D/oWBquqvqo2uqGZlMJpPJfG96sYxzPOIl2FLdU+lIdJwD2MdkyvbUEbeJ8cj/ia3UwtQUN4XZyB/CXOQXLT3EQ/D/fqa4MsUptkf+PHYS5P0vaaocPQly1uYgmsTCxvAc+bfYwMhXEPcDe6V3L0Fw8e39QlcrxQ3i6B2Bb/YH060SV9CJBZw1EHiF/laJi5nAOq5Lexe/grg3inZfRnt3qxRKcZU04x8uovXuKsEpLuEV3Ifnu+APhymdKQ3C7wT1mlJua2w3IXC2wdVSaWI/uq0xqziuEpDql6kZJ1jDdtXAthrFRtHXYO0Jp2F9JAzDdY0amUwmk8k0Aq8NKmK71NtPuQAAAABJRU5ErkJggg==">
        </div>
        <?php if ($license->userCanAccessAllBooks()) { ?>
            <div class="premium-modal">
                <div class="dialog">
                    <div class="row no-gutters">
                        <div class="col-xl-1 col-lg-1 col-sm-12">
                            <div class="premium-brand">
                                <img src="<?= $static->image("leonardo-scapinello-white-background.svg"); ?>">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-sm-12">
                            <h5>Opa, <?= $account->getFirstName() ?>.</h5>
                            <p>Você é Premium no Portal LS, portanto tem acesso gratuito a esse material, assim como
                                diversos outros lançamentos.</p>
                        </div>
                        <div class="offset-3"></div>
                        <div class="col-xl-2 col-lg-2 col-sm-12" style="text-align: right">
                            <a href="<?= PROFILE_ADDRESS ?>#downloads" class="premium-btn">Acessar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


        <a href="<?= SERVER_ADDRESS ?>?utm_source=<?= $landing->getSemanticUrl() ?>&utm_medium=popup-ls">
            <div class="popup-ls">
                <img src="<?= $static->image("leonardo-scapinello-white-background.svg"); ?>">
            </div>
        </a>

        <?php if ($session->isLogged()) { ?>
            <div class="profile-widget">
                <span id="firstName" style="display: none"><?= $account->getFirstName() ?></span>
                <span id="lastName" style="display: none"><?= $account->getLastName() ?></span>
                <div class="image">
                    <div id="profileImage"></div>
                </div>
                <div class="personal-info">
                    <span>Seja bem-vindo(a) de volta</span>
                    <b id="name"><?= $account->getFirstName() ?></b>
                </div>
            </div>
        <?php } ?>


        <?php
        $lp_content = $landing->getContentFile();
        if ($lp_content !== null) {
            require_once($lp_content);
        }
        ?>

        <?php
        require_once("../../src/components/footer.php")
        ?>

    </div>
</div>

<?= $social->getBodyTags(); ?>
<?= $static->load("fontawesome.all.min.css"); ?>
<?= $static->load("jquery.min.js"); ?>
<?= $static->load("jquery.mask.min.js"); ?>
<?= $static->load("ScrollMagic.min.js"); ?>
<?= $static->load("skrollr.min.js"); ?>
<?php /*$social->getFacebookTrack_Body(); ?>
<?= //$social->getMailChimpStatic_Body();*/ ?>
<script type="text/javascript">
    $(document).ready(function () {
        var firstName = $('#firstName').text();
        var lastName = $('#lastName').text();
        var intials = firstName.charAt(0) + lastName.charAt(0);
        var profileImage = $('#profileImage').text(intials);
        $(".profile-widget").delay(1000).slideDown(300).delay(3000).slideUp(300);
    });
</script>

<!--[if lt IE 9]>
<?= $static->load("skrollr.ie.min.js"); ?>
<![endif]-->
<script type="text/javascript">


    $(window).on("load", function () {
        $(".ld-container").fadeOut(200);
    });

    $(window).bind("beforeunload", function () {
        $(".ld-container").fadeIn(200);
    });

    $('#phone').mask('(00) 00000-0000');

    var promise = document.querySelector('video').play();

    if (promise !== undefined) {
        promise.catch(error => {
            /* Auto-play was prevented
            // Show a UI element to let the user manually start playback */
        }).then(() => {
            /* Auto-play started */
        });
    }


    if (!(/Android|iPhone|iPad|iPod|BlackBerry|Windows Phone/i).test(navigator.userAgent || navigator.vendor || window.opera)) {
        skrollr.init({
            forceHeight: false
        });
    }

    $(window).scroll(function () {
        let scr = $(window).scrollTop();
        let whg = $(document).outerHeight();
        console.log(scr + "/" + whg);
        if (scr > (whg * 0.7)) {
            $(".premium-modal").fadeIn(300, function () {
                $(".premium-modal .dialog").slideDown(500);
            });
        } else {
            $(".premium-modal .dialog").slideUp(300, function () {
                $(".premium-modal").fadeOut(500);
            });
        }
    });
</script>
</body>
</html>
