<header>
    <div class="collection-list-wrapper-8 w-dyn-list">
        <div class="w-dyn-items">
            <div class="mp-header-container w-dyn-item negative--header">
                <div data-collapse="medium" data-animation="default" data-duration="400" class="navbar-blur w-nav">
                    <?php require_once("navigation.php"); ?>
                    <div class="w-nav-overlay" data-wf-ignore=""></div>
                </div>

            </div>
        </div>
    </div>
</header>

<?php if ($contents->getContentType() === "blog") { ?>
    <a href="<?= SERVER_ADDRESS ?>series/notes/3E3HQW?utm_source=blog&utm_medium=blog_top_banner">
        <div class="series-banner"
             style="background-image:url('<?= $static->image("../series/3E3HQW/banners/topbanner-bg.png") ?>')">
            <div class="banner-block">
                <img src="<?= $static->image("../series/3E3HQW/banners/topbanner.png") ?>" alt="Notes">
            </div>
        </div>
    </a>
<?php } ?>