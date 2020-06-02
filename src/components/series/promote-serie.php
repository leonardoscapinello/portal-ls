<?php
$featured = new Series();
$featured->loadRandomFutureSerie();
if ($featured->isExists()) {
    ?>
    <div class="series-promoshow">
        <div class="container">

            <h3 class="text dark featured-title" align="center"> Estreia em <?= $date->stringMonthAndYear($featured->getLaunchDate()) ?> </h3>


            <div class="row">


                <div class="offset-1"></div>
                <div class="col-xl-5 col-lg-5 col-sm-12">
                    <div class="mbrand medium"
                         style="background-image:url('<?= $static->loadSeries($featured->getSeasonCover(), $featured->getShortKey()) ?>')"></div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-12 mobile-center">
                    <img src="<?= $static->loadSeries($featured->getSeasonBrand(), $featured->getShortKey()) ?>"
                         alt="Série: <?= $featured->getSeasonTitle() ?>" class="serie-brand"/>
                    <ul class="presentation-season-info">
                        <li style="font-weight: 600;">
                            TEMPORADA <?= $featured->fixSeasonLevel($featured->getSeasonLevel()) ?></li>
                        <li>Estreia em <?= $date->stringMonthAndYear($featured->getLaunchDate()) ?></li>
                    </ul>
                    <div class="sinopsis">
                        <p>
                            <?= $text->utf8($featured->getSeasonDescription()) ?>
                        </p>
                    </div>
                </div>
                <div class="offset-2"></div>
            </div>
        </div>
    </div>
<?php } ?>