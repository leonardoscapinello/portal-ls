<?php
$category = $contents->getCategoryByURL($category_url);


$list = $contents->getContentsList("ct.id_category = " . $category['id_category'], "0,25");

?>
<div class="section white-bg">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7 col-sm-12">
                <p>Todo nosso conteúdo sobre</p>
                <h2 style="margin-top: -4px"><?= $text->utf8($category['category_name']); ?></h2>

                <?php if (count($list) > 0) {

                    ?>
                    <div class="search-results">
                        <?php for ($i = 0; $i < count($list); $i++) { ?>
                            <div class="s-result">
                                <div class="row">
                                    <div class="col-xl-2 col-lg-2 col-sm-12">
                                        <figure>
											<picture>
												<source srcset="<?= $static->loadBlog($list[$i]['cover_image']) ?>" type="image/webp">
												<img src="<?= $static->loadBlog($list[$i]['cover_image']) ?>"
                                                 alt="<?= $list[$i]['title'] ?>"
                                                 style="-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">
											</picture>
                                        </figure>
                                    </div>
                                    <div class="col-xl-8 col-lg-8 col-sm-12">
                                        <div class="s-title">
                                            <a href="<?= $list[$i]['content_url'] ?>"><?= $list[$i]['title'] ?></a>
                                        </div>
                                        <div class="s-desc"><?= $list[$i]['description'] ?></div>
                                    </div>
                                    <div class="col-xl-2 col-lg-2 col-sm-12 text right" style="text-align: right;">
                                        <a href="<?= $list[$i]['content_url'] ?>" class="btn dark">Ler</a>
                                    </div>
                                </div>
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
            <div class="col-xl-5 col-lg-5 col-sm-12">
                <img src="<?= $static->image("search.png", 400) ?>">
            </div>
        </div>
    </div>
</div>