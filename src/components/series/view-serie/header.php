<?php
$days_to_launch = $date->getDaysOfDifference(date("Y-m-d"), $series->getLaunchDate());
?>
<header>
    <div class="collection-list-wrapper-8 w-dyn-list serie-header-view">
        <div class="w-dyn-items">
            <div style="background-image:url(<?= $static->loadSeries($series->getSeasonBg(), $series->getShortKey(), 1400); ?>);background-color:#000;"
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
                                <div class="col-xl-6 col-lg-6 col-sm-12 desktop">
                                    <div class="mbrand medium"
                                         style="background-image:url('<?= $static->loadSeries($series->getSeasonCover(), $series->getShortKey(), 320); ?>')"></div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-sm-12">
                                    <div class="tpmgr serie-brand">
                                        <img src="<?= $static->loadSeries($series->getSeasonBrand(), $series->getShortKey()); ?>">
                                    </div>
                                    <ul class="presentation-season-info">
                                        <li>Temporada <?= $series->getSeasonLevel() ?></li>
                                        <li><?= $date->stringMonthAndYear($series->getLaunchDate()) ?></li>
                                    </ul>
                                    <div class="sinopsis">
                                        <p><?= $text->utf8($series->getSeasonDescription()) ?></p>
                                    </div>
                                    <div class="action-btn" style="margin-top: 30px">
                                        <?php if ($days_to_launch > 0) { ?>
                                            <a class="btn serie-view"><i class="far fa-bell"></i> Avise-me quando lançar</a>
                                        <?php } elseif (!$session->isLogged()) { ?>
                                            <a href="<?= LOGIN_URL ?>?next=<?= $url->getActualURLAsNext() ?>"
                                               class="btn serie-view">
                                                <i class="far fa-user"></i>
                                                Faça Login para Continuar
                                            </a>
                                            <div style="height: 12px;"></div>
                                            <a href="<?= REGISTER_URL ?>?next=<?= $url->getActualURLAsNext() ?>"
                                               class="btn clean-white">
                                                <i class="far fa-user"></i>
                                                Cadastre-se Grátis
                                            </a>
                                        <?php } else { ?>

                                            <?php if (!$license->userCanAccessByKey($series->getPermissionKey())) { ?>
                                                <a href="<?= SERVER_ADDRESS ?>assinatura?ref=series&src=<?= md5($series->getIdSerie()) ?>&utm_source=series_view&utm_medium=premium_middle_btn"
                                                   class="btn serie-view"><i class="far fa-star"></i>
                                                    Assine Premium para Continuar
                                                </a>
                                            <?php } else { ?>
                                                <a href="#seasons"
                                                   class="btn serie-view scrollTo"><i class="far fa-chevron-down"></i>
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