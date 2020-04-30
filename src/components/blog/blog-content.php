<div id="bctn" class="blog-next-posts">
    <article class="post">
        <div class="section white-bg">
            <div class="blog-content">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-sm-12">
                            <div class="content-title text center">
                                <div class="category-flag-post" style="background:<?=$contents->getCategoryColor()?>"><?= $contents->getCategoryName() ?></div>
                                <h2><?= $contents->getTitle() ?></h2>
                            </div>
                            <div class="content-social-info">
                                <ul>
                                    <li><?= $author->getFullName(); ?></li>
                                    <li><?= $date->formatDatetime($contents->getInsertTime()) ?></li>
                                    <li><a href="#read"><?= $text->readingTime($contents->getContentHtml()) ?> minutos
                                            de
                                            leitura</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php if (notempty($contents->getCoverImage())) {
                        $rm = "margin-top:0;"; ?>
                        <div class="row">
                            <div class="offset-1"></div>
                            <div class="col-xl-10 col-lg-10 col-sm-12">
                                <div class="content-cover text center"
                                     style="background-image: url('<?= $contents->getCoverImage() ?>');margin-bottom: 30px"></div>
                            </div>
                            <div class="offset-1"></div>
                        </div>
                    <?php } else {
                        $rm = "margin-top:-11px;";
                    } ?>
                    <div class="content-blog-text-section" id="read" style="<?= $rm ?>">
                        <div class="row">
                            <div class="offset-1"></div>
                            <div class="col-xl-7 col-lg-7 col-sm-12">
                                <div class="check-for-view"></div>
                                <?php /* == USER CAN VIEW CONTENT */
                                if ($user_can_view) { ?>
                                    <div class="blog-content-ld">
                                        <?= $contents->getContentHtml() ?>
                                    </div>
                                    <?php if (!$session->isLogged()) { ?>
                                        <div class="row">
                                            <div class="blog-newsletter-block">
                                                <h3>Faça parte de nossa Lista VIP e receba as novidades por e-mail.</h3>
                                                <?php require("./src/components/landing/newsletter-widget.php") ?>
                                            </div>
                                        </div>
                                    <?php } else if (!$license->isPremium()) { ?>
                                        <div class="row">
                                            <div class="blog-premium-offer">
                                                <h3 class="text light">Você ainda não é Premium, torne-se agora com uma
                                                    condição
                                                    especial para você.</h3>
                                                <div class="price">
                                                    <div class="row">
                                                        <div class="col-xl-5 col-lg-5 col-sm-12">
                                                            <div class="p--name">Acesso Premium Mensal</div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 col-sm-12">
                                                            <div class="p--price">R$ 29,90</div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-sm-12 text right"
                                                             style="text-align: right">
                                                            <button>Assine Agora</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php /* == USER CAN'T VIEW CONTENT */
                                } else { ?>
                                    <div class="blog-content-ld">
                                        <?= $text->getFirstParagraph($contents->getContentHtml()) ?>
                                    </div>
                                    <?php if ($content_private_level === "3" || $content_private_level === 3) { ?>
                                        <div class="row">
                                            <div class="blog-premium-offer">
                                                <h3 class="text light">O conteúdo não acabou, assine premium para ter
                                                    acesso
                                                    completo.</h3>
                                                <div class="price">
                                                    <div class="row">
                                                        <div class="col-xl-5 col-lg-5 col-sm-12">
                                                            <div class="p--name">Acesso Premium Mensal</div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 col-sm-12">
                                                            <div class="p--price">R$ 29,90</div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-sm-12 text right"
                                                             style="text-align: right">
                                                            <button>Assine Agora</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="blog-newsletter-block">
                                            <h3>Crie uma conta gratuita para acessar esse conteúdo exclusivo para
                                                membros.</h3>
                                            <?php require("./src/components/landing/newsletter-widget.php") ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-sm-2">
                                <div class="sidebar">
                                    <?php require_once("./src/components/blog/blog-sidebar.php") ?>
                                </div>
                            </div>
                            <div class="offset-1"></div>
                        </div>
                    </div>
                    <div class="separator-dots"></div>
                </div>
            </div>
        </div>


        <?php
        $related = $contents->getNextRelatedContent();
        if (count($related) > 0) {
            ?>
            <a href="<?= $related['content_url'] ?>" class="pagination__next"
               data-iel="<?= $contents->getIdContent() ?>">Próxima
                Página</a>
        <?php } ?>

        <div class="nextpost-widget">
            <div class="image">
                <img src="<?= $contents->getCoverImage($related['cover_image']) ?>"/>
            </div>
            <div class="post-info">
                <span>Continue descendo para o próximo conteúdo</span>
                <b><?= $related['title'] ?></b>
            </div>
        </div>

    </article>
</div>

