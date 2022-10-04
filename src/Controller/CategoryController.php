<?php

declare(strict_types=1);

namespace App\Controller;

use App\Connection\DatabaseConnection;
use App\Notification\WebNotification;

use Dompdf\Dompdf;

use PDO;

class CategoryController
{ 
    private const TABLE = 'tb_category';

    private PDO $pdo;

    public function __construct() {
        $this->pdo = DatabaseConnection::open();
    }

    public function list(): void
    {
        $query = "SELECT * FROM ".self::TABLE;

        $result = $this->pdo->query($query);
        $result->execute();

        $categories = $result->fetchAll(PDO::FETCH_OBJ);

        render('categoria/list', [
            'categories' => $categories,
        ]);
    }

    public function getList(): void
    {
        $query = "SELECT * FROM ".self::TABLE;

        $result = $this->pdo->query($query);
        $result->execute();

        $categories = $result->fetchAll(PDO::FETCH_OBJ);

        header('Content-Type: application/json');
        echo json_encode($categories);
    }

    public function add(): void 
    {
        if (true === empty($_POST)) {
            render('categoria/add');
            return;
        }

        $name = $_POST['name'];

        $query = "INSERT INTO ".self::TABLE."(name) VALUES ('{$name}')";
        
        $this->pdo->query($query);

        WebNotification::add('Categoria adicionada');
    }

    public function remove(): void
    {
        $id = $_GET['id']; //recuperamos o id que ta na URL

        //aqui vai a consulta que exclui no banco de dados
        $query = "DELETE FROM ".self::TABLE." WHERE id={$id};";

        //executando a consulta
        $this->pdo->query($query);

        //adicionando uma notificação visual pro usuario
        WebNotification::add('Categoria Excluida');
    }

    public function update(): void
    {
        $id = $_GET['id']; //recuperando o id da url

        //consulta que busca a categoria desse id
        $query = "SELECT * FROM ".self::TABLE." WHERE id={$id}";

        $result = $this->pdo->query($query); //preparando a consulta
        $result->execute(); //executando a consulta

        //recuperando o resultado e colocando na variavel category
        $category = $result->fetchObject(); 


        if (true === empty($_POST)) {
            render('categoria/edit', [
                'category' => $category,
            ]);

            return;
        }

        $name = $_POST['name'];

        $query = "UPDATE ".self::TABLE." SET name='{$name}' WHERE id={$id}";

        $this->pdo->query($query);

        WebNotification::add('Categoria atualizada');
    }

    public function report(): void
    {
        $dompdf = new Dompdf();

        $dompdf->loadHtml('<h1>Relatorio de Categorias</h1>');

        $dompdf->render();
        $dompdf->stream();
    }
}