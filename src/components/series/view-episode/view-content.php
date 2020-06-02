<?php
$contentNote = new ContentsNotes();
$content_edited = $contentNote->getContent($contents->getIdContent());
?>
<div class="section white-bg">
    <div class="container">
        <div class="row">
            <div class="text-options"></div>
        </div>
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-12">
                <div class="content-serie-text-section" id="r9ac403da7947a183884c18a67d3aa8de" style="margin-top:0;">
                    <div id="serie_ctn" data-content="<?= ($contents->getIdContent()) ?>" class="">
                        <?php if (notempty($content_edited)) { ?>
                            <?= $text->base64_decode($content_edited) ?>
                        <?php } else { ?>
                            <?= $contents->getContentHtml() ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="offset-1"></div>
            <div class="col-xl-3 col-lg-3 col-sm-12">
                <div class="serie-sidebar-box">
                    <h4>Leve com você</h4>
                    <a href="#"
                       data-download="../../download/<?= $account->getIdAccount() . "-" . md5($contents->getIdContent()) ?>"
                       data-name="<?= $url->friendly($contents->getTitle()) ?>.pdf"
                       class="btn serie-view ajax-download"
                       style="display: block;"><i
                                class="far fa-download"></i> Baixar em
                        PDF</a>
                </div>
                <div class="serie-sidebar-box">
                    <h4>Próximo Episódio</h4>
                </div>
            </div>
        </div>
    </div>
</div>