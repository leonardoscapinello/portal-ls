<?php

class Landing
{
    private $id_launch;
    private $title;
    private $description;
    private $keywords;
    private $semantic_url;
    private $original_price;
    private $launch_price;
    private $purchase_url;
    private $internal_path;
    private $expire_date;
    private $insert_time;

    public function __construct()
    {
        try {
            $semantic_url = get_request("launch");
            if ($semantic_url !== null && $semantic_url !== "") {
                $database = new Database();
                $text = new Text();
                $database->query("SELECT * FROM launch lc WHERE lc.semantic_url = ?");
                $database->bind(1, $semantic_url);
                $result = $database->resultsetObject();
                if ($result && count(get_object_vars($result)) > 0) {
                    foreach ($result as $key => $value) {
                        $this->$key = $text->utf8($value);
                    }
                }
            }


        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function loadAsset($file)
    {
        $base_path = SERVER_ADDRESS . "launch/" . $this->getInternalPath() . "/";
        $path_parts = pathinfo($file);
        if ($path_parts['extension'] === "css") return "<link href=\"" . $base_path . "stylesheet/" . $path_parts['basename'] . "?v=2.1\" type=\"text/css\" rel=\"stylesheet\" />";
        if ($path_parts['extension'] === "ttf") return "<link href=\"" . $base_path . "fonts/" . $path_parts['dirname'] . "/" . $path_parts['filename'] . ".css\" type=\"text/css\" rel=\"stylesheet\" />";
        if ($path_parts['extension'] === "js") return "<script src=\"" . $base_path . "javascript/" . $path_parts['basename'] . "?v=12\" type=\"text/javascript\"></script>";
        if ($path_parts['extension'] === "mp4") return $base_path . "media/" . $path_parts['basename'];
        return $base_path . "images/" . $path_parts['basename'];
    }

    public function loadGlobalAsset($file)
    {
        $base_path = SERVER_ADDRESS . "launch/";
        $path_parts = pathinfo($file);
        if ($path_parts['extension'] === "css") return "<link href=\"" . $base_path . "stylesheet/" . $path_parts['basename'] . "?v=2.1\" type=\"text/css\" rel=\"stylesheet\" />";
        if ($path_parts['extension'] === "ttf") return "<link href=\"" . $base_path . "fonts/" . $path_parts['dirname'] . "/" . $path_parts['filename'] . ".css\" type=\"text/css\" rel=\"stylesheet\" />";
        if ($path_parts['extension'] === "js") return "<script src=\"" . $base_path . "javascript/" . $path_parts['basename'] . "?v=12\" type=\"text/javascript\"></script>";
        if ($path_parts['extension'] === "mp4") return $base_path . "media/" . $path_parts['basename'];
        return $base_path . "images/" . $path_parts['basename'];
    }

    public function getContentFile()
    {
        $landingFolder = $this->getInternalPath();
        $subload = get_request("subload");
        if ($subload === null || $subload === "") $subload = "index.php";
        $file = DIRNAME . "../../public/landings/" . $landingFolder . "/" . $subload . ".php";
        if (file_exists($file)) return $file;

        # IF FILE NOT EXISTS, TRY LOAD INDEX
        $file = DIRNAME . "../../public/landings/" . $landingFolder . "/index.php";
        if (file_exists($file)) return $file;

        return null;
    }

    /**
     * @return mixed
     */
    public function getIdLaunch()
    {
        return $this->id_launch;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return $this->keywords;
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
    public function getOriginalPrice()
    {
        return $this->original_price;
    }

    /**
     * @return mixed
     */
    public function getLaunchPrice()
    {
        return $this->launch_price;
    }

    /**
     * @return mixed
     */
    public function getPurchaseUrl()
    {
        return $this->purchase_url;
    }

    /**
     * @return mixed
     */
    public function getInternalPath()
    {
        return $this->internal_path;
    }

    /**
     * @return mixed
     */
    public function getExpireDate()
    {
        return $this->expire_date;
    }

    /**
     * @return mixed
     */
    public function getInsertTime()
    {
        return $this->insert_time;
    }


}