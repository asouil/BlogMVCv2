<?php
$basePath = dirname(__dir__) . DIRECTORY_SEPARATOR;

require_once $basePath . 'vendor/autoload.php';

$app = App\App::getInstance();
$app->setStartTime();
$app::load();

$app->getRouter($basePath)
    ->get('/blog', 'Post#all', 'home')
    ->get('/mentions', 'mentions#mentions', 'mentions')
    ->get('/categories', 'Category#all', 'categories')
    ->get('/category/[*:slug]-[i:id]', 'Category#show', 'category')
    ->get('/article/[*:slug]-[i:id]', 'post#show', 'post')
    ->get('/test', 'Twig#index', 'test')
    ->get('/', 'Shop#index', 'shopIndex')
    ->get('/boutique', 'Shop#all', 'shopAll')
    ->get('/boutique/commande', 'Shop#purchaseOrder', 'shopPurchaseOrder')
    ->get('/inscription', 'Users#subscribe', 'usersSubscribe')
    ->get('/login', 'Users#login', 'usersLogin')
    ->get('/user/logout', 'users#logout', 'userLogout')
    ->get('/user/profile', 'users#profile', 'userProfile')
    ->get('/contact', 'Shop#contact', 'shopContact')
    ->get('/user/address/[i:user_id]-[i:id]', 'userinfos#updateUserinfos','user_address')
    ->get('/user/address/[i:user_id]-[i:id]/disable', 'userinfos#deleteUserinfos','delete_user_address')
    //POSTS URLS
    ->post('/user/address/[i:user_id]-[i:id]', 'userinfos#updateUserinfos','post_user_address')
    ->post('/inscription', 'Users#subscribe', 'post_usersSubscribe')
    ->post('/login', 'Users#login', 'post_usersLogin')
    ->post('/user/updateUser', 'users#updateUser', 'post_updateUser')
    ->post('/user/createUserinfos', 'userinfos#createUserinfos', 'post_createUserinfos')
    ->post('/user/changePassword', 'users#changePassword', 'post_updateChangePassword')
    ->post('/boutique/commande', 'Shop#purchaseOrder', 'post_PurchaseOrder')
    ->run();
