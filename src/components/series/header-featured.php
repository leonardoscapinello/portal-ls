<?php
$featured = new Series();
$featured->loadRandomSerie();
?>

<header>
    <div class="collection-list-wrapper-8 w-dyn-list">
        <div class="w-dyn-items">
            <div style="background-image:url(<?= $static->loadSeries($featured->getSeasonBg(), $featured->getShortKey(),960) ?>);background-color:#000"
                 class="mp-header-container w-dyn-item">
                <div class="black-overlay-gradient"></div>
                <div data-collapse="medium" data-animation="default" data-duration="400" class="navbar-blur w-nav">
                    <?php require_once(DIRNAME . "../components/series/navigation.php"); ?>
                    <div class="w-nav-overlay" data-wf-ignore=""></div>
                </div>
                <div class="mp-header-content">
                    <div class="div-block-178">
                        <div class="product-name mp-white">
                            TEMPORADA <?=$featured->fixSeasonLevel($featured->getSeasonLevel())?>
                        </div>
                        <div class="product-image mp-white">
                            <img src="<?= $static->loadSeries($featured->getSeasonBrand(), $featured->getShortKey(), 250) ?>"
                                 alt="Série: <?=$featured->getSeasonTitle()?>"/>
                        </div>
                        <div class="mp-hero-description">
                            <?=$text->utf8($featured->getSeasonDescription())?>
                        </div>
                        <a href="<?=$featured->createUrl($featured->getSerieUrl(), $featured->getShortKey())?>" class="mp-header-button w-button">
                            Acessar Temporada
                        </a>
                    </div>
                    <a href="#products" class="mp-arrow-scroll w-inline-block"><img
                                src="<?= $static->load("arrow-big.svg"); ?>" alt="" class="image-1009"></a>
                </div>
            </div>
        </div>
    </div>
</header>