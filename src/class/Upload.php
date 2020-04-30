<?php

class Upload
{
    private $max_allowed_file_size = 1024*30; // size in KB
    private $allowed_extensions = array("png", "jpg", "jpeg", "gif", "mp4", "webm");
    private $upload_folder = "../../../static/images/blog/uploads/";

    private $file = array();

    private function getBaseName()
    {
        return basename($this->file['name']);
    }

    private function getFileSize()
    {
        return basename($this->file['size']);
    }

    private function getFileType()
    {
        return substr($this->getBaseName(), strrpos($this->getBaseName(), '.') + 1);
    }

    private function getTempFolder()
    {
        return $temp_file = $this->file['tmp_name'];
    }

    private function checkForFileSize()
    {
        if (($this->getFileSize() / 1024) > $this->max_allowed_file_size) {
            return false;
        }
        return true;
    }

    private function checkForFormat()
    {
        $allowed_ext = false;
        for ($i = 0; $i < sizeof($this->allowed_extensions); $i++) {
            if (strcasecmp($this->allowed_extensions[$i], $this->getFileType()) === 0) {
                $allowed_ext = true;
            }
        }

        return $allowed_ext;
    }

    private function createNewFileName()
    {
        $token = new Token();
        return $token->tokenAlphanumeric(64) . "-" . $token::v4() . "." . $this->getFileType();
    }


    public function setFile($_FILE)
    {
        $this->file = $_FILE;
    }

    public function setUploadFolder(string $upload_folder)
    {
        $this->upload_folder = $upload_folder;
    }

    public function uploadFile()
    {
        try {
            $upload_folder = $this->upload_folder;
            $newfilename = $this->createNewFileName();
            $path_of_uploaded_file = $upload_folder . $newfilename;
            $temp = $this->getTempFolder();

            if ($this->checkForFileSize()) {
                if ($this->checkForFormat()) {


                    if (is_uploaded_file($temp)) {
                        if (copy($temp, $path_of_uploaded_file)) {
                            if (file_exists($path_of_uploaded_file)) {
                                return array(true, $newfilename);
                            } else {
                                error_log("AK1-AAA");
                            }
                        } else {
                            error_log("AK1-bbb");
                        }
                    } else {
                        error_log("AK1-ccc");
                    }


                } else {
                    return array(false, "O formato do arquivo enviado não é aceito, considere apenas imagens e vídeos (.png, .jpg, .gif, .mp4)");
                }
            } else {
                return array(false, "O arquivo é muito grande, o tamanho máximo permitido é de 10MB");
            }

        } catch (Exception $exception) {
            error_log($exception);
        }
        return array(false, "Não foi possível enviar o arquivo.");
    }


}