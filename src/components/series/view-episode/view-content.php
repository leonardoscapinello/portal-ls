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
                    <a href="<?=SERVER_ADDRESS?>series/download/<?= md5($contents->getIdContent()) ?>"
                       class="btn serie-view ajax-download"
                       target="_blank"
                       style="display: block;"><i
                                class="far fa-download"></i> Baixar em
                        PDF</a>
                    <iframe src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" id="repodown" name="repodown" style="display: none"></iframe>
                </div>
                <div class="serie-sidebar-box">


                    <?php
                    $next_episode = $series->getNextSerieEpisode();
                    if (!empty($next_episode)) {

                        $content_next = new Contents();
                        $content_next->loadById($next_episode['id_content']);

                        ?>
                        <h4>Próximo Episódio</h4>


                        <div class="season-widget-sml">
                            <figure>
                                <img src="<?= $static->loadBlog($content_next->getCoverImage()) ?>"
                                     alt="<?= $content_next->getTitle() ?>">
                            </figure>
                            <div class="episode_level">
                                Temporada <?= $series->fixSeasonLevel($next_episode['season_level']) ?>&nbsp;&nbsp;
                                Episódio <?= $series->fixSeasonLevel($next_episode['episode']) ?>
                            </div>

                            <div class="title_serie">
                                <?= $text->utf8($content_next->getTitle()) ?>
                            </div>
                            <div class="read_time_serie">
                                <i class="far fa-clock"></i> <?= $text->readingTime($content_next->getContentHtml()) ?>
                                minutos
                            </div>

                            <?php if (!$session->isLogged()) { ?>
                                <a href="<?= LOGIN_URL ?>?next=<?= $url->getActualURLAsNext() ?>"
                                   class="btn serie-view" style="display: block;margin: 20px 0">
                                    <i class="far fa-lock-alt"></i> Acessar Conteúdo
                                </a>
                            <?php } elseif (!$license->userCanAccessByKey($next_episode['permission_key'])) { ?>
                                <a href="<?= SERVER_ADDRESS ?>assinatura?ref=series&src=<?= md5($series->getIdSerie()) ?>&utm_source=series_view&utm_medium=premium_content_btn"
                                   class="btn serie-view" style="display: block;margin: 20px 0">
                                    <i class="far fa-star"></i> Assine Premium para Acessar
                                </a>
                            <?php } else { ?>
                                <a href="<?= $series->createContentURL($next_episode['semantic_url'], $next_episode['short_key'], $next_episode['id_serie_season_content'], $content_next->getTitle()) ?>"
                                   class="btn serie-view" style="display: block;margin: 20px 0">
                                    <i class="far fa-lock-open-alt"></i> Acessar Conteúdo
                                </a>
                            <?php } ?>
                        </div>


                    <?php } else { ?>
                        <h4>Mais Séries</h4>
                        <a href="<?= SERVER_ADDRESS ?>series"
                           class="btn serie-view ajax-download"
                           style="display: block;">
                            <i class="far fa-list"></i>
                            Ver Catálogo
                        </a>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>