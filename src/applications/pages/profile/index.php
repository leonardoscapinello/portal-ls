<?php
require_once(DIRNAME . "../applications/pages/authenticate/validate-session.php");
$load = false;
$tab = get_request("t") === null ? "info" : get_request("t");
if (notempty($tab)) {
    $app = "src/applications/pages/profile/" . $tab . ".php";
    if (file_exists($app)) {
        $load = true;
    }
}
?>
<div class="section white-bg">
    <div class="container">
        <div class="row">

            <div class="col-xl-3 col-lg-3 col-sm-12">

                <div class="profile-btn-wd profile-blocks">
                    <a href="#" onClick="ld('info');return false;" class="prof-btn active" data-hash="info" id="info_ac">
                        <i class="far fa-user"></i>
                        <span>Dados Pessoais</span>
                    </a>
                    <a href="#" onClick="ld('favorites');return false;" class="prof-btn" data-hash="favorites"
                       id="favorites_ac">
                        <i class="far fa-heart"></i>
                        <span>Favoritos</span>
                    </a>
                    <a href="#" onClick="ld('security');return false;" class="prof-btn" data-hash="security"
                       id="security_ac">
                        <i class="far fa-shield"></i>
                        <span>Segurança</span>
                    </a>
                    <a href="#" onClick="ld('privacy');return false;" class="prof-btn" data-hash="privacy"
                       id="privacy_ac">
                        <i class="far fa-lock"></i>
                        <span>Privacidade</span>
                    </a>
                    <?php if (!$license->isPremium()) { ?>
                        <a href="#" onClick="ld('signature');return false;" data-hash="signature" id="signature_ac"
                           class="prof-btn green">
                            <i class="far fa-chalkboard-teacher"></i>
                            <span>Acesso Ilimitado</span>
                        </a>
                    <?php } ?>
                </div>

            </div>

            <div class="offset-1"></div>


            <div class="col-xl-7 col-lg-7 col-sm-12" style="position: relative;">
                <div class="loader-container">
                    <div class="loader">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="80px" height="60px"
                             viewBox="5 0 80 60">
                            <path id="wave"
                                  fill="none"
                                  stroke="#262626"
                                  stroke-width="4"
                                  stroke-linecap="round">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-sm-12">
                        <h2>
                            <?= $date->salutation() ?>, <?= $account->getFirstName() ?>.
                            <a href="<?=LOGOUT_URL?>" class="btn danger" style="font-size: 14px;float: right;"><i class="far fa-power-off"></i></a>
                        </h2>
                    </div>

                </div>
                <div id="inld">
                    <?php if ($load) {
                        require_once($app);
                    } ?>
                </div>



            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function ld(md) {
        $(".loader-container").fadeIn(300);
        let pb = document.getElementsByClassName("prof-btn");
        if (pb !== null && pb !== undefined) {
            for (let i = 0; i < pb.length; i++) {
                pb[i].className = pb[i].className.replace("active", "").replace("  ", " ");
            }
        }
        $("#" + md + "_ac").addClass("active");
        $("#inld").load("./src/applications/pages/profile/" + md + ".php", function(){
            $(".loader-container").delay(1000).fadeOut(300);
        });
        history.pushState({
            id: 'homepage'
        }, "Meu Perfil", "<?=SERVER_ADDRESS?>perfil?t=" + md + "#" + md);
    }

</script>