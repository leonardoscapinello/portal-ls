<?php
$list = $contents->getContentsList("ct.id_category = 1", 6);
?>
<section>
    <div class="section white-bg top-separator">
        <div class="container">
            <h3 class="text dark featured-title">Marketing Digital</h3>

            <div class="home-posts">
                <div class="row no-left">
                    <?php if (count($list) > 0) { ?>
                        <div class="owl-carousel blog-carousel">
                            <?php

                            for ($i = 0; $i < count($list); $i++) {
                                ?>
                                <div class="post-widget-sml">
                                    <a href="<?= $list[$i]['content_url'] ?>">
                                        <figure>
                                            <img src="<?= $static->loadBlog($list[$i]['cover_image']) ?>"
                                                 alt="<?= $list[$i]['title'] ?>">
                                        </figure>
                                        <p class="category-flag"><?= $list[$i]['category_name'] ?></p>
                                        <?= $list[$i]['title'] ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="full-continue-btn-container">
                            <button>Mais sobre Marketing Digital <i class="fa fa-arrow-right"></i></button>
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