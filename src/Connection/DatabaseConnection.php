<?php

declare(strict_types=1);

//definindo o nome do pacote, ou caminho ate a classe
namespace App\Connection;

use PDO; //importando a classe PDO do PHP

class DatabaseConnection
{
    public static function open(): PDO
    {
        $host = 'localhost'; //http://db.site.com
        $user = 'alessandro';
        $pass = 'livre';
        $db_name = 'db_iw_bebidas';

        $dsn = "mysql:host={$host};dbname={$db_name}";

        return new PDO($dsn, $user, $pass);
    }
}
