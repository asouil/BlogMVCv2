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

    public function all() {

        $beers = $this->beer->all();
        return $this->render('shop/boutique', [
            'beers' => $beers
        ]);
    }

    public function purchaseOrder() {
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
            
            $token = rand(100000000000, 999999999999);
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
            $userinfoid=$ischoice->getId();
            
            $priceHT=0;
            foreach($commande as $key => $value){
                $priceHT+=$value['beerpriceHT']*$value['beerQty'];
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
            
            $fields2=['userinfos_id'=>$userinfoid, 'priceHT'=>$priceHT, 'port'=>$port, 'ordersTVA'=>$tva, 'token'=>$token, 'status_id'=>$status];
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
        $user_id=$_SESSION['user']->getId();
        return $this->render('shop/bondecommande', [
            'beers' => $beers,
            'addresses' => $addresses
        ]);
    }

    public function contact() {
        return $this->render('mentions/contact', [
        ]);
    }


    public function choice()
    {
        $id = $_POST['id'];
        $user_id = $_POST['user_id'];
        $form = $this->user_infos->find($id);
        
        if ($form->getUserId() !== $user_id) {
            die('Tentative de hack échouée! Try again.');
        }
        // $user = $form;
        // $user = $user->hydrate($form);
        // echo json_encode($user);
        // die;
        
        if($form) {
            echo json_encode($form);
            die;
        }
        else {
            echo 'error';
        }
    }
    public function basket()
    {
        
        $requiredFields=['user_id', 'beer_id', 'beerPriceHT', 'beerQTY', 'token'];
        $fields=[];
        foreach($requiredFields as $key => $value) {
            $fields[$value] = htmlspecialchars($_POST[$value]);
        }
        $this->render('shop/panier', $fields);
    }
}
