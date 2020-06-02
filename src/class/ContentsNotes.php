<?php

class ContentsNotes
{

    private $id_note;
    private $id_account;
    private $id_content;
    private $content_edited;
    private $insert_time;

    public function save($id_content, $content)
    {
        global $account;
        try {
            $database = new Database();
            $id_account = $account->getIdAccount();
            $content_exists = $this->getContent($id_content);
            if (!notempty($content_exists)) {
                $database->query("INSERT INTO contents_notes (id_account, id_content, content_edited) VALUES (?,?,?)");
                $database->bind(1, $id_account);
                $database->bind(2, $id_content);
                $database->bind(3, $content);
                $database->execute();
                return true;
            } else {
                $database->query("UPDATE contents_notes SET content_edited = ? WHERE id_content = ? AND id_account = ?");
                $database->bind(1, $content);
                $database->bind(2, $id_content);
                $database->bind(3, $id_account);
                $database->execute();
                return true;
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function getContent($id_content, $id_account = 0)
    {
        global $account;
        try {
            if ($id_account === 0) $id_account = $account->getIdAccount();
            $database = new Database();
            $database->query("SELECT content_edited FROM contents_notes WHERE id_content = ? AND id_account = ?");
            $database->bind(1, $id_content);
            $database->bind(2, $id_account);
            $result = $database->resultset();
            if (!empty($result)) {
                return $result[0]['content_edited'];
            }
        } catch (Exception $exception) {
            error_log($exception);
        }
        return null;
    }

}