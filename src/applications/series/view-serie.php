<?php
$series = new Series();
$serie_url = get_request("serie_url");
$season_short_key = get_request("season_short_key");
if (!notempty($serie_url) || !notempty($season_short_key)) {
    header("location: " . SERVER_ADDRESS . "series");
    die;
}
$loaded = $series->loadSeasonFromSerieURL($serie_url, $season_short_key);
if (!$loaded) {
    header("location: " . SERVER_ADDRESS . "series");
    die;
}
require_once(DIRNAME . "../components/series/view-serie/header.php");
require_once(DIRNAME . "../components/series/view-serie/seasons.php");