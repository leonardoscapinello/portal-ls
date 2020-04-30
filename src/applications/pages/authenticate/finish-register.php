<?php
$action = get_request("action");
$id_user = get_request("u");

$username = "";
$phone = "";
$first_name = "";
$last_name = "";


if (not_empty($id_user)) {

    $id_user = $text->base64_decode($id_user);
    $tmp_acc = new Accounts($id_user);
    if ($tmp_acc->isActive()) {
        $url->setCustomUrl(LOGIN_URL);
        header("location: " . $url->addQueryString(array("u" => $text->base64_encode($id_user), "next" => $next)));
        die;
    }

    if ($action === "finish") {
        $first_name = get_request("first_name");
        $last_name = get_request("last_name");
        $phone = get_request("phone");
        $username = get_request("username");
        $password = get_request("password");
        $finished = $tmp_acc->update($id_user, $first_name, $last_name, $phone, $password, $username);
        if ($finished) {
            $url->setCustomUrl(LOGIN_URL);
            header("location: " . $url->addQueryString(array("u" => $id_user, "next" => $next)));
            die;
        }
    } else {
        $first_name = $tmp_acc->getFirstName();
        $last_name = $tmp_acc->getLastName();
        $phone = $tmp_acc->getPhoneNumber();
        $username = $tmp_acc->getEmail();
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
                        <h5>
                            Falta pouco para você ter uma conta aqui no portal e poder acessar conteúdos exclusivos.
                        </h5>
                    </div>
                    <form action="" method="GET">
                        <div class="form">

                            <input type="hidden" name="action" value="finish">
                            <input type="hidden" name="username" value="<?= $username ?>">
                            <input type="hidden" name="next" value="<?= $next ?>">
                            <input type="hidden" name="u" value="<?= $id_user ?>">


                            <div class="input-d">
                                <label>Nome</label>
                                <input type="text" name="first_name" id="first_name" value="<?= $first_name ?>"
                                       required>
                            </div>
                            <div class="input-d">
                                <label>Sobrenome</label>
                                <input type="text" name="last_name" id="last_name" value="<?= $last_name ?>" required>
                            </div>

                            <div class="input-d">
                                <label>Seu WhatsApp</label>
                                <input type="tel" name="phone" id="phone" class="phone_with_ddd" value="<?= $phone ?>"
                                       required>
                            </div>
                            <div class="input-d">
                                <label>Senha</label>
                                <input type="password" name="password" id="password" value="" required>
                            </div>
                            <div class="input-d text right" style="text-align: right;margin-top: 10px">
                                <button class="dark">Concluir meu Cadastro</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
            <div class="col-xl-7 col-lg-7 col-sm-12">
                <img src="<?= $static->load("technology.png"); ?>"/>
            </div>
            <div class="offset-1"></div>
        </div>
    </div>
</div>