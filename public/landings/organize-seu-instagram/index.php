<div class="section green ft-lead">
    <div class="container">
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-sm-12">

                <div class="company">
                    <img src="<?= $static->load("leonardo-scapinello-white-background.svg") ?>"/>
                </div>

                <div class="title-superior" data-0="opacity:1;" data-150="opacity:.3;">
                    GRÁTIS POR MAIS POUCO TEMPO
                </div>
                <h2 class="text white" data-0="opacity:1;" data-150="opacity:.3;">
                    O que postar amanhã? Resolvido!
                </h2>
                <p class="text white " data-0="opacity:1;" data-150="opacity:.3;">
                    Tenha acesso gratuito a essa planilha no Excel que te ajudará a organizar seu feed e entender o que
                    sua audiência está procurando.
                </p>
                <p class="text white " data-0="opacity:1;" data-150="opacity:.3;">
                    Preencha com os dados da sua publicação e tenha <b>acesso imediato aos números do seu perfil</b>
                </p>

                <img src="<?= $landing->loadAsset("notebook-dell-planilha.png") ?>" width="100%"
                     style="max-width: 100%;" class="personal-image"/>

            </div>
            <div class="offset-1"></div>
            <div class="col-xl-4 col-lg-4 col-sm-12">
                <form method="POST" action="<?= $landing->getPurchaseUrl() ?>">
                    <div class="form form-widget">

                        <h3>Preencha para receber a planilha grátis em seu e-mail</h3>

                        <div class="input-d">
                            <label for="first_name">Nome </label>
                            <input type="text" name="first_name" id="first_name" value="<?=$account->getFirstName()?>" placeholder="Primeiro Nome" required/>
                        </div>
                        <div class="input-d">
                            <label for="last_name">Sobrenome</label>
                            <input type="text" name="last_name" id="last_name" value="<?=$account->getLastName()?>" placeholder="Sobrenome" required/>
                        </div>
                        <div class="input-d">
                            <label for="phone">WhatsApp</label>
                            <input type="text" name="phone" id="phone" value="<?=$account->getPhoneNumber()?>" placeholder="WhatsApp" required/>
                        </div>
                        <div class="input-d">
                            <label for="email">E-mail que receberá a planilha</label>
                            <input type="text" name="email" id="email" value="<?=$account->getEmail()?>"
                                   placeholder="E-mail onde enviaremos a planilha" required/>
                        </div>
                        <div class="input-d last-btn">
                            <button class="dark">Receber Grátis</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="offset-1"></div>
        </div>
    </div>
</div>