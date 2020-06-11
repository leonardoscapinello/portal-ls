<?php
if (!function_exists('notempty')) {
    include("../../../properties/index.php");
}

$account_preference = new AccountsPreferences();
$updated = false;
$preferences = array();
if (get_request("action") === "preferences") {
    foreach ($_POST as $key => $value) {
        if (substr($key, 0, 5) === "PREF_") {
            array_push($preferences, $key);
        }
    }
    if (is_array($preferences) && count($preferences) > 0) {
        $updated = $account_preference->updatePreferences($preferences);
    }
}

if ($updated) {
    header("Refresh: 0");
    die;
}


?>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-sm-12">
        <h4>Privacidade</h4>
    </div>

    <form action="" method="POST">
        <input type="hidden" name="action" value="preferences"/>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-sm-12">


                <h6 style="font-size: 14px">Notificações por e-mail</h6>

                <div class="switch-form">
                    <div class="row switch-line">
                        <div class="col-xl-2-swt">
                            <label class="switch">
                                <input type="checkbox" <?= $account_preference->getPreferencesFieldsAttributes("PREF_NOTIFY_EMAIL_OFFERS") ?>>
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xl-10-swt">
                            <div class="switch-item-label">
                                <label for="PREF_NOTIFY_EMAIL_OFFERS">
                                    Lançamentos e Promoções
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row switch-line">
                        <div class="col-xl-2-swt">
                            <label class="switch">
                                <input type="checkbox" <?= $account_preference->getPreferencesFieldsAttributes("PREF_NOTIFY_EMAIL_SECURITY") ?>>
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xl-10-swt">
                            <div class="switch-item-label">
                                <label for="PREF_NOTIFY_EMAIL_SECURITY">
                                    Segurança e Atualizações
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


                <h6 style="font-size: 14px">Contato por Mensagem de Texto</h6>

                <div class="switch-form">
                    <div class="row switch-line">
                        <div class="col-xl-2-swt">
                            <label class="switch">
                                <input type="checkbox" <?= $account_preference->getPreferencesFieldsAttributes("PREF_NOTIFY_SMS_OFFERS") ?>>
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xl-10-swt">
                            <div class="switch-item-label">
                                <label for="PREF_NOTIFY_SMS_OFFERS">
                                    Lançamentos e Promoções
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row switch-line">
                        <div class="col-xl-2-swt">
                            <label class="switch">
                                <input type="checkbox" <?= $account_preference->getPreferencesFieldsAttributes("PREF_NOTIFY_SMS_SECURITY") ?>>
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xl-10-swt">
                            <div class="switch-item-label">
                                <label for="PREF_NOTIFY_SMS_SECURITY">
                                    Segurança e Atualizações
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 style="font-size: 14px">Contato por Ligação Telefônica</h6>
                <div class="switch-form">
                    <div class="row switch-line">
                        <div class="col-xl-2-swt">
                            <label class="switch">
                                <input type="checkbox" <?= $account_preference->getPreferencesFieldsAttributes("PREF_NOTIFY_PHONE_OFFERS") ?>>
                                <span></span>
                            </label>
                        </div>
                        <div class="col-xl-10-swt">
                            <div class="switch-item-label">
                                <label for="PREF_NOTIFY_PHONE_OFFERS">
                                    Lançamentos e Convites Promocionais
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row switch-line">
                        <div class="col-xl-2-swt">
                            <label class="switch ">
                                <input type="checkbox" <?= $account_preference->getPreferencesFieldsAttributes("PREF_NOTIFY_PHONE_SUPPORT") ?>
                                       checked disabled>
                                <span>
                                    <em></em>
                                </span>
                            </label>
                        </div>
                        <div class="col-xl-10-swt">
                            <div class="switch-item-label disabled">
                                <label for="PREF_NOTIFY_PHONE_SUPPORT">
                                    Atendimento de Suporte (padrão)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="input-d" style="margin-top: 23px">
                    <button class="dark ">Atualizar Preferências</button>
                </div>

            </div>
            <div class="col-xl-6 col-lg-6 col-sm-12">
                <img src="<?= $static->image("customize-experience.png", 400) ?>"/>
            </div>
        </div>
    </form>

</div>