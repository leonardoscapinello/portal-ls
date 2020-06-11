<?php
/*
 *  AUTH TOKEN IS THE KEY SENT TO EMAIL AND MEANS 6 FIRST CHARACTERS AS: strtoupper(substr(md5($base64_email), 0, 6));
 *  VALIDATION TOKEN IS THE FULL MD5 OF ID ACCOUNT
 */

$action = get_request("action");
$id_user = get_request("u");
$token = get_request("auth");
$custom_source_request = get_request("req");


$username = "";
$phone = "";
$first_name = "";
$last_name = "";

$error_id = 0;
if (not_empty($id_user)) {

    $id_user = $text->base64_decode($id_user);
    $id_account = $account->validateIdAccountBasedOnUniqueKey($id_user);

    if (notempty($id_account)) {
        $tmp_acc = new Accounts($id_account);
        $base64_email = $text->base64_encode($tmp_acc->getEmail());

        // SE O USUÁRIO NÃO ESTIVER ATIVO, E TAMBÉM NÃO OUVER O TOKEN DE AUTORIZAÇÃO, ENVIA E REDIRECIONA PARA A PÁGINA DE CONTINUAÇÃO POR E-MAIL
        if ($tmp_acc->userExists() && !$tmp_acc->isActive() && $token !== md5($tmp_acc->getIdAccount())) {
            $auth_token = strtoupper(substr(md5($base64_email), 0, 6));
            if (notempty($base64_email)) {
                $email = new EmailNotification();
                $email->subject("Conclua seu cadastro agora mesmo.");
                $email->contact($tmp_acc->getFirstName(), $tmp_acc->getEmail());
                $email->paragraph("Tudo bem?");
                $email->paragraph("Vi que você tentou fazer login mas não havia concluido seu cadastro ainda, fique tranquilo, falta muito pouco para você acessar o conteúdo gratuito do site.");
                $email->paragraph("Apenas para garantir sua segurança, clique no botão abaixo e te levaremos ao formulário onde você continuará seu cadastro.");
                $email->button("Continuar Cadastro", FINISH_REGISTER_URL . "?u=" . $base64_email . "&auth=" . $auth_token);
                $email->paragraph("Caso necessário, seu código de continuação do cadastro é: <b>" . $auth_token . "</b>");
                $email->paragraph("Se o problema persistir, entre em contato com nosso suporte: suporte@lsgo.me");
                $email->paragraph("Até logo,");
                $email->paragraph("Leonardo.");
                $email->save();
                header("location: " . REGISTER_URL . "/email?u=" . $base64_email);
                die;
            }

        }


        if ($tmp_acc->isActive()) {
            $url->setCustomUrl(LOGIN_URL);
            header("location: " . $url->addQueryString(array("u" => $base64_email, "next" => $next)));
            die;
        }
        if ($action === "finish") {
            $first_name = get_request("first_name");
            $last_name = get_request("last_name");
            $phone = get_request("phone");
            $username = get_request("username");
            $password = get_request("password");
            $finished = $tmp_acc->update($tmp_acc->getIdAccount(), $first_name, $last_name, $phone, $password, $username);
            $error_id = $finished;
            if ($finished > 0) {
                $url->setCustomUrl(LOGIN_URL);
                header("location: " . $url->addQueryString(array("u" => $base64_email, "next" => $next, "auto" => "Y")));
                die;
            }
        } else {
            $first_name = $tmp_acc->getFirstName();
            $last_name = $tmp_acc->getLastName();
            $phone = $tmp_acc->getPhoneNumber();
            $username = $tmp_acc->getEmail();
        }
    }

} else {
    header("location: " . REGISTER_URL);
    die;
}


?>

<div class="section white-bg">
    <div class="container">
        <div class="row">
            <div class="offset-1"></div>
            <div class="col-xl-4 col-lg-4 col-sm-12">
                <div class="login-box">
                    <div class="heading">
                        <h3>Conclua seu cadastro agora mesmo.</h3>
                        <?php if ($error_id === -1) { ?>
                            <h5>Há um <span class="text pink">problema com seu e-mail</span>, por favor, entre em contato com o suporte.</h5>
                        <?php } elseif ($error_id === -2) { ?>
                            <h5>Por favor, preencha seu <span class="text pink">nome corretamente</span>.</h5>
                        <?php } elseif ($error_id === -3) { ?>
                            <h5>Por favor, preencha seu <span class="text pink">sobrenome corretamente.</span></h5>
                        <?php } elseif ($error_id === -4) { ?>
                            <h5>Por favor, preencha seu <span class="text pink">telefone corretamente.</span></h5>
                        <?php } else { ?>
                            <h5>Falta pouco para você ter uma conta aqui no portal e poder acessar conteúdos
                                exclusivos.</h5>
                        <?php } ?>
                    </div>
                    <form action="" method="POST">
                        <div class="form">

                            <input type="hidden" name="action" value="finish">
                            <input type="hidden" name="username" value="<?= $username ?>">
                            <input type="hidden" name="next" value="<?= $next ?>">
                            <input type="hidden" name="u" value="<?= $id_user ?>">
                            <input type="hidden" name="auth" value="<?= $token ?>">


                            <div class="input-d">
                                <label>Nome</label>
                                <input type="text" name="first_name" id="first_name" value="<?= $first_name ?>"
                                       minlength="1"  required>
                            </div>
                            <div class="input-d">
                                <label>Sobrenome</label>
                                <input type="text" name="last_name" id="last_name" minlength="1"
                                       value="<?= $last_name ?>" required>
                            </div>

                            <div class="input-d">
                                <label>Seu WhatsApp</label>
                                <input type="tel" name="phone" id="phone" class="phone_with_ddd" minlength="11" value="<?= $phone ?>"
                                       required>
                            </div>
                            <div class="input-d">
                                <label>Senha</label>
                                <input type="password" name="password" id="password" value="" minlength="8" required>
                            </div>
                            <div class="input-d text right" style="text-align: right;margin-top: 10px">
                                <button class="dark">Concluir meu Cadastro</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
            <div class="col-xl-7 col-lg-7 col-sm-12">
                <img src="<?= $static->image("technology.png", 400); ?>"/>
            </div>
            <div class="offset-1"></div>
        </div>
    </div>
</div>