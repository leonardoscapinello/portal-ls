<?php
if (!function_exists('notempty')) {
    include("../../../properties/index.php");
}
$attempt = "";
$id_user = get_request("u");
$password = get_request("password");
$cpassword = get_request("cpassword");
if ($id_user !== null && $password !== null && $cpassword !== null) {
    $u = $account->resetPassword($password, $cpassword);
    if ($u) {
        header("location: " . LOGIN_URL . "?next=" . $url->getActualURLAsNext());
        die;
    } else {
        $attempt = "Não foi possível atualizar sua senha, verifique se ambas estão iguais.";
    }
}
?>
<div class="login-box">
    <form action="" method="POST">
        <input type="hidden" name="u" id="u" value="<?= $account->getIdAccount() ?>">
        <div class="form">
            <div class="col-xl-12 col-lg-12 col-sm-12">
                <h4>Segurança</h4>
            </div>
            <p><?= $attempt ?></p>

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="input-d">
                        <label>Nome de Usuário</label>
                        <b><?= $account->getUsername() ?></b>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-sm-12">
                    <div class="input-d">
                        <label>Senha</label>
                        <input type="password" name="password" id="password" value="" minlength="6" required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-sm-12">
                    <div class="input-d">
                        <label>Confirme a nova senha</label>
                        <input type="password" name="cpassword" id="cpassword" value="" minlength="6" required>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="input-d">
                        <p>Para garantir sua segurança, ao alterar sua senha você será <b>desconectado de todas as
                                sessões ativas</b>, incluindo essa.
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-8 col-lg-8 col-sm-12">
                    <p class="text half-size " style="margin-top: 20px"><i class="far fa-shield"></i> Suas informações
                        estão seguras.</p>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-12">
                    <div class="input-d">
                        <div class="input-d text right" style="text-align: right;margin-top: 10px">
                            <button class="dark block">Alterar Senha</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>