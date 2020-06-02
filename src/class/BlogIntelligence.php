<?php

class BlogIntelligence
{

    private $algorithmia_key = "simghwHRN1oe3lv2cSB6rjiFKXD1";

    public function __construct()
    {
        global $text;
        try {
            $database = new Database();
            $database->query("SELECT id_content, title, content_html FROM contents WHERE (content_type = 'blog' OR content_type = 'serie') AND is_active = 'Y' AND is_analyzed = 'N' ");
            $result = $database->resultset();
            for ($i = 0; $i < count($result); $i++) {

                $id_content = $result[$i]['id_content'];
                $content_title = $result[$i]['title'];
                $content_html = $result[$i]['content_html'];
                $content_html = $text->utf8($content_html);
                $summary = $this->summarizer($content_html);
                $semantic_url = $this->createSemanticURL($content_title);
                if ($summary[0] !== null && $summary[1] !== null) {
                    $description = $summary['description'];
                    $keywords = $summary['keywords'];
                    $this->putIntelligenceOnBlog($semantic_url, $description, $keywords, $id_content, true);
                } else {
                    $this->putIntelligenceOnBlog($semantic_url, null, null, $id_content, false);
                }
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    private function createSemanticURL($title)
    {
        global $url;
        try {
            return $url->friendly($title);
        } catch (Exception $exception) {
            error_log($exception);
        }
    }


    private function summarizer($content_html)
    {
        global $url;
        try {

            $html = new \Html2Text\Html2Text($content_html);
            $input = $html->getText();

            $input = str_replace("<p>", "", $input);
            $input = str_replace("</p>", "", $input);

            $client = Algorithmia::client("simghwHRN1oe3lv2cSB6rjiFKXD1");

            /* ======================= KEYWORDS IA */
            $algo = $client->algo("cindyxiaoxiaoli/KeywordExtraction/0.3.0");
            $algo->setOptions(["timeout" => 300]);
            $kw_results = $algo->pipe($input)->result;
            $keywords = "";
            for ($i = 0; $i < count($kw_results); $i++) {
                if ($i > 0) {
                    $keywords .= "," . $kw_results[$i];
                } else {
                    $keywords .= $kw_results[$i];
                }
            }

            ///* ======================= DESCRIPTION IA */

            $client = Algorithmia::client("simghwHRN1oe3lv2cSB6rjiFKXD1");
            $algo = $client->algo("SummarAI/Summarizer/0.1.3");
            $algo->setOptions(["timeout" => 300]); //optional
            $description = $algo->pipe($input)->result->summarized_data;


            return array("description" => $description, "keywords" => $keywords);

        } catch (Exception $exception) {
            error_log($exception);
        }

        return array(null, null);
    }

    private function putIntelligenceOnBlog($semantic_url, $description = null, $keywords = null, $id_content, $set_ready = false)
    {
        try {
            $database = new Database();
            $database->query("UPDATE contents SET semantic_url = ?, description = ?, keywords = ?, is_analyzed = ?, analyze_time = CURRENT_TIMESTAMP WHERE id_content = ?");
            $database->bind(1, $semantic_url);
            $database->bind(2, $description);
            $database->bind(3, $keywords);
            $database->bind(5, ($set_ready ? "Y" : "N"));
            $database->bind(4, $id_content);
            $database->execute();
            return true;
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }


}