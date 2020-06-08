<?php require_once("../../src/properties/index.php");
$landing = new Landing();
$license = new AccountsLicense();
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
    <?= $social->getGoogleTagManagerScript_Head(); ?>
    <?= $static->load("aos.css") ?>
    <?= $static->load("container.css") ?>
    <?= $landing->loadGlobalAsset("ls.default.css") ?>
    <?= $landing->loadAsset("skin.css") ?>
    <?php /*$social->getGoogleAnalyticsScript_Head(); ?>
    <?= //$social->getFacebookPixel_Head("website");*/ ?>
</head>
<body>
<div id="skrollr-body">
    <div id="wrapper">

        <?php if ($license->userCanAccessAllBooks()) { ?>
            <div class="premium-modal">
                <div class="dialog">
                    <div class="row no-gutters">
                        <div class="col-xl-1 col-lg-1 col-sm-12">
                            <div class="premium-brand">
                                <img src="<?= $static->load("leonardo-scapinello-white-background.svg"); ?>">
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
                <img src="<?= $static->load("leonardo-scapinello-white-background.svg"); ?>">
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


<?= $static->load("owl.carousel.css"); ?>
<?= $static->load("owl.theme.default.css"); ?>
<?= $static->load("fontawesome.all.min.css"); ?>
<?= $static->load("jquery.min.js"); ?>
<?= $static->load("owl.carousel.min.js"); ?>
<?= $static->load("jquery.mask.min.js"); ?>
<?= $static->load("infinite-scroll.pkgd.min.js"); ?>
<?= $static->load("ScrollMagic.min.js"); ?>
<?= $static->load("skrollr.min.js"); ?>
<?= $static->load("leonardoscapinello.js"); ?>
<?= $social->getGoogleTagManagerScript_Body(); ?>
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