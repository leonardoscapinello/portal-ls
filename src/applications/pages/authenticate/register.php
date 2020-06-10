<?php

$first_name = get_request("first_name");
$last_name = get_request("last_name");
$phone = get_request("phone");
$username = get_request("username");
$password = get_request("password");

$message = "Crie sua conta gratuita e acesse conteúdo de seu interesse quando e onde você quiser.";
if (get_request("attempt") === base64_encode("0")) {
    header("location: " . LOGIN_URL . "?u=" . $text->base64_encode($username) . "&attempt=2");
}


if (get_request("action") === "register") {
    $r = $account->register($username, $first_name, $last_name, $password, $phone);
    if ($r > 0) {
        header("location: " . LOGIN_URL . "?u=" . $text->base64_encode($r));
        die;
    } else {
        header("location: " . REGISTER_URL . "?attempt=" . $text->base64_encode($r));
        die;
    }
}
?>
<form method="POST">
    <input type="hidden" name="action" value="register">
    <div class="section white-bg">
        <div class="container">
            <div class="row">
                <div class="offset-1"></div>
                <div class="col-xl-4 col-lg-4 col-sm-12">
                    <div class="login-box">
                        <div class="heading">
                            <h3>Essa é sua melhor decisão, aprender!</h3>
                            <h5>
                                <?=$message?>
                            </h5>
                        </div>
                        <div class="form">
                            <div class="input-d" style="width: 49%;display: inline-block">
                                <label>Nome</label>
                                <input type="text" name="first_name" id="first_name" value="<?= $first_name ?>"
                                       required>
                            </div>
                            <div class="input-d" style="width: 49%;display: inline-block">
                                <label>Sobrenome</label>
                                <input type="text" name="last_name" id="last_name" value="<?= $last_name ?>" required>
                            </div>
                            <div class="input-d">
                                <label>Endereço de E-mail</label>
                                <input type="email" name="username" id="username" value="<?= $username ?>" required>
                            </div>
                            <div class="input-d">
                                <label>Seu WhatsApp</label>
                                <input type="tel" name="phone" id="phone" class="phone phone_with_ddd"
                                       value="<?= $phone ?>" required>
                            </div>
                            <div class="input-d">
                                <label>Senha</label>
                                <input type="password" name="password" id="password" required>
                            </div>
                            <div class="input-d text right" style="text-align: right;margin-top: 10px">
                                <button class="dark">Criar uma Conta Grátis</button>
                            </div>
                            <div class="input-d" style="text-align: center;margin-top: 30px">
                                <a href="<?= LOGIN_URL ?>" style="margin-right: 30px;font-weight: 700;">Já tenho uma
                                    conta.
                                    Fazer Login.</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-sm-12">
                    <img src="<?= $static->load("customize-experience.png"); ?>"/>
                </div>
                <div class="offset-1"></div>
            </div>
        </div>
    </div>
</form>