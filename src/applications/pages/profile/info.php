<?php
if (!function_exists('notempty')) {
    include("../../../properties/index.php");
}
$id_user = get_request("u");
$first_name = get_request("first_name");
$last_name = get_request("last_name");
$email = get_request("email");
$phone = get_request("phone");
if ($id_user !== null && $email !== null && $phone !== null) {
    $u = $account->update($id_user, $first_name, $last_name, $phone, null, $email);
    if ($u) {
        header("Refresh: 0");
    }
}
?>
<div class="login-box">
    <form action="" method="POST">
        <input type="hidden" name="u" id="u" value="<?= $account->getIdAccount() ?>">
        <div class="form">
            <div class="col-xl-12 col-lg-12 col-sm-12">
                <h4>Dados Pessoais</h4>
            </div>
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
                        <label>Nome</label>
                        <input type="text" name="first_name" id="first_name" value="<?= $account->getFirstName() ?>"
                               required>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-sm-12">
                    <div class="input-d">
                        <label>Nome</label>
                        <input type="text" name="last_name" id="last_name" value="<?= $account->getLastName() ?>"
                               required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="input-d">
                        <label>Endereço de E-mail</label>
                        <input type="email" name="email" id="email" value="<?= $account->getEmail() ?>" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-sm-12">
                    <div class="input-d">
                        <label>Seu WhatsApp</label>
                        <input type="tel" name="phone" id="phone" class="phone_with_ddd"
                               value="<?= $account->getPhoneNumber() ?>" required>
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
                            <button class="dark block">Atualizar Perfil</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>