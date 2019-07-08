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
            foreach($addresses as $address){
                $ischoice=$address;
            }
            
            return $this->render('shop/confirmationDeCommande', [
                'beers' => $beers,
                'data' => $_POST,
                'qty' => $qty,
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

}
