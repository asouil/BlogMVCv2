<?php
namespace App\Controller;

use \Core\Controller\Controller;

class ShopController extends Controller
{
    public function __construct() {
        $this->loadModel('beer');
        $this->loadModel('userinfos');
        $this->loadModel('ordersbeer');
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
            foreach($beers as $key => $value) {
                $orderTotal += $value->getPrice() * constant('TVA') * $qty[$key];
            }
            
            return $this->render('shop/confirmationDeCommande', [
                'beers' => $beers,
                'data' => $_POST,
                'qty' => $qty,
                'order' => $orderTotal,
                'addresses' => $addresses
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
        return $this->render('shop/contact', [
        ]);
    }

    public function basket()
    {
        
        $requiredFields=['user_id', 'beer_id', 'beerPriceHT', 'beerQTY', 'token'];
        
        foreach($requiredFields as $key => $value) {
            $fields[$value] = htmlspecialchars($_POST[$value]);
        }
        $ok = $this->ordersbeer->create($fields);
        dd($ok);
        $_SESSION['panier'] = array();
        if ($ok) {
            echo "ok";
            die;
        }else{
            echo "error";
            die;
        }
    }

    public function choice()
    {
        dd("test");
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
