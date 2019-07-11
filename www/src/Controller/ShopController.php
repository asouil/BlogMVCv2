<?php
namespace App\Controller;

use \Core\Controller\Controller;
use \Core\Model\Table;

class ShopController extends Controller
{
    public function __construct() {
        $this->loadModel('beer');
        $this->loadModel('userinfos');
        $this->loadModel('ordersbeer');
        $this->loadModel('orders');
        $this->loadModel('config');
    }

    public function index()
    {
        return $this->render('shop/index');
    }
    public function contact() {
        return $this->render('mentions/contact', [
        ]);
    }
    public function all() {
        $conf=$this->config->last();
        $conf=$this->config->find($conf);
        $tva = $conf->getTva();
        $beers = $this->beer->all();
        return $this->render('shop/boutique', [
            'tva'   => $tva,
            'beers' => $beers
        ]);
    }

    public function purchaseOrder() {
        if(null !== $_SESSION['user'] && $_SESSION['user']) {
            $file = 'profile';
            $page = 'Mon profil';
            $address = $this->userinfos->findUserId($_SESSION['user']->getId());
            
        }
        else {
            $file = 'login';
            $page = 'Connexion';
        }
        
        $beers = $this->beer->all();
        $id=$_SESSION['user']->getId();
        $addresses = $this->userinfos->findUserId($id);
        if(count($_POST) > 0) {
            foreach($_POST['qty'] as $key => $value) {
                if($value > 0) {
                    $ids[] = $key;
                    $qty[] = $value;
                }
            }
            if($ids==0){
                return $this->render('shop/confirmationDeCommande', [
                ]);
            }
            $ids = implode($ids, ',');
            $beers = $this->beer->getAllInIds($ids);
            $orderTotal = 0;
            $fields=[];
            //$fields[]=beer[id][priceHT][qty];
            // user_id	int(11)	//$id
            // beer_id	int(11)	//$beer.getId()
            // beerQty	int(11)	//qty[$key]
            // beerpriceHT	float	//$beer.getPrice()
            // token
            if(empty($token)){
               $token = substr(md5(time() . mt_rand()), 0, 12); 
            }
            
            foreach($beers as $key => $value) {
                $fields['user_id']=$id;
                $fields['beer_id']=$value->getId();
                $fields['beerQty']=$qty[$key];
                $fields['beerpriceHT']=$value->getPrice();
                $fields['token']=$token;
                $orderTotal += $value->getPrice() * constant('TVA') * $qty[$key];
                $this->ordersbeer->create($fields);
            }
            //insert() des commandes par ligne dans la table;
            //create($fields);
            //on récupère le choix gràce au formulaire
            $ischoice=$this->userinfos->find($_POST['voie']);
            //envoie de la commande à la bdd
            $commande=$this->ordersbeer->findall($token, 'token');
            if(!$ischoice){
                $ischoice=$_SESSION['user'];
            }
            $userinfoid=$ischoice->getId();
            
            $priceHT=0;
            foreach($commande as $key => $value){
                $priceHT+=$value->getbeerprice()*$value->getbeerQty();
            }

            //contenu du config
            $conf=$this->config->last();
            $conf=$this->config->find($conf);
            $tva = $conf->getTva();//voir pour l'avoir depuis la table config
            $price=$priceHT*$tva;
            if($price>$conf->getShipLimit()){
                $port=0;//idem >ship_limit
            }
            else{
                $orderTotal +=$conf->getPort();
                $port=$conf->getPort(); //idem pour port
            }
            $status=1;
            
            $fields2=['user_id'=>$id, 'userinfos_id'=>$userinfoid, 'priceHT'=>$priceHT, 'port'=>$port, 'ordersTVA'=>$tva, 'token'=>$token, 'status_id'=>$status];
            $this->orders->create($fields2);

            return $this->render('shop/confirmationDeCommande', [
                'beers' => $beers,
                'data' => $_POST,
                'qty' => $qty,
                'port' => $port,
                'order' => $orderTotal,
                'choix' => $ischoice
            ]);
        }

        $beers = $this->beer->all();
        
        return $this->render('shop/bondecommande', [
            'beers' => $beers,
            'addresses' => $addresses
        ]);
    }

    public function choice()
    {
        if(null !== $_SESSION['user'] && $_SESSION['user']) {
            $file = 'profile';
            $page = 'Mon profil';
            $address = $this->userinfos->findUserId($_SESSION['user']->getId());
            
        }
        else {
            $file = 'login';
            $page = 'Connexion';
        }
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
        $form = $this->user_infos->find($id);
        
        if ($form->getUserId() !== $user_id) {
            die('Tentative de hack échouée! Try again.');
        }
        if($form) {
            echo json_encode($form);
            die;
        }
        else {
            echo 'error';
        }
    }

    public function basketadd()
    { 
            
            $qty=$_POST['qty'];
            $beerid= $_POST['beer_id'];
            $priceHT=$_POST['beerprice'];
            
            if($_SESSION){
                $userid=$_SESSION['user']->getId();
            }else{
                    $userid=0;
            }
            $_SESSION['token']=substr(md5(time() . mt_rand()), 0, 12);
            
            $token=$_SESSION['token'];
            // ici création du token
            //$ordersbeer=$this->ordersbeer->findall($beerid, "beer_id");
            $ordersbeer=$this->ordersbeer->findall($token, "token");
            //dump($ordersbeer);
            foreach($ordersbeer as $beer){
                
                if($beer->getBeerId()==$beerid){
                    
                    $qty+=$beer->getBeerQty();
                    $id=$beer->getId();
                    // update de la ligne (pas de toutes les lignes)
                    $champs=['beer_id'=>$beerid, 'beerQty'=>$qty, 'beerPriceHT'=>$priceHT];
                    $ligne=$this->ordersbeer->update($id, 'id', $champs);
                }      
            }
            if(!$ligne){
                $this->ordersbeer->create(['user_id'=>$userid, 'beer_id'=>$beerid, 'beerQty'=>$qty, 'beerPriceHT'=>$priceHT,'token'=>$token]);
            }
            
            // beerid dans ordersbeer && $token existe dans la ligne){
            // update de la quantité dans la ligne avec la qté du post
            //récupération du post
            //insertion en BDD dans ordersbeer avec token
            return $this->tobasket($token);
    }

    public function basket()
    {
        $token=$_SESSION["token"];
        return $this->tobasket($token);
    }
    public function tobasket($token)
    {
        
        //récupération du token créé dans basketadd pour le rechercher /pour le moment c'est 'provisoiretk'
        $orderline=$this->ordersbeer->getLigneWithProduct($token, 'token');
        
        //envoyer les données au formulaire pour que bondecommande puisse les récupérer 
        //gérer le cas où l'utilisateur n'est pas connecté et l'envoyer sur la page de connexion
        //le token sera changé quand il va arriver au bon de commande qui devra faire des update selon les changements de l'utilisateur

        $this->render('shop/panier', ['orderline' => $orderline]);
    }


    public function verify(){
        if(null !== $_SESSION['user'] && $_SESSION['user']) {
            $file = 'profile';
            $page = 'Mon profil';
            $address = $this->userinfos->findUserId($_SESSION['user']->getId());
            
        }
        else {
            $file = 'login';
            $page = 'Connexion';
        }
        $token=$_SESSION['token'];
        $beers = $this->beer->all();
        $id=$_SESSION['user']->getId();
        // a modifier
        $addresses = $this->userinfos->findUserId($id);
        if(count($_POST) > 0) {
            foreach($_POST['qty'] as $key => $value) {
                if($value > 0) {
                    $ids[] = $key;
                    $qty[] = $value;
                }
            }
            if($ids==0){
                return $this->render('shop/confirmationDeCommande', [
                ]);
            }
            $ids = implode($ids, ',');
            $beers = $this->beer->getAllInIds($ids);
            $orderTotal = 0;
            $fields=[];
            
            foreach($beers as $key => $value) {
                $fields['user_id']=$id;
                $fields['beer_id']=$value->getId();
                $fields['beerQty']=$qty[$key];
                $fields['beerpriceHT']=$value->getPrice();
                $fields['token']=$token;
                $orderTotal += $value->getPrice() * constant('TVA') * $qty[$key];
                $this->ordersbeer->create($fields);
            }
            $ischoice=$this->userinfos->find($_POST['voie']);
            //envoie de la commande à la bdd
            $commande=$this->ordersbeer->findall($token, 'token');
            if(!$ischoice){
                $ischoice=$_SESSION['user'];
            }
            $userinfoid=$ischoice->getId();
            
            $priceHT=0;
            foreach($commande as $key => $value){
                $priceHT+=$value->getbeerprice()*$value->getbeerQty();
            }

            //contenu du config
            $conf=$this->config->last();
            $conf=$this->config->find($conf);
            $tva = $conf->getTva();//voir pour l'avoir depuis la table config
            $price=$priceHT*$tva;
            if($price>$conf->getShipLimit()){
                $port=0;//idem >ship_limit
            }
            else{
                $orderTotal +=$conf->getPort();
                $port=$conf->getPort(); //idem pour port
            }
            $status=1;
            
            $fields2=['user_id'=>$id, 'userinfos_id'=>$userinfoid, 'priceHT'=>$priceHT, 'port'=>$port, 'ordersTVA'=>$tva, 'token'=>$token, 'status_id'=>$status];
            $this->orders->create($fields2);

            return $this->render('shop/confirmationDeCommande', [
                'beers' => $beers,
                'data' => $_POST,
                'qty' => $qty,
                'port' => $port,
                'order' => $orderTotal,
                'choix' => $ischoice
            ]);
        }

        $beers = $this->beer->all();
        
        return $this->render('shop/bondecommande', [
            'beers' => $beers,
            'addresses' => $addresses
        ]);
    }
}
