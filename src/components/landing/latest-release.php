<?php $list = $contents->getContentsList(null, 4, "ct.insert_time DESC"); ?>
<section>
    <div class="section white-bg">
        <div class="container">

            <h5 class="text dark featured-title">Últimos Lançamentos</h5>

            <div class="row featured-posts">

                <div class="col-xl-4 col-lg-4 col-sm-12">
                    <?php if (!$session->isLogged()) { ?>

                        <h5>Cadastre-se, é grátis.</h5>
                        <p class="text dark">Seja notificado sempre que lançarmos um novo conteúdo e não fique de fora
                            do universo digital.</p>
                        <?php require(DIRNAME . "../components/landing/newsletter-widget.php"); ?>
                        <br/>
                        <br/>

                    <?php } else { ?>

                        <h4><?= $account->getFirstName() ?>,</h4>
                        <p class="text dark">
                            Aqui estão os artigos que lançamos recentemente e dispertou interesse de outros membros com
                            preferencias parecidas com a sua.
                        </p>
                        <h6>Conteúdo novo toda semana, não fique de fora.</h6>


                    <?php } ?>
                </div>
                <div class="offset-1"></div>
                <div class="col-xl-7 col-lg-7 col-sm-12">
                    <div class="row ">
                        <?php if (count($list) > 0) { ?>
                            <div class="owl-carousel blog-carousel">

                                <?php

                                for ($i = 0; $i < count($list); $i++) {
                                    ?>

                                    <div class="post-widget-sml">
                                        <figure>
                                            <img src="<?= $static->loadBlog($list[$i]['cover_image']) ?>"
                                                 alt="<?= $list[$i]['title'] ?>">
                                        </figure>
                                        <p class="category-flag"><?= $list[$i]['category_name'] ?></p>
                                        <a href="<?= $list[$i]['content_url'] ?>">
                                            <?= $list[$i]['title'] ?>
                                        </a>
                                    </div>

                                <?php } ?>


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