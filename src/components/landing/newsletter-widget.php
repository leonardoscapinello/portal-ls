<?php
$username = get_request("username");
?>
<form action="<?= SERVER_ADDRESS ?>newsletter" method="POST">
    <div class="newsletter-widget">
        <div class="input-d">
            <input type="hidden" name="next" id="next" value="<?= $text->base64_encode($url->getActualURL()) ?>"/>
			<label for="username"></label>
            <input type="email" name="username" id="username" placeholder="seunome@email.com" value="<?= $username ?>"/>
            <div style="text-align: right;margin-top: 10px">
                <button class="dark">cadastrar grátis <i class="far fa-arrow-right"></i></button>
            </div>
            <p class="text half-size mute">Ao se cadastrar você concorda com os termos de uso e política de
                privacidade.</p>
        </div>
    </div>
</form>

