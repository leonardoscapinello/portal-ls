<?php if (!$session->isLogged()) { ?>
    <div class="section half-space green-bg"
         style="padding: 10px 0;position: fixed;bottom: 0;left: 0;z-index: 333;width: 100%;">
        <div class="container">
            <div align="center">
                <span></span>
                <button onClick="window.location.href = '<?= LOGIN_URL ?>';">Fazer Login</button>
                <a href="<?= REGISTER_URL ?>" style="color:#FFF;margin-left: 15px;font-weight: 700">Cadastre-se
                    Grátis.</a>
            </div>
        </div>
    </div>
<?php } ?>