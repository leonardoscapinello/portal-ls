<?php
$external = new ExternalServiceList();

$first_name = get_request("first_name");
$last_name = get_request("last_name");
$email_address = get_request("email");
$phone = get_request("phone");

if (notempty($first_name) && notempty($last_name) && notempty($email_address) && notempty($phone)) {
    $external->setEmail($email_address);
    $external->setFirstName($first_name);
    $external->setLastName($last_name);
    $external->setPhone($phone);
    $external->subscribe();

    $custom_file_name = $url->friendly("planilha-para-instagram-de-" . $first_name);

    $reg = $account->register($email_address, $first_name, $last_name);
    if (!$reg) {
        header("location: ../organize-seu-instagram");
        die;
    }
} else {
    header("location: ../organize-seu-instagram");
    die;
}
?>

<div class="section green ft-lead">
    <div class="container">
        <div class="row">
            <div class="offset-3"></div>
            <div class="col-xl-6 col-lg-6 col-sm-12">

                <div class="company">
                    <img src="<?= $static->load("leonardo-scapinello-white-background.svg") ?>"/>
                </div>

                <form method="POST" action="<?= $landing->getPurchaseUrl() ?>">
                    <div class="form form-widget">

                        <h3>Parabéns!</h3>

                        <p>Você garantiu sua versão da planilha para <b>Organizar e Otimizar o Desepenho do seu
                                Instagram</b>.</p>

                        <div class="box-info">
                            <b>É necessário ter o excel instalado em seu dispositivo.</b> Se possível, acesse &agrave; partir
                            de um computador ou notebook.
                        </div>

                        <div class="input-d last-btn">
                            <a class="btn dark"
                               href="<?= SERVER_ADDRESS ?>get/20200605-organize-seu-instagram.xlsx/<?= $custom_file_name ?>"
                               target="_blank"><i
                                        class="far fa-file-download"></i> Baixar Planilha</a>
                        </div>

                        <p>Se você busca continuar aprendendo sobre marketing digital, empreendedorismo e como melhorar
                            o branding da sua marca na internet, acesse o canal VIP no Telegram.</p>

                        <p><b>É grátis.</b></p>

                        <div class="input-d last-btn">
                            <a class="btn dark" href="https://t.me/oleonardoscapinello" target="_blank"><i
                                        class="fab fa-telegram-plane"></i> Entrar no Grupo VIP</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="offset-1"></div>
        </div>
    </div>
</div>
