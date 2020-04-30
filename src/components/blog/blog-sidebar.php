<?php
$related = $contents->getRelatedContents();
?>
<div class="row">
    <h4 style="font-family: 'Gilroy', sans-serif;color: #000;">Continue Aprendendo:</h4>
    <div class="blog-carousel-side">
        <?php for ($x = 0; $x < count($related); $x++) { ?>
            <div class="post-widget-sml">
                <figure>
                    <img src="<?= $contents->getCoverImage($related[$x]['cover_image']) ?>"
                         alt="Wallpaper Macos Mojave">
                </figure>
                <p class="category-flag"><?= $related[$x]['category_name'] ?></p>
                <a href="<?= $related[$x]['content_url'] ?>"><?= $related[$x]['title'] ?>
                </a>
            </div>
        <?php } ?>
    </div>
</div>
