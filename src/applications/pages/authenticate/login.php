<?php
$action = get_request("action");
$id_user = get_request("u");
$username = "";
$message = "Sua conta, do seu jeito. Aprenda no seu tempo, sobre <span class=\"text pink\"> marketing, direito digital, tráfego e muito mais</span>.";
$email_get = get_request("e");
$email = get_request("username");
$password = get_request("password");

if (not_empty($email) && not_empty($password)) {
    $session->setUsername($email);
    $session->setPassword($password);
    $c = $session->createSession();
    $next = $text->base64_decode($next);
    if (!notempty($next)) $next = SERVER_ADDRESS;


    if ($c) {
        header("location: " . $next);
        die;
    } else {
        $url->removeQueryString(array("attempt"));
        header("location: " . $url->addQueryString(array("attempt" => "1", "e" => $text->base64_encode($email))));
        die;
    }
}

if (not_empty($id_user)) {
    $id_user = $text->base64_decode($id_user);
    $tmp_acc = new Accounts($id_user);
    if (!$tmp_acc->isActive()) {
        $url->setCustomUrl(FINISH_REGISTER_URL);
        header("location: " . $url->addQueryString(array("u" => $text->base64_encode($id_user), "next" => $next)));
        die;
    }
    $username = $tmp_acc->getEmail();
}

if (get_request("attempt") === "1") {
    $message = "<span class=\"text pink\">Usuário ou senha incorretos. Tente novamente.</span>";
} else if (get_request("attempt") === "2") {
    $message = "Verifiquei aqui, que você <span class=\"text pink\">já tem cadastro</span> com esse e-mail. Agora é só Fazer Login.";
}


if (!notempty($email_get) && notempty($email)) {
    $email_get = $email;
}
$email_get = $text->base64_decode($email_get);


?>
<div class="section white-bg">
    <div class="container">
        <div class="row">
            <div class="offset-1"></div>
            <div class="col-xl-4 col-lg-4 col-sm-12">
                <div class="login-box">
                    <div class="heading">
                        <h3>Acesse seu conteúdo</h3>
                        <h5>
                            <?= $message ?>
                        </h5>
                    </div>
                    <form action="<?= $url->removeQueryString(array("attempt", "e")) ?>" method="POST">
                        <div class="form">
                            <div class="input-d">
                                <label>E-mail</label>
                                <input type="email" name="username" id="username"
                                       value="<?= not_empty($username) ? $username : $email_get ?>">
                            </div>
                            <div class="input-d">
                                <label>Senha</label>
                                <input type="password" name="password" id="password">
                            </div>
                            <div class="input-d text right" style="text-align: right;margin-top: 10px">
                                <button class="dark">Fazer Login</button>
                            </div>
                            <div class="input-d" style="text-align: center;margin-top: 30px">
                                <a href="<?= REGISTER_URL ?>" style="margin-right: 30px;font-weight: 700;">Cadastre-se
                                    Grátis</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-sm-12">
                <img src="<?= $static->load("login-image.png"); ?>"/>
            </div>
        </div>
    </div>
</div>