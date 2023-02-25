<?php

namespace Core;


abstract class Config
{

    
    protected function configAdmin(): void
    {
        define('URL', 'http://localhost/');
        define('URLADM', 'http://localhost/figurinhas/');

        define('CONTROLLER', 'Login');
        define('METODO', 'index');
        //define('CONTROLLERERRO', 'Erro'); vai direcionar pra pagina de login em vez desta caso haja pagina inexistente
        define('CONTROLLERERRO', 'Login');

        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '');
        define('DBNAME', 'figurinhas');
        define('PORT', '3306');

        define('EMAILADM', 'crismgsp@gmail.com');
    }
}
