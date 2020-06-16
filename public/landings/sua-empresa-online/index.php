<?php
$file_path = dirname(__FILE__) . "/coupons.txt";
$lines_array = file($file_path);
$value = 100;
if (count($lines_array) > 0) {
    $value = $lines_array[0];
}
if ($value <= 0) {
    $expired = true;
}
?>

<div class="section seo">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-sm-12">
                <div class="branding">
                    <img src="<?= $static->load("imagotipo.svg") ?>" alt="logotipo LS"/>
                </div>
                <h1>
                    A forma <span class="blue-text tochange"></span> para você atender online usando ferramentas
                    gratuitas
                </h1>
                <p>Adquira agora esse e-book com o passo a passo necessário para você começar um negócio no mundo
                    digital.</p>
            </div>
            <div class="offset-1"></div>
            <div class="col-xl-5 col-lg-5 col-sm-12">
                <div class="video-frame">
                    <video autoplay="1" class="_8mnz" id=""
                           poster=""
                           height=""
                           autoplay="autoplay"
                           videopollinterval="100" muted="1" playsinline="1">
                        <source src="<?= $landing->loadAsset("media/shopping-online.mp4") ?>"
                                type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section seo">
    <div class="container">
        <div class="row">
            <div class="offset-3"></div>
            <div class="col-xl-6 col-lg-6 col-sm-12 center">
                <h3 class="center">
                    Falta de conhecimento não é mais uma desculpa
                </h3>
                <p>Você não precisa entender de tecnologia ou ser um expert em computador para começar agora. Te explico
                    com imagens ao lado de cada passo, para te guiar até o resultado.</p>
            </div>
            <div class="offset-3"></div>
        </div>
    </div>
</div>


<div class="section big-itens">
    <div class="container">

        <?php
        $osname = $browser->getPlatform();
        if ($osname !== "Android" || $osname !== "iOS") $osname = "smartphone";
        ?>

        <div class="center">
            <h2>Seu <?= $osname ?> é tudo o que você precisa</h2>
        </div>

        <div class="row center">
            <div class="offset-1"></div>
            <div class="col-xl-5 col-lg-5 col-sm-12">
                <img src="<?= $landing->loadAsset("images/ilustracao-3d-botao-comprar.png") ?>" alt="Ilustração 3D"
                     class="size-img">
                <p style="margin-top: 30px;">Você só precisa de um smartphone conectado a internet para começar. É tão
                    simples quanto parece.</p>
            </div>
            <div class="col-xl-5 col-lg-5 col-sm-12">
                <img src="<?= $landing->loadAsset("images/ilustracao-3d-botao-comprar2.png") ?>" alt="Ilustração 3D">
                <p style="margin-top: 30px;">Você vai aprender a criar reuniões online, organizar as tarefas do dia para
                    não se atrasar a nenhuma
                    delas e ainda, criar e configurar uma conta de negócios no WhatsApp.</p>
            </div>
            <div class="offset-1"></div>
        </div>

    </div>
</div>


<div class="section seo">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-sm-12 center">
                <h2 class="center">
                    Ative o cupom com 90% desconto e pague apenas <br /><b>R$ 1,90</b> por esse e-book
                </h2>

                <p>Apenas <b class="blink"><span id="coupons"><?= $value+1 ?></span> cupons</b> de descontos disponíveis.
                </p>

                <form method="POST" action="<?= $landing->getPurchaseUrl() ?>">
                    <div class="form form-widget">
                        <div class="input-d" style="width: 49%;display: inline-block">
                            <label for="first_name">Nome </label>
                            <input type="text" name="first_name" id="first_name"
                                   value="<?= $account->getFirstName() ?>"
                                   placeholder="Primeiro Nome" required/>
                        </div>
                        <div class="input-d" style="width: 49%;display: inline-block">
                            <label for="last_name">Sobrenome</label>
                            <input type="text" name="last_name" id="last_name"
                                   value="<?= $account->getLastName() ?>"
                                   placeholder="Sobrenome" required/>
                        </div>
                        <div class="input-d">
                            <label for="phone">WhatsApp</label>
                            <input type="text" name="phone" id="phone" value="<?= $account->getPhoneNumber() ?>"
                                   placeholder="WhatsApp" required/>
                        </div>
                        <div class="input-d">
                            <label for="email">E-mail que receberá o desconto</label>
                            <input type="text" name="email" id="email" value="<?= $account->getEmail() ?>"
                                   placeholder="E-mail onde enviaremos a planilha" required/>
                        </div>
                        <div class="input-d last-btn">
                            <button class="dark">Ativar Cupom de Desconto</button>
                        </div>
                    </div>
                </form>

            </div>
            <div class="col-xl-6 col-lg-6 col-sm-12">
                <img src="<?= $landing->loadAsset("images/ebook-cover.png") ?>"
                     alt="imagem meramente ilustrativa do ebook" style="border-radius: 5px;margin: 20px 0"/>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.setInterval(function () {
        $("#coupons").load("./file/sua-empresa-online/coupons.txt", {cache: false});
    }, 6000);
</script>