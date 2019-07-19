<?php
$basePath = dirname(__dir__) . DIRECTORY_SEPARATOR;

require_once $basePath . 'vendor/autoload.php';

$app = App\App::getInstance();
$app->setStartTime();
$app::load();

$app->getRouter($basePath)
    ->get('/blog', 'Post#all', 'home')
    ->get('/categories', 'Category#all', 'categories')
    ->get('/category/[*:slug]-[i:id]', 'Category#show', 'category')
    ->get('/article/[*:slug]-[i:id]', 'post#show', 'post')
    ->get('/', 'Shop#index', 'shopIndex')
    ->get('/boutique', 'Shop#all', 'shopAll')
    ->get('/boutique/panier', 'cart#index', 'cart')
    ->get('/validation/[*:token]', 'Auth#index', 'emailvalidation')
    ->get('/user/logout', 'users#logout', 'userLogout')
    ->get('/user/profile', 'users#profile', 'userProfile')
    ->get('/contact', 'Shop#contact', 'shopContact')
    ->get('/test', 'Twig#index', 'test')
    
    ->match('/boutique/commande', 'Shop#purchaseOrder', 'shopPurchaseOrder')
    ->match('/inscription', 'Users#subscribe', 'usersSubscribe')
    ->match('/connexion', 'Users#login', 'usersLogin')
    //POSTS URLS
    
    ->post('/user/updateUser', 'users#updateUser', 'post_updateUser')
    ->post('/user/changePassword', 'users#changePassword', 'post_updateChangePassword')
    ->run();
