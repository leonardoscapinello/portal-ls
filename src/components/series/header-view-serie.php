<?php
$series = new Series();
$serie_url = get_request("serie_url");
if (!notempty($serie_url)) {
    header("location: " . SERVER_ADDRESS . "series");
    die;
}
$serie_info = $series->getLastSeasonInfoBySerieURL($serie_url);
if (empty($serie_info)) {
    header("location: " . SERVER_ADDRESS . "series");
    die;
}

$days_to_launch = $date->getDaysOfDifference(date("Y-m-d"), $serie_info['launch_date']);
?>
<header>
    <div class="collection-list-wrapper-8 w-dyn-list serie-header-view">
        <div class="w-dyn-items">
            <div style="background-image:url(<?= $static->loadSeries($serie_info['season_bg'], $serie_info['short_key']); ?>);background-color:#000;"
                 class="mp-header-container w-dyn-item">
                <div class="black-overlay-gradient"></div>
                <div data-collapse="medium" data-animation="default" data-duration="400" class="navbar-blur w-nav">
                    <?php require_once(DIRNAME . "../components/series/navigation.php"); ?>
                    <div class="w-nav-overlay" data-wf-ignore=""></div>
                </div>
                <div class="mp-header-content">
                    <div class="div-block-960">
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-sm-12">
                                    <div class="mbrand medium"
                                         style="background-image:url('<?= $static->loadSeries($serie_info['season_cover'], $serie_info['short_key']); ?>')"></div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-sm-12">
                                    <div class="serie-brand">
                                        <img src="<?= $static->loadSeries($serie_info['season_brand'], $serie_info['short_key']); ?>">
                                    </div>
                                    <ul class="presentation-season-info">
                                        <li>Temporada <?= $serie_info['season_level'] ?></li>
                                        <li><?= $date->stringMonthAndYear($serie_info['launch_date']) ?></li>
                                    </ul>
                                    <div class="sinopsis">
                                        <p><?= $text->utf8($serie_info['season_description']) ?></p>
                                    </div>
                                    <div class="action-btn" style="margin-top: 30px">
                                        <?php if ($days_to_launch > 0) { ?>
                                            <a class="btn serie-view"><i class="far fa-bell"></i> Avise-me quando lançar</a>
                                        <?php } elseif (!$session->isLogged()) { ?>
                                            <a href="<?= SERVER_ADDRESS ?>assinatura?ref=series&src=<?= md5($serie_info['id_serie_season']) ?>&utm_source=series_view&utm_medium=premium_middle_btn"
                                               class="btn serie-view">
                                                <i class="far fa-user"></i>
                                                Faça Login para Continuar
                                            </a>
                                            <div style="height: 12px;"></div>
                                            <a href="<?= LOGIN_URL ?>?next=<?= $url->getActualURLAsNext() ?>"
                                               class="btn clean-white">
                                                <i class="far fa-user"></i>
                                                Cadastre-se Grátis
                                            </a>
                                        <?php } else { ?>

                                            <?php if (!$license->userCanAccessByKey($serie_info['permission_key'])) { ?>
                                                <a href="<?= SERVER_ADDRESS ?>assinatura?ref=series&src=<?= md5($serie_info['id_serie_season']) ?>&utm_source=series_view&utm_medium=premium_middle_btn"
                                                   class="btn serie-view"><i class="far fa-star"></i>
                                                    Assine Premium para Continuar
                                                </a>
                                            <?php } else { ?>
                                                <a href="#seasons"
                                                   class="btn serie-view"><i class="far fa-chevron-down"></i>
                                                    Ver Temporadas
                                                </a>
                                            <?php } ?>

                                        <?php } ?>
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