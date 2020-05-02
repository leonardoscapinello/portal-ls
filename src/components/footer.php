<footer>
    <div class="footer">
        <div class="section -space black-bg top-separator">
            <div class="container">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-sm-12">
                        <img src="<?= $static->load("leonardo-scapinello-white-background.svg"); ?>" width="38"
                             height="38" alt="" class="mp-image-logo">
                    </div>
                    <div class="offset-3"></div>
                    <div class="col-xl-7 col-lg-7 col-sm-12">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-sm-12">
                                <div class="heading">Conteúdo</div>
                                <ul>
                                    <li><a href="<?= BLOG_ADDRESS ?>marketing">Marketing Digital</a></li>
                                    <li><a href="<?= BLOG_ADDRESS ?>direito-digital">Direito Digital</a></li>
                                    <li><a href="<?= BLOG_ADDRESS ?>trafego">Tráfego</a></li>
                                    <li><a href="<?= BLOG_ADDRESS ?>customer-experience">Customer Experience</a></li>
                                    <li><a href="<?= BLOG_ADDRESS ?>creative">Creative</a></li>
                                </ul>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-12">
                                <div class="heading">Redes Sociais</div>
                                <ul>
                                    <li><a target="_blank" href="#">Blog</a></li>
                                    <li><a target="_blank"
                                           href="https://instagram.com/oleonardoscapinello">Instagram</a></li>
                                    <li><a target="_blank" href="https://facebook.com/oleonardoscapinello">Facebook</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-sm-12">
                                <div class="heading">Atendimento</div>
                                <ul>
                                    <li><a href="<?= SERVER_ADDRESS ?>consultoria">Consultoria</a></li>
                                    <li><a href="<?= SERVER_ADDRESS ?>atendimento">Atendimento</a></li>
                                    <li><a href="<?= SERVER_ADDRESS ?>politica-de-privacidade">Política de
                                            Privacidade</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    function initFreshChat() {
        window.fcWidget.init({
            token: "80bf2f1a-3688-4f05-9b04-2098630af2ec",
            host: "https://wchat.freshchat.com"
        });
    }

    function initialize(i, t) {
        var e;
        i.getElementById(t) ? initFreshChat() : ((e = i.createElement("script")).id = t, e.async = !0, e.src = "https://wchat.freshchat.com/js/widget.js", e.onload = initFreshChat, i.head.appendChild(e))
    }

    function initiateCall() {
        initialize(document, "freshchat-js-sdk")
    }

    window.addEventListener ? window.addEventListener("load", initiateCall, !1) : window.attachEvent("load", initiateCall, !1);
</script>
<?php
if ($session->isLogged()) { ?>
    <script type="text/javascript">
        window.fcWidget.setExternalId("<?=$account->getUsername()?>");

        window.fcWidget.user.setFirstName("<?=$account->getFullName()?>");

        window.fcWidget.user.setEmail("<?=$account->getEmail()?>");

        window.fcWidget.user.setProperties({
            plan: "<?=$account->getIdLicense()?>",
            status: "Active"
        });
    </script>
<?php } ?>