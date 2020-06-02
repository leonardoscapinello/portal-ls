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
    private $id_serie_season;
    private $short_key;
    /* ====================== SEASON */
    private $season_level;
    private $season_title;
    private $season_description;
    private $season_brand;
    private $season_bg;
    private $season_cover;
    private $season_banner;
    private $season_banner_bg;
    private $launch_date;
    private $season_active;
    private $permission_key;
    private $serie_url;
    private $serie_active;
    /* ====================== SERIES CONTENTS RELATION */
    private $id_content;
    private $episode;

    private $main_url = SERVER_ADDRESS . "series/";
    private $exists = false;

    public function getAllSeries()
    {
        global $text;
        $contents = array();
        try {
            $database = new Database();
            $query = "SELECT ss.id_serie_season, ss.id_serie, ss.short_key, MAX(ss.season_level) season_level, ss.season_title, ss.season_description, ss.season_brand, ss.season_bg, ss.season_cover, ss.season_banner, ss.season_banner_bg, ss.insert_time, ss.launch_date, ss.is_active AS 'season_active', ss.permission_key, sr.serie_name, sr.serie_description, sr.semantic_url AS 'serie_url', sr.is_active AS 'serie_active' FROM series_seasons ss LEFT JOIN series sr ON sr.id_serie = ss.id_serie WHERE (sr.is_active = 'Y' AND ss.is_active = 'Y') AND NOW() >= ss.launch_date GROUP BY id_serie";
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

    public function getAllSeasonFromSerie()
    {
        global $text;
        $contents = array();
        try {
            $database = new Database();
            $query = "SELECT ss.id_serie_season, ss.id_serie, ss.short_key, ss.season_level, ss.season_title, ss.season_description, ss.season_brand, ss.season_bg, ss.season_cover, ss.season_banner, ss.season_banner_bg, ss.insert_time, ss.launch_date, ss.is_active AS 'season_active', ss.permission_key, sr.serie_name, sr.serie_description, sr.semantic_url AS 'serie_url', sr.is_active AS 'serie_active' FROM series_seasons ss LEFT JOIN series sr ON sr.id_serie = ss.id_serie WHERE (sr.is_active = 'Y' AND ss.is_active = 'Y') AND NOW() >= ss.launch_date AND sr.semantic_url = ? ORDER BY season_level";
            $database->query($query);
            $database->bind(1, $this->getSerieUrl());
            $result = $database->resultset();
            if (!empty($result)) {
                return $result;
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return $contents;
    }


    public function loadSeasonFromSerieURL($serie_url, $season_short_key)
    {
        global $text;
        try {
            $database = new Database();
            $query = "SELECT ss.id_serie_season, ss.id_serie, ss.short_key, ss.season_level, ss.season_title, ss.season_description, ss.season_brand, ss.season_bg, ss.season_cover, ss.season_banner, ss.season_banner_bg, ss.insert_time, ss.launch_date, ss.is_active AS 'season_active', ss.permission_key, sr.serie_name, sr.serie_description, sr.semantic_url AS 'serie_url', sr.is_active AS 'serie_active' FROM series_seasons ss LEFT JOIN series sr ON sr.id_serie = ss.id_serie WHERE (sr.is_active = 'Y' AND ss.is_active = 'Y')  AND sr.semantic_url = ? AND ss.short_key = ? ORDER BY ss.season_level DESC LIMIT 1";
            $database->query($query);
            $database->bind(1, $serie_url);
            $database->bind(2, $season_short_key);
            $result = $database->resultsetObject();
            if ($result && count(get_object_vars($result)) > 0) {
                $this->exists = true;
                foreach ($result as $key => $value) {
                    $this->$key = $text->utf8($value);
                }
                return true;
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function loadRandomSerie()
    {
        global $text;
        try {
            $database = new Database();
            $query = "SELECT ss.id_serie_season, ss.id_serie, ss.short_key, ss.season_level, ss.season_title, ss.season_description, ss.season_brand, ss.season_bg, ss.season_cover, ss.season_banner, ss.season_banner_bg, ss.insert_time, ss.launch_date, ss.is_active AS 'season_active', ss.permission_key, sr.serie_name, sr.serie_description, sr.semantic_url AS 'serie_url', sr.is_active AS 'serie_active' FROM series_seasons ss LEFT JOIN series sr ON sr.id_serie = ss.id_serie WHERE (sr.is_active = 'Y' AND ss.is_active = 'Y') AND NOW() > ss.launch_date ORDER BY RAND()  LIMIT 1";
            $database->query($query);
            $result = $database->resultsetObject();
            if ($result && count(get_object_vars($result)) > 0) {
                foreach ($result as $key => $value) {
                    $this->exists = true;
                    $this->$key = $text->utf8($value);
                }
                return true;
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function loadRandomFutureSerie()
    {
        global $text;
        try {
            $database = new Database();
            $query = "SELECT ss.id_serie_season, ss.id_serie, ss.short_key, ss.season_level, ss.season_title, ss.season_description, ss.season_brand, ss.season_bg, ss.season_cover, ss.season_banner, ss.season_banner_bg, ss.insert_time, ss.launch_date, ss.is_active AS 'season_active', ss.permission_key, sr.serie_name, sr.serie_description, sr.semantic_url AS 'serie_url', sr.is_active AS 'serie_active' FROM series_seasons ss LEFT JOIN series sr ON sr.id_serie = ss.id_serie WHERE (sr.is_active = 'Y' AND ss.is_active = 'Y') AND  ss.launch_date > NOW() ORDER BY RAND()  LIMIT 1";
            $database->query($query);
            $result = $database->resultsetObject();
            if ($result && count(get_object_vars($result)) > 0) {
                foreach ($result as $key => $value) {
                    $this->exists = true;
                    $this->$key = $text->utf8($value);
                }
                return true;
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function loadEpisode($episode, $season_short_key)
    {
        global $text;
        try {
            $database = new Database();
            $query = "SELECT * FROM series_seasons_contents ssc LEFT JOIN series_seasons ss ON ss.id_serie_season = ssc.id_season LEFT JOIN series sr ON sr.id_serie = ss.id_serie WHERE (ss.short_key = ? AND id_serie_season_content = ?) AND (NOW() > ssc.launch_date) ORDER BY ssc.episode, ssc.launch_date";
            $database->query($query);
            $database->bind(1, $season_short_key);
            $database->bind(2, $episode);
            $result = $database->resultsetObject();
            if ($result && count(get_object_vars($result)) > 0) {
                foreach ($result as $key => $value) {
                    $this->exists = true;
                    $this->$key = $text->utf8($value);
                }
                return true;
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function getAllContentsBySeason()
    {
        global $text;
        try {
            $database = new Database();
            $query = "SELECT * FROM series_seasons_contents ssc LEFT JOIN contents ct ON ct.id_content = ssc.id_content LEFT JOIN series_seasons ss ON ss.id_serie_season = ssc.id_season WHERE ssc.id_season = ? AND NOW() > ssc.launch_date AND ct.content_type = 'serie' ORDER BY ssc.episode, ssc.launch_date";
            $database->query($query);
            $database->bind(1, $this->getIdSerieSeason());
            $result = $database->resultset();
            if (!empty($result)) {
                return $result;
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return array();
    }


    public function getNextSerieEpisode()
    {
        try {
            $same_season = $this->getNextEpisodeInsideSeason();
            if (!empty($same_season)) return $same_season;

            $next_season = $this->getNextSeasonInsideSerie();
            if (!empty($next_season)) return $next_season;

        } catch (Exception $exception) {
            error_log($exception);
        }
        return array();
    }

    private function getNextEpisodeInsideSeason()
    {
        try {
            $database = new Database();
            $database->query("SELECT ssc.id_serie_season_content, ss.id_serie, ss.short_key, ss.season_level, MIN(ssc.episode) episode, ssc.id_content, sr.id_serie, ss.permission_key, sr.semantic_url FROM series_seasons ss RIGHT JOIN series_seasons_contents ssc ON ssc.id_season = ss.id_serie_season LEFT JOIN series sr ON sr.id_serie = ss.id_serie WHERE ss.id_serie = ? AND ssc.episode > ? AND ss.season_level = ? ORDER BY ssc.episode LIMIT 1");
            $database->bind(1, $this->getIdSerie());
            $database->bind(2, $this->getEpisode());
            $database->bind(3, $this->getSeasonLevel());
            $result = $database->resultset();
            if (!empty($result)) {
                if (notempty($result[0]['id_serie'])) {
                    return $result[0];
                }
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return array();
    }

    private function getNextSeasonInsideSerie()
    {
        try {
            $database = new Database();
            $database->query("SELECT ssc.id_serie_season_content, ss.id_serie, ss.short_key, ss.season_level, MIN(ssc.episode) episode, ssc.id_content, sr.id_serie, ss.permission_key, sr.semantic_url FROM series_seasons ss RIGHT JOIN series_seasons_contents ssc ON ssc.id_season = ss.id_serie_season LEFT JOIN series sr ON sr.id_serie = ss.id_serie WHERE ss.id_serie = ? AND ss.season_level > ? LIMIT 1");
            $database->bind(1, $this->getIdSerie());
            $database->bind(2, $this->getSeasonLevel());
            $result = $database->resultset();
            if (!empty($result)) {
                if (notempty($result[0]['id_serie'])) {
                    return $result[0];
                }
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return array();
    }


    public function createUrl(string $serie_url, string $short_key)
    {
        return $this->main_url . $serie_url . "/" . $short_key;
    }

    public function createContentURL(string $serie_url, string $short_key, int $id_relation, string $title)
    {
        global $url;
        $friendly_title = $url->friendly($title);
        return $this->main_url . $serie_url . "/" . $short_key . "/" . $id_relation . "-" . $friendly_title;
    }

    /**
     * @return mixed
     */
    public function getIdSerie()
    {
        return $this->id_serie;
    }

    /**
     * @return mixed
     */
    public function getSerieName()
    {
        return $this->serie_name;
    }

    /**
     * @return mixed
     */
    public function getSerieDescription()
    {
        return $this->serie_description;
    }

    /**
     * @return mixed
     */
    public function getSerieBanner()
    {
        return $this->serie_banner;
    }

    /**
     * @return mixed
     */
    public function getSerieBannerBg()
    {
        return $this->serie_banner_bg;
    }

    /**
     * @return mixed
     */
    public function getSerieCover()
    {
        return $this->serie_cover;
    }

    /**
     * @return mixed
     */
    public function getSemanticUrl()
    {
        return $this->semantic_url;
    }

    /**
     * @return mixed
     */
    public function getInsertTime()
    {
        return $this->insert_time;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * @return mixed
     */
    public function getIdSerieSeason()
    {
        return $this->id_serie_season;
    }

    /**
     * @return mixed
     */
    public function getShortKey()
    {
        return $this->short_key;
    }

    /**
     * @return mixed
     */
    public function getSeasonLevel()
    {
        return $this->season_level;
    }

    /**
     * @return mixed
     */
    public function getSeasonTitle()
    {
        return $this->season_title;
    }

    /**
     * @return mixed
     */
    public function getSeasonDescription()
    {
        return $this->season_description;
    }

    /**
     * @return mixed
     */
    public function getSeasonBrand()
    {
        return $this->season_brand;
    }

    /**
     * @return mixed
     */
    public function getSeasonBg()
    {
        return $this->season_bg;
    }

    /**
     * @return mixed
     */
    public function getSeasonCover()
    {
        return $this->season_cover;
    }

    /**
     * @return mixed
     */
    public function getSeasonBanner()
    {
        return $this->season_banner;
    }

    /**
     * @return mixed
     */
    public function getSeasonBannerBg()
    {
        return $this->season_banner_bg;
    }

    /**
     * @return mixed
     */
    public function getLaunchDate()
    {
        return $this->launch_date;
    }

    /**
     * @return mixed
     */
    public function isSeasonActive()
    {
        return $this->season_active === "Y" ? true : false;
    }

    /**
     * @return mixed
     */
    public function getPermissionKey()
    {
        return $this->permission_key;
    }

    /**
     * @return mixed
     */
    public function getSerieUrl()
    {
        return $this->serie_url;
    }

    /**
     * @return mixed
     */
    public function isSerieActive()
    {
        return $this->serie_active === "Y" ? true : false;
    }

    /**
     * @return string
     */
    public function getMainUrl(): string
    {
        return $this->main_url;
    }

    public function fixSeasonLevel($level)
    {
        return sprintf("%02d", $level);
    }

    /**
     * @return mixed
     */
    public function getIdContent()
    {
        return $this->id_content;
    }

    /**
     * @return mixed
     */
    public function getEpisode()
    {
        return $this->episode;
    }

    /**
     * @return bool
     */
    public function isExists(): bool
    {
        return $this->exists;
    }



}