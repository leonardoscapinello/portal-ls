<?php

class Images
{
    var $image;
    var $image_type;

    function load($filename)
    {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];

        if ($this->image_type === IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type === IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type === IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    function save($filename, $image_type = null, $compression = 95, $permissions = null)
    {

        $save_path = "_converted/" . $filename;
        if (!notempty($image_type)) {
            $image_type = $this->image_type;
        }

        if ($image_type === IMAGETYPE_JPEG) {
            imagejpeg($this->image, $save_path, $compression);
        } elseif ($image_type === IMAGETYPE_GIF) {
            imagegif($this->image, $save_path);
        } elseif ($image_type === IMAGETYPE_PNG) {
            imagepng($this->image, $save_path);
        }
        if ($permissions != null) {
            chmod($save_path, $permissions);
        }
    }

    function output($image_type = null)
    {
        if (!notempty($image_type)) {
            $image_type = $this->image_type;
        }

        if ($image_type === IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type === IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif ($image_type === IMAGETYPE_PNG) {
            imagepng($this->image);
        } elseif ($image_type === IMAGETYPE_WEBP) {
            imagewebp($this->image);
        }
    }

    function header($image_type = null)
    {
        if (!notempty($image_type)) {
            $image_type = $this->image_type;
        }
        if ($image_type === IMAGETYPE_JPEG) {
            return ("Content-type:image/jpeg");
        } elseif ($image_type === IMAGETYPE_GIF) {
            return("Content-type:image/gif");
        } elseif ($image_type === IMAGETYPE_PNG) {
            return("Content-type:image/png");
        } elseif ($image_type === IMAGETYPE_WEBP) {
            return("Content-type:image/webp");
        }else{
            return("Content-type:image/webp");
        }
    }

    function getWidth()
    {
        return imagesx($this->image);
    }

    function getHeight()
    {
        return imagesy($this->image);
    }

    function resizeToHeight($height)
    {

        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    function resizeToWidth($width)
    {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }

    function scale($scale)
    {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    function resize($width, $height)
    {
        if ($this->image_type === IMAGETYPE_WEBP) {
            imagealphablending($this->image, false);
            imagesavealpha($this->image, true);
            $new_image = imagecreatetruecolor($width, $height);
            imagefill($new_image, 0, 0, 0x7fff0000);
        } else if ($this->image_type === IMAGETYPE_PNG) {
            $new_image = imagecreatetruecolor($width, $height);
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
            $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
            imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);
        } else {
            $new_image = imagecreatetruecolor($width, $height);
        }
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }


}