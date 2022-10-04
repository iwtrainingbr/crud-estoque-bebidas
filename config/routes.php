<?php

use App\Controller\BeverageController;
use App\Controller\CategoryController;

function render(string $filename, array $data = []): void 
{
    extract($data);


    include_once '../src/views/_components/head.phtml';
    include_once '../src/views/_components/navbar.phtml';

    include "../src/views/{$filename}.phtml";

    include_once '../src/views/_components/footer.phtml';
}

match ($url[0]) {
    '/' => render('home'),
    '/nova-bebida' => (new BeverageController())->add(),
    '/listar-bebidas' => (new BeverageController())->list(),
    '/excluir-bebida' => render('bebida/excluir'),
    '/editar-bebida' => render('bebida/editar'),

    '/categorias/listar' => (new CategoryController())->list(),
    '/categorias/adicionar' => (new CategoryController())->add(),
    '/categorias/excluir' => (new CategoryController())->remove(),
    '/categorias/editar' => (new CategoryController())->update(),
    '/categorias/pdf' => (new CategoryController())->report(),


    '/api/categories' => (new CategoryController())->getList(),


    default => render('erro404'),
};