<?php

class StaticCompiler
{

    private $files = array();
    private $replaces = array();
    private $output_path;
    private $date_reason = "dmYHis";

    public function add($location)
    {
        if (file_exists($location)) {
            array_push($this->files, $location);
        }
    }

    public function replace($search, $replace)
    {
        array_push($this->replaces, array($search, $replace));
    }

    /*
    public function load($file, $encoded = false)
    {
        $path_parts = pathinfo($file);
        $version = "?v=1.0.0.108";
        if ($path_parts['extension'] === "css") return "<link href=\"" . STATIC_URL . "stylesheet/" . $path_parts['basename'] . $version . "\" type=\"text/css\" rel=\"stylesheet\" />";
        if ($path_parts['extension'] === "ttf") return "<link href=\"" . STATIC_URL . "fonts/" . $path_parts['dirname'] . "/" . $path_parts['filename'] . ".css\" type=\"text/css\" rel=\"stylesheet\" />";
        if ($path_parts['extension'] === "js" && $encoded) return "<script src=\"" . STATIC_URL . "javascript/" . $path_parts['basename'] . $version . "\" type=\"text/javascript\"></script>";
        if ($path_parts['extension'] === "js") return "<script src=\"" . STATIC_URL . "javascript/" . $path_parts['basename'] . $version . "\" type=\"text/javascript\"></script>";
        return STATIC_URL . "images/" . $path_parts['basename'];
    }*/

    public function load($file, $encoded = false)
    {
        try {
            $path_parts = pathinfo($file);
            $ext = $path_parts['extension'];
            $base = $path_parts['basename'];
            $additional_folder = $path_parts['dirname'];
            $initial = STATIC_URL;

            if ($ext === "css") {
                $file_folder = "stylesheet";
                $file_tag = "<link href=\"%s\" rel=\"stylesheet\" rel=\"preload\" as=\"style\" media=\"none\" onload=\"if(media!='all')media='all'\"/>";
            } else if ($ext === "ttf") {
                $base = $path_parts['filename'] . ".css";
                $file_folder = "fonts";
                $file_tag = "<link href=\"%s\" rel=\"stylesheet\" rel=\"preload\" as=\"style\" media=\"none\" onload=\"if(media!='all')media='all'\"/>";
            } else if ($ext === "js") {
                $file_folder = "javascript";
                $file_tag = "<script src=\"%s\" type=\"text/javascript\"></script>";
            } else {
                $initial = $initial . "../";
                if ($ext === "png" || $ext === "jpg") {
                    $file_folder = "images/display?src=";
                } else {
                    $file_folder = "public/images/";
                }
                $file_tag = "%s";
            }

            $additional_folder = ($additional_folder === "" || $additional_folder === ".") ? null : $additional_folder . "/";
            $file = $initial . $file_folder . "/" . $additional_folder . $base;
            $file_load = sprintf($file_tag, $file);

            return $file_load;

        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function printCSS($file)
    {
        $path_parts = pathinfo($file);
        $file = DIRNAME . "../../public/stylesheet/" . $path_parts['basename'];
        $css = null;
        if (file_exists($file)) {
            $css = "<style type=\"text/css\">";
            $css .= file_get_contents($file);
            $css .= "</style>";
        }
        return $css;
    }

    public function loadBlog($file)
    {
        $path_parts = pathinfo($file);
        return $this->load("/blog/" . $path_parts['basename']);
    }

    public function loadSeries($file, $short_key)
    {
        return $this->load("../series/" . $short_key . "/" . $file);
    }

    public function setOutputPath($path)
    {
        $this->output_path = $path;
    }


    public function minifyStyleSheet($filename = "stylesheet")
    {
        $end_file = $this->output_path . $filename . ".min.css";
        $end_file_last_update = "";
        $compile = false;
        if (file_exists($end_file)) {
            $end_file_last_update = date($this->date_reason, filemtime($end_file));
        } else {
            $compile = true;
        }
        for ($i = 0; $i < count($this->files); $i++) {
            $current_file_last_update = date($this->date_reason, filemtime($this->files[$i]));
            if ($end_file_last_update !== $current_file_last_update) {
                $file2_content = file_get_contents($this->files[$i]);
                $file2 = fopen($this->files[$i], "w") or die("Unable to open file!");
                fwrite($file2, $file2_content);
                fclose($file2);
                $compile = true;
            }
        }
        $buffer = "";
        if ($compile) {
            for ($i = 0; $i < count($this->files); $i++) {
                $buffer .= file_get_contents($this->files[$i]);
            }
            $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
            $buffer = str_replace(': ', ':', $buffer);
            $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
            if (count($this->replaces) > 0) {
                for ($x = 0; $x < count($this->replaces); $x++) {
                    $buffer = str_replace($this->replaces[$x][0], $this->replaces[$x][1], $buffer);
                }
            }
            $file = fopen($end_file, "w") or die("Unable to open file!");
            fwrite($file, $buffer);
            fclose($file);
        }
    }


}