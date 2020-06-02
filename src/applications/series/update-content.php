<?php
require_once("../../properties/index.php");

$hash = get_request("hash");
$content = get_request("content");
if ($content !== null && $hash !== null) {
    $contentsNotes = new ContentsNotes();
    $saved = $contentsNotes->save($hash, $content);
}