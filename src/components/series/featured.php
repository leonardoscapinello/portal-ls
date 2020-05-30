<?php
$series = new Series();
$list = $series->getAllSeries();
?>
<section>
    <div class="section grey-bg top-separator">
        <div class="container">
            <h3 class="text dark featured-title">
                Lançamentos <img src="<?= $static->load("ls-series-black.svg") ?>" alt="LS Séries" width="100"
                                 style="margin-bottom: 20px;opacity: .7;position: relative;top: 7px;"/>
            </h3>

            <div class="home-posts">
                <div class="row no-left">
                    <?php if (count($list) > 0) { ?>
                        <div class="owl-carousel series-carousel">
                            <?php

                            for ($i = 0; $i < count($list); $i++) {
                                ?>
                                <div class="serie-widget-sml">
                                    <a href="<?= $series->createUrl($list[$i]['serie_url'], $list[$i]['short_key'], $list[$i]['season_title']) ?>">
                                        <figure>
                                            <img src="<?= $static->loadSeries($list[$i]['season_cover'], $list[$i]['short_key']) ?>"
                                                 alt="<?= $list[$i]['serie_name'] ?>">
                                        </figure>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="full-continue-btn-container">
                            <button>Mais Séries<i class="fa fa-arrow-right"></i></button>
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
</section>