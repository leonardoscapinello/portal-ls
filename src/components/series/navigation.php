<div class="mp-main-menu">
    <a href="<?= SERVER_ADDRESS ?>" aria-current="page" class="mp-logo w-nav-brand w--current">
        <img src="<?= $static->load("ls-series-white.svg"); ?>" width="84"
             height="38" alt="" class="mp-image-logo">
    </a>
    <nav role="navigation" class="nav-menu w-clearfix w-nav-menu">
        <a href="<?= SERVER_ADDRESS ?>" class="mp-menu-link mp-white w-nav-link">Home</a>
        <a href="<?= SERVER_ADDRESS ?>series/launch"
           class="mp-menu-link mp-white w-nav-link">Lançamentos</a>



        <div class="div-block-106 div-block-107 mp-line"></div>

        <?php if (!$session->isLogged()) { ?>
            <a href="<?= SERVER_ADDRESS ?>login"
               class="mp-menu-unlim mp-white w-nav-link">Fazer Login</a>
        <?php } else { ?>
            <a href="<?= SERVER_ADDRESS ?>perfil?t=info#info"
               class="mp-menu-unlim mp-white w-nav-link">Minha Conta</a>
        <?php } ?>
    </nav>
</div>