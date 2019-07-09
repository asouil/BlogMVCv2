<?php
namespace App\Controller;

use \Core\Controller\Controller;

class UserinfosController extends Controller
{
    public function __construct() {
        $this->loadModel('user');
        $this->loadModel('userinfos');
        $this->loadModel('orders');
    }

    public function profile($message = null) {
        if(null !== $_SESSION['user'] && $_SESSION['user']) {
            $file = 'profile';
            $page = 'Mon profil';
        }
        else {
            $file = 'login';
            $page = 'Connexion';
        }
        return $this->render('user/'.$file, [
            'page' => $page,
            'message' => $message
        ]);
    }
    public function createUserinfos() {
        
        if(count($_POST) > 0) {
            //Création d'un tableau regroupant mes champs requis
            $requiredFields=['user_id', 'lastname', 'firstname', 'address', "zipCode", 'city', 'country', 'phone'];
            
            //On boucle sur le tableau requiredFields
            foreach($requiredFields as $key => $value) {
                //On verifie que $_POST["firstname"](si $value="firstname) existe.
                if(!$_POST[$value]) {
                    //Si n'existe pas redirection vers page d'inscription
                    header('location: /inscription');
                    exit();// PAS OUBLIER!!!!!!!!
                }
                //On Sécurise chaque donnée de $_POST et on les stocke dans $fields[]
                $fields[$value] = htmlspecialchars($_POST[$value]);
                
            }
            
            if($_POST['user_id']==$_SESSION['user']->getId()){
                $result='';
                    //Appel de la methode create de la Table Parente (core/Table.php)
                    if($this->userinfos->create($fields)) {
                        $result = "Votre mise à jour à bien été prise en compte";
                    }
                    else {
                        $result = 'une erreur s\'est produite';
                    }
            }
        }
        return $this->render('user/profile', [ 'result' => $result ]);
    }

    public function updateUserinfos($user_id, $id) {
        $add=$this->userinfos->find($id);
        if(!$add){
            throw new \Exception ("Aucune adresse trouvée");
        }
        if($add->getUserId()!==$user_id){
            http_response_code(301);
            header('location: /user/profile');
        }
        if(count($_POST) > 0) {
                
            $requiredFields=['lastname', 'firstname', 'address', "zipCode", 'city', 'country', 'phone'];
            //On boucle sur le tableau requiredFields
            foreach($requiredFields as $key => $value) {
                //On verifie que $_POST["firstname"](si $value="firstname) existe.
                if(!$_POST[$value]) {
                    //Si n'existe pas redirection vers page d'inscription
                    header('location: /profile');
                    exit();// PAS OUBLIER!!!!!!!!
                }
                //On Sécurise chaque donnée de $_POST et on les stocke dans $fields[]
                $fields[$value] = htmlspecialchars($_POST[$value]);
                
            }
            //Mise à jours bdd grace à methode update de /core/Table.php
            $bool = $this->userinfos->update($id, 'id', $_POST);
            
        }
        $address=$this->userinfos->find($id);
        $this->render('user/address', ['address' => $address]);
    }

    public function deleteUserinfos($user_id, $id){
        
        $this->userinfos->delete($id);
        header('location: /user/profile');
    }

    public function commandes(){
        if(null !== $_SESSION['user'] && $_SESSION['user']) {
            $file = 'profile';
            $page = 'Mon profil';
        }
        else {
            $file = 'login';
            $page = 'Connexion';
        }

        $orders=$this->orders->all();
        $userid=$_SESSION['user']->getId();
        $orders= $this->orders->findall($userid, "user_id"); 
        //$userinfo=$this->userinfos->findall();
        return $this->render('user/commandes' ,[
            'orders' => $orders
        ]);
    }
}
