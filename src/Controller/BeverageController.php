<?php

declare(strict_types=1);

namespace App\Controller;

use App\Connection\DatabaseConnection;
use App\Notification\WebNotification;
use PDO;

class BeverageController
{
    private const TABLE = 'tb_beverage'; 
    private const TABLE_CAT = 'tb_category';

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DatabaseConnection::open();    
    }

    public function add(): void
    {
        if (true === empty($_POST)) {
            //montando a query
            $query = "SELECT * FROM ".self::TABLE_CAT." ORDER BY name";
            

            $result = $this->pdo->query($query);
            $result->execute();

            render('bebida/add', [
                'categories' => $result->fetchAll(PDO::FETCH_OBJ),
            ]);
            return;
        }

        $categoria = $_POST['categoria'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $quantidade = $_POST['quantidade'];


        $query = "INSERT INTO ".self::TABLE."(category_id, title, description, quantity, price)";
        $query .= "VALUES('{$categoria}', '{$titulo}', '{$descricao}', '{$quantidade}', '{$preco}')";
       
        $this->pdo->query($query);

        WebNotification::add('Bebida adicionada');
    }

    public function list(): void
    {
        $tb_b = self::TABLE;
        $tb_c = self::TABLE_CAT;

        $query = "SELECT {$tb_b}.*, {$tb_c}.name as category FROM {$tb_b} ";
        $query .= "INNER JOIN {$tb_c} ON category_id = {$tb_c}.id";

        $result = $this->pdo->query($query);
        $result->execute();

        render('bebida/listar', [
            'beverages' => $result->fetchAll(PDO::FETCH_OBJ),  
        ]);
    }

}