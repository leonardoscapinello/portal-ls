
<header>
    <div class="collection-list-wrapper-8 w-dyn-list serie-header-view">
        <div class="w-dyn-items">
            <div style="background-image:url(<?= $image ?>);background-color:#000;"
                 class="mp-header-container w-dyn-item no-hh">
                <div class="black-overlay-gradient-radial"></div>
                <div data-collapse="medium" data-animation="default" data-duration="400" class="navbar-blur w-nav">
                    <?php require_once(DIRNAME . "../components/series/navigation.php"); ?>
                    <div class="w-nav-overlay" data-wf-ignore=""></div>
                </div>
                <div class="mp-header-content no-hh">
                    <div class="div-block-144">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-sm-12">
                                    <div class="tpmgr serie-brand">
                                        <img src="<?= $static->loadSeries($series->getSeasonBrand(), $series->getShortKey(), 250); ?>">
                                    </div>
                                    <ul class="presentation-season-info">
                                        <li>Temporada <?= $series->fixSeasonLevel($series->getSeasonLevel()) ?></li>
                                        <li>Episódio <?= $series->fixSeasonLevel($series->getEpisode()) ?></li>
                                    </ul>
                                    <div class="vw_serie_title">
                                        <h2><?= $text->utf8($contents->getTitle()) ?></h2>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>