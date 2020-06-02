<?php
require_once("../../../src/properties/index.php");
$less = new lessc;
$less->compileFile(DIRNAME . "../../public/less/series.less", DIRNAME . "../../public/stylesheet/ls.series.css");
$static->add(DIRNAME . "../../public/stylesheet/reset.css");
$static->add(DIRNAME . "../../public/stylesheet/container.css");
$static->add(DIRNAME . "../../public/stylesheet/ls.series.css");
$static->add(DIRNAME . "../../public/stylesheet/tooltip.css");
$static->add(DIRNAME . "../../public/stylesheet/bootoast.css");
$static->add(DIRNAME . "../../public/stylesheet/owl.carousel.css");
$static->add(DIRNAME . "../../public/stylesheet/owl.theme.default.css");
$static->add(DIRNAME . "../../public/stylesheet/switch.css");
$static->add(DIRNAME . "../../public/fonts/gilroy/Gilroy.css");
$static->add(DIRNAME . "../../public/fonts/imperial/imperial.css");
$static->add(DIRNAME . "../../public/stylesheet/fontawesome.all.min.css");
$static->setOutputPath(DIRNAME . "../../public/stylesheet/");
$static->replace("../images/", "../../public/images/");
$static->replace("../fonts/", "../../public/fonts/");
$static->minifyStyleSheet("ls.series");

$ct_main = get_request("ct_main");


?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?= $static->load("ls.series.min.css") ?>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
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


<?= $static->load("jquery.min.js"); ?>
<?= $static->load("owl.carousel.min.js"); ?>
<?= $static->load("jquery.mask.min.js"); ?>
<?= $static->load("jquery.withinviewport.js"); ?>
<?= $static->load("withinviewport.js"); ?>
<?= $static->load("leonardoscapinello.js"); ?>
<?= $static->load("lseries.js"); ?>
</body>
</html>
