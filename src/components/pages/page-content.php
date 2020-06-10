<?php
$req = $contents->getContentRequire();
if (not_empty($req)) {
    if (file_exists($req) && is_file($req)) {
        require_once($req);
    }
}
