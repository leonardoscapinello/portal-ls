<div class="mp-main-menu">
    <a href="<?= SERVER_ADDRESS ?>" aria-current="page" class="mp-logo w-nav-brand w--current">
        <img src="<?= $static->load("leonardo-scapinello-white-background.svg"); ?>" width="38"
             height="38" alt="" class="mp-image-logo">
    </a>
    <a href="#" class="w--current show-nm nav-bars">
        <i class="far fa-bars"></i>
    </a>
    <nav role="navigation" class="nav-menu w-clearfix w-nav-menu">
        <a href="#" class="mp-menu-link mp-white w-nav-link mobile hide-nm"><i class="far fa-arrow-left"></i> Voltar</a>
        <a href="<?= SERVER_ADDRESS ?>blog/marketing/" class="mp-menu-link mp-white w-nav-link">Marketing</a>
        <a href="<?= SERVER_ADDRESS ?>blog/direito-digital/"
           class="mp-menu-link mp-white w-nav-link">Direito Digital</a>
        <a href="<?= SERVER_ADDRESS ?>blog/customer-experience/"
           class="mp-menu-link mp-white w-nav-link">Customer Experience</a>
       <!-- <a href="<?= SERVER_ADDRESS ?>blog/sua-empresa-online/"
           class="mp-menu-link mp-white w-nav-link">Sua Empresa Online</a>
        <a href="<?= SERVER_ADDRESS ?>consultoria" class="mp-menu-link mp-white w-nav-link">Consultoria</a> -->
        <?php if (!$license->isPremium()) { ?>
            <a href="<?= SERVER_ADDRESS ?>assinatura" class="mobile mp-menu-link mp-white w-nav-link"><i class="far fa-star"></i>Assinatura Premium</a>
        <?php } ?>


        <?php if ($session->isLogged()) { ?>
                <a href="<?= SERVER_ADDRESS ?>perfil" class="mp-menu-link mp-white w-nav-link w-separator"><i
                            class="far fa-user"></i><?= $account->getFirstName() ?></a>
        <?php } else { ?>
            <a href="<?= SERVER_ADDRESS ?>login" class="mp-menu-link mp-white w-nav-link w-separator">Fazer Login</a>
        <?php } ?>

        <div class="div-block-106 div-block-107 mp-line"></div>

        <?php if (!$license->isPremium()) { ?>
            <a href="<?= SERVER_ADDRESS ?>assinatura"
               class="mp-menu-unlim mp-white w-nav-link">Acesso Ilimitado</a>
        <?php }else{ ?>
            <a href="<?= SERVER_ADDRESS ?>perfil?t=downloads#downloads"
               class="mp-menu-unlim mp-white w-nav-link">Meus Downloads</a>
        <?php } ?>
    </nav>
</div>