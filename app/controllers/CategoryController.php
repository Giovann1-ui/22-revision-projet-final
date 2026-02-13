<?php
namespace app\controllers;

use app\models\CategoryModel;
use Flight;

class CategoryController
{
    public function index()
    {
        $model = new CategoryModel(Flight::db());
        $categories = $model->getAll();
        Flight::render('categories/index', ['categories' => $categories]);
    }

    public function create()
    {
        session_start();
        if (empty($_SESSION['admin'])) {
            Flight::redirect('/admin/login');
            return;
        }

        Flight::render('categories/create');
    }

    public function store()
    {
        session_start();
        if (empty($_SESSION['admin'])) {
            Flight::redirect('/admin/login');
            return;
        }

        $name = trim(Flight::request()->data->nom ?? '');
        if ($name === '') {
            Flight::render('categories/create', ['error' => 'Le nom de la catégorie est requis']);
            return;
        }

        $model = new CategoryModel(Flight::db());
        $model->create(['nom' => $name]);

        Flight::redirect('/categories');
    }

    public function delete()
    {
        session_start();
        if (empty($_SESSION['admin'])) {
            Flight::redirect('/admin/login');
            return;
        }

        $id = (int)(Flight::request()->data->id ?? 0);
        if ($id <= 0) {
            Flight::redirect('/categories');
            return;
        }

        $model = new CategoryModel(Flight::db());
        $model->delete($id);

        Flight::redirect('/categories');
    }
}
?>
