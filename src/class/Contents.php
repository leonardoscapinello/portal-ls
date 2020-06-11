<?php

class Contents
{

    private $id_content;
    private $id_author;
    private $id_category;
    private $title;
    private $cover_image;
    private $content_html;
    private $content_require;
    private $category_color;
    private $keywords;
    private $description;
    private $semantic_url;
    private $insert_time;
    private $content_type;
    private $is_active;
    private $private_level;
    private $category_name;
    private $permission_key;
    private $short_url;

    private $content_exists = false;


    public function __construct($ignore_init = false)
    {
        // PUT FOR JUST INITIALIZE CLASS WITHOUT DATABASE TOUCH
        if ($ignore_init) return;
        try {
            $this->content_type = (get_request("ctblog") === "Y" ? "blog" : "page");
            $semantic_url = $this->getSemanticRequest() === null ? "index" : $this->getSemanticRequest();
            $category_url = $this->getCategoryUrl();
            if ($this->content_type !== null && $semantic_url !== null) {
                $database = new Database();
                $text = new Text();
                if ($this->content_type === "blog") {
                    $database->query("SELECT * FROM contents ct LEFT JOIN contents_categories cc ON cc.id_category = ct.id_category WHERE ct.content_type = ? AND ct.semantic_url = ? AND ct.id_category = (SELECT id_category FROM contents_categories WHERE category_url = ?)");
                    $database->bind(3, $category_url);
                } else {
                    $database->query("SELECT * FROM contents ct LEFT JOIN contents_categories cc ON cc.id_category = ct.id_category WHERE content_type = ? AND semantic_url = ?");
                }
                $database->bind(1, $this->content_type);
                $database->bind(2, $semantic_url);
                $result = $database->resultsetObject();
                if ($result && count(get_object_vars($result)) > 0) {
                    $this->content_exists = true;
                    foreach ($result as $key => $value) {
                        $this->$key = $text->utf8($value);
                    }
                }
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function loadById($id_content)
    {
        try {

            $database = new Database();
            $text = new Text();
            $database->query("SELECT * FROM contents ct LEFT JOIN contents_categories cc ON cc.id_category = ct.id_category WHERE content_type = 'serie' AND id_content = ?");
            $database->bind(1, $id_content);
            $result = $database->resultsetObject();
            if ($result && count(get_object_vars($result)) > 0) {
                $this->content_exists = true;
                foreach ($result as $key => $value) {
                    $this->$key = $text->utf8($value);
                }
            }

        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function loadByHash($id_content)
    {
        try {

            $database = new Database();
            $text = new Text();
            $database->query("SELECT * FROM contents ct LEFT JOIN contents_categories cc ON cc.id_category = ct.id_category WHERE content_type = 'serie' AND MD5(id_content) = ?");
            $database->bind(1, $id_content);
            $result = $database->resultsetObject();
            if ($result && count(get_object_vars($result)) > 0) {
                $this->content_exists = true;
                foreach ($result as $key => $value) {
                    $this->$key = $text->utf8($value);
                }
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function getContentsList($filter = null, $limit = 4, $order_by = null)
    {
        global $text;
        $contents = array();
        try {
            $q_f = $q_l = $q_o = "";
            if ($filter !== null) $q_f = " AND (" . $filter . ")";
            if ($limit !== null) $q_l = " LIMIT " . $limit;
            if ($order_by !== null) $q_o = " ORDER BY " . $order_by;
            $query = "SELECT ct.id_category, ct.id_content, ct.title, ct.cover_image, ct.semantic_url, cc.category_name, cc.category_url, ct.description FROM contents ct LEFT JOIN contents_categories cc ON cc.id_category = ct.id_category WHERE ct.content_type = 'blog' AND ct.is_active = 'Y' AND ct.is_analyzed = 'Y' " . $q_f . " " . $q_o . " " . $q_l;

            $database = new Database();
            $database->query($query);
            $result = $database->resultset();
            for ($i = 0; $i < count($result); $i++) {
                $unique = array(
                    "title" => $text->utf8($result[$i]['title']),
                    "cover_image" => $text->utf8($result[$i]['cover_image']),
                    "category_name" => $text->utf8($result[$i]['category_name']),
                    "description" => $text->utf8($result[$i]['description']),
                    "content_url" => $this->createUrl($result[$i]['category_url'], $result[$i]['semantic_url'])
                );
                array_push($contents, $unique);
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return $contents;
    }


    public function getRelatedContents()
    {
        global $text;
        $contents = array();
        try {
            $query = "SELECT *, MATCH(ct.title, ct.content_html) AGAINST(?) AS score FROM contents ct LEFT JOIN contents_categories cc ON cc.id_category = ct.id_category WHERE MATCH(ct.title, ct.content_html) AGAINST(?) AND ct.id_content != ? ORDER BY score DESC LIMIT 4";
            $database = new Database();
            $database->query($query);
            $database->bind(1, $this->getContentHtml());
            $database->bind(2, $this->getContentHtml());
            $database->bind(3, $this->getIdContent());
            $result = $database->resultset();
            for ($i = 0; $i < count($result); $i++) {
                $unique = array(
                    "title" => $text->utf8($result[$i]['title']),
                    "category_name" => $text->utf8($result[$i]['category_name']),
                    "cover_image" => $text->utf8($result[$i]['cover_image']),
                    "description" => $text->utf8($result[$i]['description']),
                    "content_url" => $this->createUrl($result[$i]['category_url'], $result[$i]['semantic_url'])
                );
                array_push($contents, $unique);
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return $contents;
    }


    public function getNextRelatedContent()
    {
        global $text;
        $unique = array();
        try {
            $database = new Database();
            $query = "SELECT ct.title, ct.description, ct.cover_image, ct.semantic_url, cc.category_url, MATCH(ct.title, ct.content_html) AGAINST(?) AS score FROM contents ct LEFT JOIN contents_categories cc ON cc.id_category = ct.id_category WHERE MATCH(ct.title, ct.content_html) AGAINST(?) AND id_content <> ? AND content_type = 'blog' ORDER BY score DESC LIMIT 1";
            $database->query($query);
            $database->bind(1, $this->getContentHtml());
            $database->bind(2, $this->getContentHtml());
            $database->bind(3, $this->getIdContent());
            $result = $database->resultset();
            if (count($result) > 0) {
                $unique = array(
                    "title" => $text->utf8($result[0]['title']),
                    "cover_image" => $text->utf8($result[0]['cover_image']),
                    "description" => $text->utf8($result[0]['description']),
                    "content_url" => $this->createUrl($result[0]['category_url'], $result[0]['semantic_url'], true)
                );
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return $unique;
    }


    public function getCategoryByURL($category_url = null)
    {
        try {
            if (notempty($category_url)) {
                $database = new Database();
                $database->query("SELECT * FROM contents_categories WHERE category_url = ?");
                $database->bind(1, $category_url);
                $result = $database->resultset();
                if (count($result) > 0) {
                    return $result[0];
                }
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return 0;
    }

    private function fixHTMLString($value)
    {
        global $text;
        $value = $text->utf8($value);
        $value = htmlentities($value);
        $value = html_entity_decode($value);
        return $value;
    }


    private function createUrl(string $category_url, string $semantic_url, $blog_address = true)
    {
        return ($blog_address ? BLOG_ADDRESS : "../") . $category_url . "/" . $semantic_url;
    }

    private function createShortUrl()
    {
        return "https://ls-go.com/" . $this->getShortUrl();
    }

    public function getSemanticRequest()
    {
        $s = get_request("semantic_url");
        if ($s !== null) {
            return $s;
        }
        return null;
    }

    public function getCategoryUrl()
    {
        $s = get_request("category_url");
        if ($s !== null) {
            return $s;
        }
        return null;
    }

    public function getIdContent()
    {
        return $this->id_content;
    }

    public function getIdAuthor()
    {
        return $this->id_author;
    }

    public function getShare__Facebook()
    {
        $url = urlencode($this->createShortUrl());
        $text = urlencode($this->getTitle());
        return "https://www.facebook.com/sharer/sharer.php?u=" . $url . "&t=" . $text . "&quote=";
    }

    public function getShare__Twitter()
    {
        $url = urlencode($this->createShortUrl());
        $text = urlencode($this->getTitle());
        return "https://twitter.com/intent/tweet?text=" . $text . "&url=" . $url . "&via=leoscapinello&lang=pt&related=leoscapinello";
    }

    public function getShare__Linkedin()
    {
        $url = urlencode($this->createShortUrl());
        $text = urlencode($this->getTitle());
        $summary = urlencode($this->getTitle());
        return "https://www.linkedin.com/shareArticle/?mini=true&url=" . $url . "&title=" . $text . "&summary=" . $summary . "&source=lsgo.me";
    }


    public function getShare__WhatsApp()
    {
        global $browser;
        $url = urlencode("Eu encontrei esse artigo e acho que você vai gostar: *" . $this->getTitle() . "* em " . $this->createShortUrl());
        $text = urlencode($this->getTitle());
        if ($browser->isMobile()) return "whatsapp://send?text=" . $url . "\" data-action=\"share/whatsapp/share\"";
        return "https://api.whatsapp.com/send?text=" . $url;
    }

    public function getIdCategory()
    {
        return $this->id_category;
    }

    public function getTitle()
    {
        if ($this->isContentExists()) {
            return $this->fixHTMLString($this->title);
        }
        return "Página não Encontrada";
    }

    public function getContentHtml()
    {
        return $this->fixHTMLString($this->content_html);;
    }

    public function getContentRequire()
    {
        $c = DIRNAME . "../applications/pages/" . $this->content_require;
        if (file_exists($c)) {
            return $c;
        }
        return null;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function getDescription()
    {
        return $this->fixHTMLString($this->description);
    }

    public function getSemanticUrl()
    {
        return $this->semantic_url;
    }

    public function getInsertTime()
    {
        return $this->insert_time;
    }

    public function getIsActive()
    {
        return $this->is_active;
    }

    public function getPrivateLevel()
    {
        return $this->private_level;
    }

    public function getContentType()
    {
        return $this->content_type;
    }

    public function getCoverImage($image = null)
    {
        global $static;
        if (!notempty($image)) {
            if (!not_empty($this->cover_image)) return null;
            return $static->loadBlog($this->cover_image);
        } else {
            if (!not_empty($image)) return null;
            return $static->loadBlog($image);
        }
    }

    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->category_name;
    }

    /**
     * @return mixed
     */
    public function getCategoryColor()
    {
        return $this->category_color;
    }

    /**
     * @return bool
     */
    public function isContentExists(): bool
    {
        return $this->content_exists;
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
    public function getShortUrl()
    {
        return $this->short_url;
    }


}