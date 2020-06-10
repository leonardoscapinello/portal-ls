<?php
if (!function_exists('notempty')) {
    include("../../../properties/index.php");
}

$username = get_request("u");
$auth = get_request("auth");
$email = get_request("email");
if (notempty($username)) {
    $username = $text->base64_decode($username);
    $id_account = $account->getIdAccountByEmailOrUsername($username);
    if (notempty($id_account)) {
        $tmp_acc = new Accounts($id_account);
        if (!$tmp_acc->userExists()) {
            header("location:" . REGISTER_URL);
            die;
        } else {

            $email = $tmp_acc->getEmail();
            $base64_email = $text->base64_encode($email);
            $looked_auth = strtoupper(substr(md5($base64_email), 0, 6));
            if (notempty($auth)) {
                if ($auth === $looked_auth) {
                    header("location: " . FINISH_REGISTER_URL . "?u=" . $base64_email . "&auth=" . md5($tmp_acc->getIdAccount()));
                    die;
                }
            }


        }
    }
} else {
    //header("location:" . REGISTER_URL);
    //die;
}

?>

<div class="section white-bg">
    <div class="container">
        <div class="row">
            <div class="offset-1"></div>
            <div class="col-xl-4 col-lg-4 col-sm-12">
                <div class="login-box">
                    <div class="heading">
                        <h3>Vamos concluir agora?</h3>
                        <h5>
                            Enviamos um e-mail para você em <b class="text pink"><?= $email ?></b>, com um código para
                            continuarmos seu cadastro e definir uma
                            senha à sua conta.
                        </h5>
                    </div>
                    <form action="" method="POST">
                        <div class="form">
                            <input type="hidden" name="username" id="username" value="<?= $email ?>">
                            <div class="input-d">
                                <label for="auth">Qual o código que você recebeu?</label>
                                <input type="text" name="auth" id="auth" value="" required>
                            </div>
                            <div class="input-d text right" style="text-align: right;margin-top: 10px">
                                <button class="dark">Continuar para Cadastro</button>
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