<?php
namespace app\controllers;

use app\models\AdminModel;
use Flight;

class AdminController
{

    public function processLogin()
    {
        $adminModel = new AdminModel(Flight::db());
        $nom = Flight::request()->data->nom ?? '';
        $motDePasse = Flight::request()->data->motDePasse ?? '';

        $admin = $adminModel->findByUsername($nom);
        if ($admin && $admin['mot_de_passe'] === $motDePasse) {
            session_start();
            $_SESSION['admin'] = [
                'id' => $admin['id'],
                'nom' => $admin['nom']
            ];
            session_regenerate_id(true);
            Flight::redirect('/categories');
        }

        Flight::render('admin_login', ['error' => 'Nom ou mot de passe admin incorrect']);
    }

    public function showRegister()
    {
        Flight::render('admin_register');
    }

    public function processRegister()
    {
        $adminModel = new AdminModel(Flight::db());
        $nom = trim(Flight::request()->data->nom ?? '');
        $motDePasse = Flight::request()->data->motDePasse ?? '';

        if (strlen($nom) < 3) {
            Flight::render('admin_register', ['error' => 'Le nom doit contenir au moins 3 caractères']);
            return;
        }

        if ($adminModel->findByUsername($nom)) {
            Flight::render('admin_register', ['error' => 'Nom admin déjà utilisé']);
            return;
        }

        $newId = $adminModel->createAdmin(['nom' => $nom, 'mot_de_passe' => $motDePasse]);

        session_start();
        $_SESSION['admin'] = [
            'id' => $newId,
            'nom' => $nom
        ];
        session_regenerate_id(true);

        Flight::redirect('/categories');
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['admin']);
        session_regenerate_id(true);
        Flight::redirect('/admin/login');
    }
}
?>
