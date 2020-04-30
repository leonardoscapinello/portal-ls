<?php if (!$session->isLogged()) { ?>

    <section>
        <div class="section white-bg top-separator">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-5 col-sm-12">
                        <img src="<?= $static->load("meditation-online.png") ?>"/>
                    </div>
                    <div class="offset-1"></div>
                    <div class="col-xl-6 col-lg-6 col-sm-12">
                        <h3>Estar online ainda parece algo de outro mundo? Relaxe!</h3>
                        <p>Estar online não é ter um site ou perfil no Instagram, é criar experiências e desejo nos
                            consumidores diariamente. <b>Receba gratuitamente nosso e-book que te ensinará como atuar
                                online, mesmo tendo uma empresa
                                100% física.</b></p>
                        <?php require(DIRNAME . "../components/landing/newsletter-widget.php"); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php } else { ?>

    <section>
        <div class="section white-bg top-separator">
            <div class="container">
                <div class="row">
                    <div class="offset-1"></div>
                    <div class="col-xl-4 col-lg-4 col-sm-12">
                        <img src="<?= $static->load("search.png") ?>"/>
                    </div>
                    <div class="offset-1"></div>
                    <div class="col-xl-6 col-lg-6 col-sm-12">
                        <h3>Você já sabe como iniciar uma operação <span class="text pink">online</span>?</h3>
                        <p>Preparamos um conteúdo online para te ensinar como colocar sua empresa online em poucos
                            passos e de forma simples. Organizamos as ferramentas mais populadores e confiaveis do
                            mercado para te ajudar nessa transição.</p>
                        <br />
                        <button class="dark">Fazer Download&nbsp;&nbsp;<i class="far fa-download"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php } ?>