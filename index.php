<?php
require_once("./src/properties/index.php");

$less = new lessc;
$less->compileFile(DIRNAME . "../../public/less/stylesheet.less", DIRNAME . "../../public/stylesheet/stylesheet.css");
$static->add(DIRNAME . "../../public/stylesheet/reset.css");
$static->add(DIRNAME . "../../public/stylesheet/container.css");
$static->add(DIRNAME . "../../public/stylesheet/stylesheet.css");
$static->add(DIRNAME . "../../public/stylesheet/owl.carousel.css");
$static->add(DIRNAME . "../../public/stylesheet/owl.theme.default.css");
$static->add(DIRNAME . "../../public/stylesheet/switch.css");
$static->add(DIRNAME . "../../public/fonts/gilroy/Gilroy.css");
$static->add(DIRNAME . "../../public/stylesheet/fontawesome.all.min.css");
$static->setOutputPath(DIRNAME . "../../public/stylesheet/");
$static->replace("../images/", DEPLOY_SERVER . "public/images/");
$static->replace("../fonts/", DEPLOY_SERVER . "public/fonts/");
$static->minifyStyleSheet("stylesheet");

$category_url = $contents->getCategoryUrl();
$semantic_url = $contents->getSemanticRequest();
if (notempty($contents->getIdAuthor())) {
    $author = new Accounts($contents->getIdAuthor());
} else {
    $author = new Accounts(1);
}
$content_private_level = $contents->getPrivateLevel();
$contentsViews = new ContentsViews();
$contentsViews->add();

// INITIALIZE SOCIAL METRIC
$social->googleAnalytics();
$social->facebook();
$social->linkedIn();
$social->activeCampaign();
$social->mailChimp();

?>
<!doctype html>
<html lang="br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=5.0, minimum-scale=1.0">
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
    <?= $social->getHeadTags(); ?>
</head>
<body class="<?= $license->isPremium() ? "premium" : "default" ?>">
<div id="wrapper">

    <div class="ld-container">
        <div class="loader loader-9"></div>
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACcAAAAnCAYAAACMo1E1AAABSElEQVRYhe3Wu0olQRDG8Z/iDREXAxPByEAEAxEFAx9iwcAH2NRYBBMTUSNjn8FAMTYzEDRQBGGDDTYQAxfBSLzghYEWegfPgRlaj2D/oWBquqvqo2uqGZlMJpPJfG96sYxzPOIl2FLdU+lIdJwD2MdkyvbUEbeJ8cj/ia3UwtQUN4XZyB/CXOQXLT3EQ/D/fqa4MsUptkf+PHYS5P0vaaocPQly1uYgmsTCxvAc+bfYwMhXEPcDe6V3L0Fw8e39QlcrxQ3i6B2Bb/YH060SV9CJBZw1EHiF/laJi5nAOq5Lexe/grg3inZfRnt3qxRKcZU04x8uovXuKsEpLuEV3Ifnu+APhymdKQ3C7wT1mlJua2w3IXC2wdVSaWI/uq0xqziuEpDql6kZJ1jDdtXAthrFRtHXYO0Jp2F9JAzDdY0amUwmk8k0Aq8NKmK71NtPuQAAAABJRU5ErkJggg==">
    </div>

    <div class="fp-loader-dsb" style="display:none;">
        <div class="loader-center">
            <img style="width:40px;"
                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAABN2lDQ1BBZG9iZSBSR0IgKDE5OTgpAAAokZWPv0rDUBSHvxtFxaFWCOLgcCdRUGzVwYxJW4ogWKtDkq1JQ5ViEm6uf/oQjm4dXNx9AidHwUHxCXwDxamDQ4QMBYvf9J3fORzOAaNi152GUYbzWKt205Gu58vZF2aYAoBOmKV2q3UAECdxxBjf7wiA10277jTG+38yH6ZKAyNguxtlIYgK0L/SqQYxBMygn2oQD4CpTto1EE9AqZf7G1AKcv8ASsr1fBBfgNlzPR+MOcAMcl8BTB1da4Bakg7UWe9Uy6plWdLuJkEkjweZjs4zuR+HiUoT1dFRF8jvA2AxH2w3HblWtay99X/+PRHX82Vun0cIQCw9F1lBeKEuf1UYO5PrYsdwGQ7vYXpUZLs3cLcBC7dFtlqF8hY8Dn8AwMZP/fNTP8gAAAAJcEhZcwAACxMAAAsTAQCanBgAAAXIaVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzE0OCA3OS4xNjQwMzYsIDIwMTkvMDgvMTMtMDE6MDY6NTcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCAyMS4wIChXaW5kb3dzKSIgeG1wOkNyZWF0ZURhdGU9IjIwMjAtMDQtMjNUMTU6Mzk6MjEtMDM6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMjAtMDQtMjNUMTU6Mzk6MjEtMDM6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDIwLTA0LTIzVDE1OjM5OjIxLTAzOjAwIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc5MzNlN2NiLTMwNTQtY2Q0ZC1iNzY0LWRlMDU1NWZjM2VlYyIgeG1wTU06RG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjAyMGUxN2QxLTYwNmYtNTA0Ni05ZWU4LWM3NmYyYzM4OWI4MCIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOmY5Y2IxYjM2LTJkMzItY2M0NS1iNWVkLWE0MzEyMDA2OTU1NSIgZGM6Zm9ybWF0PSJpbWFnZS9wbmciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmY5Y2IxYjM2LTJkMzItY2M0NS1iNWVkLWE0MzEyMDA2OTU1NSIgc3RFdnQ6d2hlbj0iMjAyMC0wNC0yM1QxNTozOToyMS0wMzowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIDIxLjAgKFdpbmRvd3MpIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo3OTMzZTdjYi0zMDU0LWNkNGQtYjc2NC1kZTA1NTVmYzNlZWMiIHN0RXZ0OndoZW49IjIwMjAtMDQtMjNUMTU6Mzk6MjEtMDM6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCAyMS4wIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz777X2mAAAFB0lEQVR4nN2bXUikVRzGf/OBm9uQQc60xRSyMKx1UeKwGGprkUjuZa7Quph5I3mrYO6NQxBBECyomK1EQTEVuKAjE5UXu6BSO6FFbNaaluPC6ixzYezk5+rbxXHS+dL5OOedNx94kDm+c87/eea8Z8783/8xoR6ngQrgWeAM4AIeBx4BHt675u893gV+B+aAW8AEsKpDjFJhAs4BV4E7gJYDHwA3gXeBUj1FZINTwDtAkNxEH8abwFvASZ00pQUn8CGwgTrh8bwHvA0U6qAvJR4CPMAa+gmPZxB4XbXQZHgBsVjlS3g8vwaeVKp4DybgMrCto7h0GQbOq5MupvywAYQexh2gS4X4R4EbBhCYLq8gZqsUFAE/GUBUpvxUhgkngSkDiMmWH+Qi3gKMGkBEruzO1oD3DBC8DD4AXs1U/CvArgGCl8UVxFY9LdiAJQMELZsj6RrwvgGCVcULR4l/BtgyQKCq+CdiQ5cSXxkgSNVsTyX+DGIrme8AVfMvwBoVbT5gQFfc6+OKEuBifKMNiKDjJ2G1WrXm5mbN7/droVBIi0dTU5PK8W9EhUenwmvsJyiVo6SkhOHhYdxut15DxuMcYiYsRqd8k14jO51OJiYm8ikexI+kJhAz4ATCEWkYHx9PaOvt7WVsbIyhoSGcTqfM4bLFecR2n5eQfI8lQ3t7u+Z2u5P+LxkUrwEaIqtlswIvy7Y2Ferr6xPaNjY26OvrY35+PqY9EAioDscKVFgRT2x0QWlp4rONzs5OBgYG9AohHs+bERsgXWCz2RLaFhYW9Bo+GUrNiGd1uiAcDie09fT0JDVGJ5w2c8SPA5mYnp5OaKusrGR2dpaOjg4cDodeoURxChSssKm+BRwOhxaJRFKu/FtbW9rIyIjW0NCgFRQU6LEjDepqAKB1dXWl9TW4uLiotbW1aRaLRaUBq7obYDKZNI/Ho+3u7qZlxOTkpGa324+PAVHW1NRogUAgLROmpqY0s9mswoA7eTMgyqqqKq2/v19bWVk51ITGxkYVBvwGClJgmRgQpcVi0erq6jS/35/09hgdHVVhwHWAWSMYcJCXLl1KeP/y8rIKAz4xA39gMHi9XiKRSExbcXGxiqFum4FfVfScC1wuF4WFsdUv6+vrKob62YooRbusoveDqK6uZmdnJ6YtEong9XoBKCsro7y8HJfLRWtrKxaLJebaubk52SHtAgEQ+UCpC2G6CAaD/72nu7v70Gs9Ho/s+38aRBY4gig/MyxWV1cZHByU3e03sJ8Gvya7d1nY3t6mpaWFUCgku+trsG/Al4jHyIbC0tIStbW1+Hw+2V3fAmZgPy2+AvgQ6fG8YW1tjXA4zMzMDD6fD6/Xy+bmpoqhriZrPIv8jYYReY8DpbYHH4X9CHybln//b1xBVLcmRQXHqzIk2adfdJRDHxsgUFVsO0o8gB1RdprvYGVzkgyefl80QMAyeZ8sst/H6VZ4I1PxIA4j/GCA4HNlXzbio7BjrHMBmfILRMVrTnCi9hyQKn4HFOQqPoqnEQnEfItKl8OIugepeAz43gDijuIgEqZ9KpwAPjKAyGTc4JAaQNm4gLE2S78AzylVnAR2xF4hn8WV9xH5TGmLXTY4i0gv6Sl8E3GvP6GDvrThBj5D7UHKu4hq9qd00pQVbMCbiFnxD7mLDgGfI8rapK/u0o6WpUABIsfwIrHH54tSXL8C3Gb/+Pz1vb+aqgD/BSEbl23YzJIbAAAAAElFTkSuQmCC"
                 alt="Leonardo Scapinello"/>
            <p>Só um instante...</p>
        </div>
    </div>
    <?php if (notempty($semantic_url) && notempty($contents->getContentType())) { ?>

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
            <?php require_once("./src/components/series/featured.php") ?>
            <?php require_once("./src/components/landing/newsletter.php") ?>
        </div>
        <?php require_once("./src/components/footer.php") ?>
    <?php } ?>
</div>

<!--
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;800&display=swap" rel="stylesheet">
-->
<?= $static->printCSS("stylesheet.min.css"); ?>
<?= $social->getBodyTags() ?>
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
<?= $static->load("jquery.min.js"); ?>
<?= $static->load("owl.carousel.min.js"); ?>
<?= $static->load("jquery.mask.min.js"); ?>
<?php
if ($contents->getContentType() === "blog") {
    echo $static->load("infinite-scroll.pkgd.min.js");
} ?>
<?= $static->load("leonardoscapinello.js"); ?>
<?= $static->load("leonardoscapinello.scroll.js"); ?>
<script type="text/javascript">

    $(window).on("load", function () {
        $(".ld-container").fadeOut(200);
    });

    $(window).bind("beforeunload", function () {
        $(".ld-container").fadeIn(200);
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
