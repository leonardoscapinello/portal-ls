<?php

class Series
{

    private $id_serie;
    private $serie_name;
    private $serie_description;
    private $serie_banner;
    private $serie_banner_bg;
    private $serie_cover;
    private $semantic_url;
    private $insert_time;
    private $is_active;

    private $main_url = SERVER_ADDRESS . "series/";


    public function getAllSeries()
    {
        global $text;
        $contents = array();
        try {
            $database = new Database();
            $query = "SELECT ss.id_serie_season, ss.id_serie, ss.short_key, ss.season_level, ss.season_title, ss.season_description, ss.season_brand, ss.season_bg, ss.season_cover, ss.season_banner, ss.season_banner_bg, ss.insert_time, ss.launch_date, ss.is_active AS 'season_active', ss.permission_key, sr.serie_name, sr.serie_description, sr.semantic_url AS 'serie_url', sr.is_active AS 'serie_active' FROM series_seasons ss LEFT JOIN series sr ON sr.id_serie = ss.id_serie WHERE (sr.is_active = 'Y' AND ss.is_active = 'Y') AND NOW() >= ss.launch_date";
            $database->query($query);
            $result = $database->resultset();
            if (!empty($result)) {
                return $result;
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return $contents;
    }


    public function getLastSeasonInfoBySerieURL($serie_url)
    {
        global $text;
        try {
            $database = new Database();
            $query = "SELECT ss.id_serie_season, ss.id_serie, ss.short_key, ss.season_level, ss.season_title, ss.season_description, ss.season_brand, ss.season_bg, ss.season_cover, ss.season_banner, ss.season_banner_bg, ss.insert_time, ss.launch_date, ss.is_active AS 'season_active', ss.permission_key, sr.serie_name, sr.serie_description, sr.semantic_url AS 'serie_url', sr.is_active AS 'serie_active' FROM series_seasons ss LEFT JOIN series sr ON sr.id_serie = ss.id_serie WHERE (sr.is_active = 'Y' AND ss.is_active = 'Y')  AND sr.semantic_url = ? ORDER BY ss.season_level DESC LIMIT 1";
            $database->query($query);
            $database->bind(1, $serie_url);
            $result = $database->resultset();
            if (!empty($result)) {
                return $result[0];
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return array();
    }


    public function createUrl(string $serie_url, string $short_key, string $season_title)
    {
        global $url;
        $title = $url->friendly($season_title);
        return $this->main_url . $serie_url;
    }

}