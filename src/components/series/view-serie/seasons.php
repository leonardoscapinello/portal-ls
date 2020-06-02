<?php
$season_list = $series->getAllSeasonFromSerie();
$list = $series->getAllContentsBySeason();
?>
<section>
    <div class="section white-bg">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-sm-12">

                    <div class="dropselect-links">
                        <div class="selected-value" data-dropselect="open" id="seasons">
                            <span>Temporada <?= $series->fixSeasonLevel($series->getSeasonLevel()) ?></span>
                        </div>
                        <div class="overlayer"></div>
                        <div class="more_options">
                            <div class="scrollabe">
                                <ul>
                                    <?php for ($i = 0; $i < count($season_list); $i++) { ?>
                                        <li>
                                            <a href="<?= $series->createUrl($series->getSerieUrl(), $season_list[$i]['short_key']) ?>">Temporada <?= $series->fixSeasonLevel($season_list[$i]['season_level']) ?></a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-sm-12">

                    <div class="season-posts">

                        <?php if (!empty($list)) { ?>
                            <div class="owl-carousel seasons-articles">
                                <?php

                                for ($i = 0;
                                     $i < count($list);
                                     $i++) {
                                    ?>
                                    <div class="season-widget-sml">
                                        <figure>
                                            <img src="<?= $static->loadBlog($list[$i]['cover_image']) ?>"
                                                 alt="<?= $list[$i]['title'] ?>">
                                        </figure>
                                        <div class="episode_level">
                                            Episódio <?= $series->fixSeasonLevel($list[$i]['episode']) ?>
                                        </div>

                                        <div class="title_serie">
                                            <?= $text->utf8($list[$i]['title']) ?>
                                        </div>
                                        <div class="read_time_serie">
                                            <i class="far fa-clock"></i> <?= $text->readingTime($list[$i]['content_html']) ?>
                                            minutos
                                        </div>

                                        <?php if (!$session->isLogged()) { ?>
                                            <a href="<?= LOGIN_URL ?>?next=<?= $url->getActualURLAsNext() ?>"
                                               class="btn serie-view" style="display: block;margin: 20px 0">
                                                <i class="far fa-lock-alt"></i> Acessar Conteúdo
                                            </a>
                                        <?php } elseif (!$license->userCanAccessByKey($list[$i]['permission_key'])) { ?>
                                            <a href="<?= SERVER_ADDRESS ?>assinatura?ref=series&src=<?= md5($series->getIdSerie()) ?>&utm_source=series_view&utm_medium=premium_content_btn"
                                               class="btn serie-view" style="display: block;margin: 20px 0">
                                                <i class="far fa-star"></i> Assine Premium para Acessar
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?= $series->createContentURL($series->getSerieUrl(), $season_list[$i]['short_key'], $list[$i]['id_serie_season_content'], $list[$i]['title']) ?>"
                                               class="btn serie-view" style="display: block;margin: 20px 0">
                                                <i class="far fa-lock-open-alt"></i> Acessar Conteúdo
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="full-continue-btn-container">
                                <button>Mais sobre Marketing Digital <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        <?php } else { ?>

                            <div class="no-content-block">
                                <i class="far fa-books"></i>
                                <p>Ainda nada por aqui, mas já estamos preparando tudo...</p>
                            </div>

                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>