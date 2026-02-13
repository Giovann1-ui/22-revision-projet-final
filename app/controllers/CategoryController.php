<?php
namespace app\controllers;

use app\models\CategoryModel;
use Flight;

class CategoryController
{
    public function index()
    {
        session_start();
        if (empty($_SESSION['admin'])) {
            Flight::redirect('/admin/login');
            return;
        }

        $model = new CategoryModel(Flight::db());
        $categories = $model->getAll();

        $userCount = $this->getUserCount();
        $exchangeCount = $this->getExchangeCount();

        Flight::render('categories/index', ['categories' => $categories, 'userCount' => $userCount, 'exchangeCount' => $exchangeCount]);
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
            Flight::redirect('/categories');
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

    private function getUserCount()
    {
        $stmt = Flight::db()->prepare("SELECT COUNT(*) as count FROM membres WHERE carac = 'user'");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }

    private function getExchangeCount()
    {
        $stmt = Flight::db()->prepare("SELECT COUNT(*) as count FROM propositions WHERE id_statut_proposition = (SELECT id FROM statut_proposition WHERE nom = 'accepté')");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['count'] ?? 0;
    }
}
?>