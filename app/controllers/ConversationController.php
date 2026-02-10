<!-- <?php
namespace app\controllers;

use app\models\UserModel;
use app\models\VueConversation;
use Flight;
class ConversationController {
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

    public static function getConversationsJson($username)
    {
        $vueConversation = new VueConversation(Flight::db());
        $conversations = $vueConversation->getConversations($username);

        // Convertir en JSON pour utilisation dans JavaScript
        $conversations_json = json_encode($conversations);

        // Flight::render('messages', [
        //     'conversations' => $conversations,
        //     'conversations_json' => $conversations_json
        // ]);
        Flight::json($conversations_json);
    }
}
?> -->