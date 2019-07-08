<?php
namespace App\Controller;

use \Core\Controller\Controller;


use App\Controller\PaginatedQueryAppController;

class BasketController extends Controller
{
    public function __construct() {
        $this->loadModel('beer');
        $this->loadModel('userinfos');
        $this->loadModel('ordersbeer');
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