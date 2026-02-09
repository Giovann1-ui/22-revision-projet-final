<?php
namespace app\controllers;

use app\models\UserModel;
use app\models\VueConversation;
use Flight;
class MessageController
{
    public function getAllUsersNotSelf($selfId)
    {
        $usermodel = new UserModel(Flight::db());
        $users = $usermodel->getAllUsersNotSelf($selfId);

        // Convertir en JSON pour utilisation dans JavaScript
        $user_json = json_encode($users);

        Flight::render('messages', [
            'users' => $users,
            'user_json' => $user_json
        ]);
    }

    public static function getLastConversations($username)
    {
        $vueConversation = new VueConversation(Flight::db());
        $lastConversations = $vueConversation->getLastConversations($username);
        Flight::render('messages', ['lastConversation' => $lastConversations]);
    }
}