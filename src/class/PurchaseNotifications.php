<?php

class PurchaseNotifications
{

    public function newAccount($username, $name, $password)
    {
        try {
            $email = new EmailNotification();
            $email->subject("Seja bem-vindo ao Portal LS");
            $email->contact($username, $name);
            $email->paragraph("Seja muito bem-vindo, meu caro!");
            $email->paragraph("Sua <b>ASSINATURA COMPLETA</b> aqui no Portal LS já está disponível para você; isso significa que à partir de agora você pode acessar todo o conteúdo disponível desde o primeiro dia.");
            $email->paragraph("Parabéns pelo investimento, pode contar com todo o time LS como seu forte aliado.");
            $email->paragraph("É muito importante mantermos contato, então, você pode me adicionar no facebook e me seguir no Instagram, por lá sempre tem muito conteúdo adicional e respostas à perguntas como uma verdadeira consultoria.");
            $email->paragraph("Perfil do Facebook: <a href=\"https://www.facebook.com/oleonardoscapinello\" target=\"_blank\">https://www.facebook.com/oleonardoscapinello</a><br>Perfil do Instagram: <a href=\"https://www.instagram.com/oleonardoscapinello\" target=\"_blank\">@oleonardoscapinello</a>");
            $email->heading("Suas informações de acesso");
            $email->paragraph("Sua conta foi criada automaticamente no portal utilizando o mesmo e-mail que você informou no momento do pagamento e para acessar, pode entrar de um celular ou computador no link: <a href=\"" . LOGIN_URL . "?u=" . $username . "\">" . LOGIN_URL . "</a>");
            $email->paragraph("<b>Seu usuário:</b> " . $username . "<br><b>Sua Senha:</b> " . $password);
            $email->heading("Como funciona o ambiente?");
            $email->paragraph("Você terá acesso ao conteúdo escrito (no blog) e também acesso livre a todas as series, incluindo as do passado. Alguns e-books são disponibilizados gratuitamente em sua assinatura. <b>Sim!</b> Muitas vezes você poderá baixar os e-books do portal sem custo algum, saindo à frente!");
            $email->heading("Surgiu uma dúvida, e agora?");
            $email->paragraph("Você pode enviar sua dúvida em nossas centrais de ajuda dentro do próprio portal, no grupo do Telegram ou enviar um e-mail para o suporte em: suporte@leonardoscapinello.com");
            return $email->save();
        } catch (Exception $exception) {
            error_log($exception);
        }
        return false;
    }

    public function activateLicenseToUser($username, $name)
    {
        try {
            $email = new EmailNotification();
            $email->subject("Seja bem-vindo ao Portal LS");
            $email->contact($username, $name);
            $email->paragraph("Seja muito bem-vindo, meu caro!");
            $email->paragraph("Sua <b>ASSINATURA COMPLETA</b> aqui no Portal LS já está disponível para você; isso significa que à partir de agora você pode acessar todo o conteúdo disponível desde o primeiro dia.");
            $email->paragraph("Parabéns pelo investimento, pode contar com todo o time LS como seu forte aliado.");
            $email->paragraph("É muito importante mantermos contato, então, você pode me adicionar no facebook e me seguir no Instagram, por lá sempre tem muito conteúdo adicional e respostas à perguntas como uma verdadeira consultoria.");
            $email->paragraph("Perfil do Facebook: <a href=\"https://www.facebook.com/oleonardoscapinello\" target=\"_blank\">https://www.facebook.com/oleonardoscapinello</a><br>Perfil do Instagram: <a href=\"https://www.instagram.com/oleonardoscapinello\" target=\"_blank\">@oleonardoscapinello</a>");
            $email->heading("Suas informações de acesso");
            $email->paragraph("Sua conta foi criada automaticamente no portal utilizando o mesmo e-mail que você informou no momento do pagamento e para acessar, pode entrar de um celular ou computador no link: <a href=\"" . LOGIN_URL . "?u=" . $username . "\">" . LOGIN_URL . "</a>");
            $email->paragraph("<b>Seu usuário:</b> " . $username . "<br><b>Sua Senha:</b> [use a mesma senha usada no momento do cadastro]");
            $email->heading("Como funciona o ambiente?");
            $email->paragraph("Você terá acesso ao conteúdo escrito (no blog) e também acesso livre a todas as series, incluindo as do passado. Alguns e-books são disponibilizados gratuitamente em sua assinatura. <b>Sim!</b> Muitas vezes você poderá baixar os e-books do portal sem custo algum, saindo à frente!");
            $email->heading("Surgiu uma dúvida, e agora?");
            $email->paragraph("Você pode enviar sua dúvida em nossas centrais de ajuda dentro do próprio portal, no grupo do Telegram ou enviar um e-mail para o suporte em: suporte@leonardoscapinello.com");
            $email->save();
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

    public function confirmPurchaseCancelled($username, $name)
    {
        try {
            //$email = new EmailNotification();
            //$email->subject("Seja bem-vindo ao Portal LS");
            //$email->contact($username, $name);
            //$email->paragraph("Seja muito bem-vindo, meu caro!");
            //$email->paragraph("Sua <b>ASSINATURA COMPLETA</b> aqui no Portal LS já está disponível para você; isso significa que à partir de agora você pode acessar todo o conteúdo disponível desde o primeiro dia.");
            //$email->paragraph("Parabéns pelo investimento, pode contar com todo o time LS como seu forte aliado.");
            //$email->paragraph("É muito importante mantermos contato, então, você pode me adicionar no facebook e me seguir no Instagram, por lá sempre tem muito conteúdo adicional e respostas à perguntas como uma verdadeira consultoria.");
            //$email->paragraph("Perfil do Facebook: <a href=\"https://www.facebook.com/oleonardoscapinello\" target=\"_blank\">https://www.facebook.com/oleonardoscapinello</a><br>Perfil do Instagram: <a href=\"https://www.instagram.com/oleonardoscapinello\" target=\"_blank\">@oleonardoscapinello</a>");
            //$email->heading("Suas informações de acesso");
            //$email->paragraph("Sua conta foi criada automaticamente no portal utilizando o mesmo e-mail que você informou no momento do pagamento e para acessar, pode entrar de um celular ou computador no link: <a href=\"" . LOGIN_URL . "?u=" . $username . "\">" . LOGIN_URL . "</a>");
            //$email->paragraph("<b>Seu usuário:</b> " . $username . "<br><b>Sua Senha:</b> [use a mesma senha usada no momento do cadastro]");
            //$email->heading("Como funciona o ambiente?");
            //$email->paragraph("Você terá acesso ao conteúdo escrito (no blog) e também acesso livre a todas as series, incluindo as do passado. Alguns e-books são disponibilizados gratuitamente em sua assinatura. <b>Sim!</b> Muitas vezes você poderá baixar os e-books do portal sem custo algum, saindo à frente!");
            //$email->heading("Surgiu uma dúvida, e agora?");
            //$email->paragraph("Você pode enviar sua dúvida em nossas centrais de ajuda dentro do próprio portal, no grupo do Telegram ou enviar um e-mail para o suporte em: suporte@leonardoscapinello.com");
            //$email->save();
        } catch (Exception $exception) {
            error_log($exception);
        }
    }

}