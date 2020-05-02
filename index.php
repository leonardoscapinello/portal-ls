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
    <?= $static->load("stylesheet.min.css"); ?>

</head>
<body>
<div id="wrapper">

    <div class="fp-loader">
        <div class="loader-center">
            <img style="width:40px;"
                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAABN2lDQ1BBZG9iZSBSR0IgKDE5OTgpAAAokZWPv0rDUBSHvxtFxaFWCOLgcCdRUGzVwYxJW4ogWKtDkq1JQ5ViEm6uf/oQjm4dXNx9AidHwUHxCXwDxamDQ4QMBYvf9J3fORzOAaNi152GUYbzWKt205Gu58vZF2aYAoBOmKV2q3UAECdxxBjf7wiA10277jTG+38yH6ZKAyNguxtlIYgK0L/SqQYxBMygn2oQD4CpTto1EE9AqZf7G1AKcv8ASsr1fBBfgNlzPR+MOcAMcl8BTB1da4Bakg7UWe9Uy6plWdLuJkEkjweZjs4zuR+HiUoT1dFRF8jvA2AxH2w3HblWtay99X/+PRHX82Vun0cIQCw9F1lBeKEuf1UYO5PrYsdwGQ7vYXpUZLs3cLcBC7dFtlqF8hY8Dn8AwMZP/fNTP8gAAAAJcEhZcwAACxMAAAsTAQCanBgAAAXIaVRYdFhNTDpjb20uYWRvYmUueG1wAAAAAAA8P3hwYWNrZXQgYmVnaW49Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjYtYzE0OCA3OS4xNjQwMzYsIDIwMTkvMDgvMTMtMDE6MDY6NTcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCAyMS4wIChXaW5kb3dzKSIgeG1wOkNyZWF0ZURhdGU9IjIwMjAtMDQtMjNUMTU6Mzk6MjEtMDM6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMjAtMDQtMjNUMTU6Mzk6MjEtMDM6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDIwLTA0LTIzVDE1OjM5OjIxLTAzOjAwIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjc5MzNlN2NiLTMwNTQtY2Q0ZC1iNzY0LWRlMDU1NWZjM2VlYyIgeG1wTU06RG9jdW1lbnRJRD0iYWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjAyMGUxN2QxLTYwNmYtNTA0Ni05ZWU4LWM3NmYyYzM4OWI4MCIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOmY5Y2IxYjM2LTJkMzItY2M0NS1iNWVkLWE0MzEyMDA2OTU1NSIgZGM6Zm9ybWF0PSJpbWFnZS9wbmciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmY5Y2IxYjM2LTJkMzItY2M0NS1iNWVkLWE0MzEyMDA2OTU1NSIgc3RFdnQ6d2hlbj0iMjAyMC0wNC0yM1QxNTozOToyMS0wMzowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIDIxLjAgKFdpbmRvd3MpIi8+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJzYXZlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo3OTMzZTdjYi0zMDU0LWNkNGQtYjc2NC1kZTA1NTVmYzNlZWMiIHN0RXZ0OndoZW49IjIwMjAtMDQtMjNUMTU6Mzk6MjEtMDM6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCAyMS4wIChXaW5kb3dzKSIgc3RFdnQ6Y2hhbmdlZD0iLyIvPiA8L3JkZjpTZXE+IDwveG1wTU06SGlzdG9yeT4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz777X2mAAAFB0lEQVR4nN2bXUikVRzGf/OBm9uQQc60xRSyMKx1UeKwGGprkUjuZa7Quph5I3mrYO6NQxBBECyomK1EQTEVuKAjE5UXu6BSO6FFbNaaluPC6ixzYezk5+rbxXHS+dL5OOedNx94kDm+c87/eea8Z8783/8xoR6ngQrgWeAM4AIeBx4BHt675u893gV+B+aAW8AEsKpDjFJhAs4BV4E7gJYDHwA3gXeBUj1FZINTwDtAkNxEH8abwFvASZ00pQUn8CGwgTrh8bwHvA0U6qAvJR4CPMAa+gmPZxB4XbXQZHgBsVjlS3g8vwaeVKp4DybgMrCto7h0GQbOq5MupvywAYQexh2gS4X4R4EbBhCYLq8gZqsUFAE/GUBUpvxUhgkngSkDiMmWH+Qi3gKMGkBEruzO1oD3DBC8DD4AXs1U/CvArgGCl8UVxFY9LdiAJQMELZsj6RrwvgGCVcULR4l/BtgyQKCq+CdiQ5cSXxkgSNVsTyX+DGIrme8AVfMvwBoVbT5gQFfc6+OKEuBifKMNiKDjJ2G1WrXm5mbN7/droVBIi0dTU5PK8W9EhUenwmvsJyiVo6SkhOHhYdxut15DxuMcYiYsRqd8k14jO51OJiYm8ikexI+kJhAz4ATCEWkYHx9PaOvt7WVsbIyhoSGcTqfM4bLFecR2n5eQfI8lQ3t7u+Z2u5P+LxkUrwEaIqtlswIvy7Y2Ferr6xPaNjY26OvrY35+PqY9EAioDscKVFgRT2x0QWlp4rONzs5OBgYG9AohHs+bERsgXWCz2RLaFhYW9Bo+GUrNiGd1uiAcDie09fT0JDVGJ5w2c8SPA5mYnp5OaKusrGR2dpaOjg4cDodeoURxChSssKm+BRwOhxaJRFKu/FtbW9rIyIjW0NCgFRQU6LEjDepqAKB1dXWl9TW4uLiotbW1aRaLRaUBq7obYDKZNI/Ho+3u7qZlxOTkpGa324+PAVHW1NRogUAgLROmpqY0s9mswoA7eTMgyqqqKq2/v19bWVk51ITGxkYVBvwGClJgmRgQpcVi0erq6jS/35/09hgdHVVhwHWAWSMYcJCXLl1KeP/y8rIKAz4xA39gMHi9XiKRSExbcXGxiqFum4FfVfScC1wuF4WFsdUv6+vrKob62YooRbusoveDqK6uZmdnJ6YtEong9XoBKCsro7y8HJfLRWtrKxaLJebaubk52SHtAgEQ+UCpC2G6CAaD/72nu7v70Gs9Ho/s+38aRBY4gig/MyxWV1cZHByU3e03sJ8Gvya7d1nY3t6mpaWFUCgku+trsG/Al4jHyIbC0tIStbW1+Hw+2V3fAmZgPy2+AvgQ6fG8YW1tjXA4zMzMDD6fD6/Xy+bmpoqhriZrPIv8jYYReY8DpbYHH4X9CHybln//b1xBVLcmRQXHqzIk2adfdJRDHxsgUFVsO0o8gB1RdprvYGVzkgyefl80QMAyeZ8sst/H6VZ4I1PxIA4j/GCA4HNlXzbio7BjrHMBmfILRMVrTnCi9hyQKn4HFOQqPoqnEQnEfItKl8OIugepeAz43gDijuIgEqZ9KpwAPjKAyGTc4JAaQNm4gLE2S78AzylVnAR2xF4hn8WV9xH5TGmLXTY4i0gv6Sl8E3GvP6GDvrThBj5D7UHKu4hq9qd00pQVbMCbiFnxD7mLDgGfI8rapK/u0o6WpUABIsfwIrHH54tSXL8C3Gb/+Pz1vb+aqgD/BSEbl23YzJIbAAAAAElFTkSuQmCC"
                 alt="Leonardo Scapinello"/>
            <p>Só um instante...</p>
        </div>
    </div>

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


<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;800&display=swap" rel="stylesheet">
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
<?= $static->load("infinite-scroll.pkgd.min.js"); ?>
<?= $static->load("leonardoscapinello.js"); ?>
<?= $static->load("leonardoscapinello.scroll.js"); ?>
<script type="text/javascript">
    $(window).on("load", function () {
        $(".fp-loader").fadeOut(600, function () {
            $(".loader-container").delay(1000).fadeOut(300);
        });
    });

    $(window).bind('beforeunload unload', function () {
        $(".fp-loader").fadeIn(200);
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
