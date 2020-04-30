<?php
$req = $contents->getContentRequire();
if (not_empty($req)) {
    require_once($req);
}

?>