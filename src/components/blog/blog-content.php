<?php

$views = $contentsViews->getViews();

?>
<?php if ($contents->isContentExists()) { ?>
    <div id="bctn" class="blog-next-posts">
        <article class="post">
            <div class="section white-bg">
                <div class="blog-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-sm-12">
                                <div class="content-title text center">
                                    <div class="category-flag-post"
                                         style="background:<?= $contents->getCategoryColor() ?>"><?= $contents->getCategoryName() ?></div>
                                    <h2><?= $contents->getTitle() ?></h2>
                                </div>
                                <div class="content-social-info">
                                    <ul>
                                        <li><?= $author->getFullName(); ?></li>
                                        <li><?= $date->formatDatetime($contents->getInsertTime()) ?></li>
                                        <li><?= $contentsViews->getViews() ?> visualizações</li>
                                        <li>
                                            <a href="#r<?= md5($contents->getIdContent() . $views) ?>"><?= $text->readingTime($contents->getContentHtml()) ?>
                                                minutos
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
                        <div class="content-blog-text-section" id="r<?= md5($contents->getIdContent() . $views) ?>"
                             style="<?= $rm ?>">
                            <div class="row">
                                <div class="offset-1"></div>
                                <div class="col-xl-7 col-lg-7 col-sm-12">

                                    <div class="sharebox">
                                        <ul>
                                            <li>Compartilhe:</li>
                                            <li><a href="<?= $contents->getShare__Facebook() ?>"
                                                   onclick="window.open(this.href, 'mywin', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"><i
                                                            class="fab fa-facebook"></i></a></li>
                                            <li><a href="<?= $contents->getShare__Twitter() ?>"
                                                   onclick="window.open(this.href, 'mywin', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"><i
                                                            class="fab fa-twitter"></i></a></li>
                                            <li><a href="<?= $contents->getShare__Linkedin() ?>"
                                                   onclick="window.open(this.href, 'mywin', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"><i
                                                            class="fab fa-linkedin"></i></a></li>
                                            <li><a href="<?= $contents->getShare__WhatsApp() ?>"
                                                   onclick="window.open(this.href, 'mywin', 'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"><i
                                                            class="fab fa-whatsapp"></i></a></li>
                                        </ul>
                                    </div>


                                    <div class="check-for-view"></div>
                                    <div class="blog-content-ld">
                                        <?= $contents->getContentHtml() ?>
                                    </div>
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
<?php } else { ?>
    <div class="section white-bg">
        <div class="container">
            <div class="row">
                <div class="offset-3"></div>
                <div class="col-xl-6 col-lg-6 col-sm-12 center" align="center">
                    <h3>Página não encontrada.</h3>
                    <p>Não conseguimos encontrar a página que você esta procurando.</p><br/>
                    <a href="<?= SERVER_ADDRESS ?>" class="btn btn-primary">Voltar ao Inicio</a>
                </div>
                <div class="offset-3"></div>
            </div>
        </div>
    </div>
<?php } ?>
