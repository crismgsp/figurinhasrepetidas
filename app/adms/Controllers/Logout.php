<?php

namespace App\adms\Controllers;


class Logout
{

   
    public function index(): void
    {
        unset($_SESSION['user_id'], $_SESSION['nome']);
        $_SESSION['msg'] = "<p class='alert-success'>Logout realizado com sucesso!</p>";
        $urlRedirect = URLADM . "login/index";
        header("Location: $urlRedirect");
    }
}
