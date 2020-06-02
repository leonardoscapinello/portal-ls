<?php
$series = new Series();
$serie_url = get_request("serie_url");
$season_short_key = get_request("season_short_key");
$episode = get_request("episode");
if (!notempty($serie_url) || !notempty($season_short_key) || !notempty($episode)) {
    header("location: " . SERVER_ADDRESS . "series");
    die;
}

$loaded = $series->loadEpisode($episode, $season_short_key);
if (!$loaded) {
    header("location: " . SERVER_ADDRESS . "series");
    die;
}

$contents = new Contents(true);
$contents->loadById($series->getIdContent());
require_once(DIRNAME . "../components/series/view-episode/header.php");
require_once(DIRNAME . "../components/series/view-episode/view-content.php");
?>
<div class="content_adm">
    <ul>
        <li class="look_links"><a href="#" onClick="setElementTag('highlight');return false;"><i
                        class="fas fa-highlighter"></i></a></li>
        <li class="look_links">
            <a href="#" onClick="openComment();return false;">
                <i class="fas fa-comment"></i>
            </a>
            <div id="comment_dialog" class="comment_dialog">
                <label for="comment_tx" style="display: none"></label>
                <textarea id="comment_tx" class="comment_tx" placeholder="Digite aqui sua anotação"></textarea>
                <a onClick="closeComment()" class="btn nobg">Cancelar</a>
                <a onClick="setComment()" class="btn">Salvar</a>
            </div>
        </li>
        <?php /* ?>
        <li class="look_links"><a href="#" onClick="setElementTag('bold');return false;"><i class="fas fa-bold"></i></a>
        </li>
        <li class="look_links"><a href="#" onClick="setElementTag('italic');return false;"><i class="fas fa-italic"></i></a>
        </li>
        <li class="look_links"><a href="#" onClick=""><i class="fas fa-save"></i></a></li>
 <?php */ ?>
    </ul>
</div>
