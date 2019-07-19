<?php
namespace App\Controller;

use \Core\Controller\Controller;


use App\Controller\PaginatedQueryAppController;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->loadModel('user');
        $this->loadModel('');
    }
    public function index($token)
    {
        if(!isset($token)){
            throw new Exception("Manque quelquechose ici!");
        }
        $user = $this->user->getUserByToken($token);
        $verify = $user->getVerify();
        if($verify==0){
            $_SESSION['token']=$token;
        }
        /** renvoyer à la page de connexion
         * récupérer le post, vérifier si user->getToken($SESSION['token']) correspond au 
         * user->getMail($mail)
         * si ok
         * connecter l'utilisateur si correspond et passer le verify à 1
         * sinon erreur
         * */
    }

}
