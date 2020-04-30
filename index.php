<?php
require_once("./src/properties/index.php");
$category_url = $contents->getCategoryUrl();
$semantic_url = $contents->getSemanticRequest();
if (notempty($contents->getIdAuthor())) {
    $author = new Accounts($contents->getIdAuthor());
} else {
    $author = new Accounts(1);
}
$content_private_level = $contents->getPrivateLevel();
$user_can_view = $license->userCanAccessByPrivateLevel($content_private_level);

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $contents->getTitle() ?> - <?= PAGE_TITLE ?></title>
    <meta name="description" content="<?= $contents->getDescription() ?>"/>
    <meta name="subject" content="<?= $contents->getTitle() ?>">
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
    <meta name="og:title" content="<?= $contents->getTitle() ?> - <?= PAGE_TITLE ?>"/>
    <meta name="og:type" content="article"/>
    <meta name="og:url" content="<?= $url->getActualURL() ?>"/>
    <meta name="og:image" content="<?= $contents->getCoverImage() ?>"/>
    <meta name="og:site_name" content="Leonardo Scapinello"/>
    <meta name="og:description" content="<?= $contents->getDescription() ?>"/>
    <meta name="og:email" content="leonardo@flexwei.com"/>
    <meta name="google-analytics" content="<?= $social->getGoogleAnalytics() ?>"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="yes" name="apple-touch-fullscreen"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <meta name="application-name" content="<?= $contents->getTitle() ?>"/>
    <meta name="msapplication-tooltip" content="<?= PAGE_TITLE ?>"/>
    <link rel="shortcut icon" href="<?= SERVER_ADDRESS ?>favicon.ico"/>
</head>
<body>
<div id="wrapper">


    <?php if ($semantic_url) { ?>

        <?php require_once("./src/components/header.php") ?>
        <div class="inner-ctn ctn--<?= $contents->getContentType() ?>">
            <?php
            if ($contents->getContentType() === "blog") {
                require_once("./src/components/blog/blog-content.php");
            } elseif ($contents->getContentType() === "page") {
                require_once("./src/components/pages/page-content.php");
            }
            ?>
        </div>
        <?php require_once("./src/components/footer.php") ?>

    <?php } else { ?>
        <?php require_once("./src/components/landing/header-featured.php") ?>
        <div id="ini-content">
            <?php require_once("./src/components/landing/latest-release.php") ?>
            <?php require_once("./src/components/blog/blog-posts-by-category-01.php") ?>
            <?php require_once("./src/components/blog/blog-posts-by-category-02.php") ?>
            <?php require_once("./src/components/landing/newsletter.php") ?>
        </div>
        <?php require_once("./src/components/footer.php") ?>
    <?php } ?>
</div>


<?php if (notempty($contents->getSemanticUrl())) { ?>
    <script type="text/javascript">
        function getSemanticURL() {
            return "<?=$contents->getSemanticUrl()?>"
        }

        function getIdContent() {
            return "<?=$contents->getIdContent()?>"
        }
    </script>
<?php } ?>


<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;800&display=swap" rel="stylesheet">
<?= $static->load("gilroy/Gilroy.ttf"); ?>
<?= $static->load("imperial/imperial.ttf"); ?>
<?= $static->load("stylesheet.min.css"); ?>
<?= $static->load("owl.carousel.css"); ?>
<?= $static->load("owl.theme.default.css"); ?>
<?= $static->load("owl.carousel.css"); ?>
<?= $static->load("owl.theme.default.css"); ?>
<?= $static->load("jquery.min.js"); ?>
<?= $static->load("owl.carousel.min.js"); ?>
<?= $static->load("jquery.mask.min.js"); ?>
<?= $static->load("infinite-scroll.pkgd.min.js"); ?>
<?= $static->load("leonardoscapinello.js"); ?>
<?= $static->load("leonardoscapinello.scroll.js"); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".loader-container").delay(1000).fadeOut(300);
    });
    const path = document.querySelector('#wave');
    const animation = document.querySelector('#moveTheWave');
    const m = 0.512286623256592433;

    function buildWave(w, h) {

        const a = h / 4;
        const y = h / 2;

        const pathData = [
            'M', w * 0, y + a / 2,
            'c',
            a * m, 0,
            -(1 - a) * m, -a,
            a, -a,
            's',
            -(1 - a) * m, a,
            a, a,
            's',
            -(1 - a) * m, -a,
            a, -a,
            's',
            -(1 - a) * m, a,
            a, a,
            's',
            -(1 - a) * m, -a,
            a, -a,

            's',
            -(1 - a) * m, a,
            a, a,
            's',
            -(1 - a) * m, -a,
            a, -a,
            's',
            -(1 - a) * m, a,
            a, a,
            's',
            -(1 - a) * m, -a,
            a, -a,
            's',
            -(1 - a) * m, a,
            a, a,
            's',
            -(1 - a) * m, -a,
            a, -a,
            's',
            -(1 - a) * m, a,
            a, a,
            's',
            -(1 - a) * m, -a,
            a, -a,
            's',
            -(1 - a) * m, a,
            a, a,
            's',
            -(1 - a) * m, -a,
            a, -a
        ].join(' ');

        if (path !== null && path !== undefined) {
            path.setAttribute('d', pathData);
        }
    }

    buildWave(50, 55);

</script>
</body>
</html>
