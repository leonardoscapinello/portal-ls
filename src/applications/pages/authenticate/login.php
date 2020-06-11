<?php
$action = get_request("action");
$id_user = get_request("u");
$email = get_request("username");
$password = get_request("password");
$content_fire = get_request("content_fire");

$next = $text->base64_decode($next);

$username = "";
$message = "Sua conta, do seu jeito. Aprenda no seu tempo, sobre <span class=\"text pink\"> marketing, direito digital, tráfego e muito mais</span>.";
if ($content_fire === "download") $message = "Esse conteúdo é <span class=\"text pink\">reservado para assinantes</span>, entre com sua conta para continuar.";
if ($content_fire === "serie_episode") $message = "Acessar esse episódio é <span class=\"text pink\">exclusivo para membros</span>, entre com sua conta para continuar.";

if (notempty($id_user)) {
    $username = $id_user;
}

if (notempty($email) && !notempty($password)) {
    $username = $text->base64_decode($email);
    $id_account = $account->validateIdAccountBasedOnUniqueKey($username);

    if ($id_account < 1) {
        header("location: " . REGISTER_URL . "?username=" . $text->base64_encode($username) . "&content_fire=account_not_found_after_login_attempt&next=" . $text->base64_encode($next));
        die;
    }

    if (notempty($id_account)) {
        $tmp_acc = new Accounts($id_account);
        if (!$tmp_acc->isActive()) {
            $url->setCustomUrl(FINISH_REGISTER_URL);
            header("location: " . $url->addQueryString(array("u" => $text->base64_encode($id_account), "next" => $next)));
            die;
        }
    }

} elseif (notempty($email) && notempty($password)) {
    $session->setUsername($email);
    $session->setPassword($password);
    $c = $session->createSession();
    if (!notempty($next)) $next = SERVER_ADDRESS;

    if ($c) {
        header("location: " . $next);
        die;
    } else {
        $url->removeQueryString(array("attempt"));
        header("location: " . $url->addQueryString(array("attempt" => "1", "u" => $text->base64_encode($email))));
        die;
    }
}

if (get_request("attempt") === "1") {
    $message = "<span class=\"text pink\">Usuário ou senha incorretos. Tente novamente.</span>";
} else if (get_request("attempt") === "2") {
    $message = "Verifiquei aqui, que você <span class=\"text pink\">já tem cadastro</span> com esse e-mail. Agora é só Fazer Login.";
}


?>
<div class="section white-bg">
    <div class="container">
        <div class="row">
            <div class="offset-1"></div>
            <div class="col-xl-4 col-lg-4 col-sm-12">
                <div class="login-box">
                    <div class="heading">
                        <?php if ($content_fire === "download") { ?>
                            <h3>Seu download já está pronto.</h3>
                        <?php } else { ?>
                            <h3>Acesse seu conteúdo</h3>
                        <?php } ?>
                        <h5><?= $message ?></h5>
                    </div>
                    <form action="<?= $url->removeQueryString(array("attempt", "e")) ?>" method="POST">
                        <div class="form">
                            <div class="input-d">
                                <label>E-mail</label>
                                <input type="email" name="username" id="username"
                                       value="<?= $username ?>">
                            </div>
                            <?php if (notempty($username)) { ?>
                                <div class="input-d">
                                    <label>Senha</label>
                                    <input type="password" name="password" id="password">
                                </div>
                            <?php } ?>
                            <?php if (notempty($username)) { ?>
                                <div class="input-d text right" style="text-align: right;margin-top: 10px">
                                    <button class="dark">Fazer Login</button>
                                </div>
                            <?php } else { ?>
                                <div class="input-d text right" style="text-align: right;margin-top: 10px">
                                    <button class="dark">Continuar para senha</button>
                                </div>
                            <?php } ?>
                            <div class="input-d" style="text-align: center;margin-top: 30px">
                                <a href="<?= REGISTER_URL ?>?next=<?= $text->base64_encode($next) ?>" style="margin-right: 30px;font-weight: 700;">Cadastre-se
                                    Grátis</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-sm-12">
                <img src="<?= $static->image("login-image.png", 400); ?>"/>
            </div>
        </div>
    </div>
</div>