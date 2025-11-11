<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
// $routes->add('(:any)', 'Home::index');
// $routes->addRedirect('/', 'index.html', 302);


$routes->group('', ['filter' => 'cors'], static function (RouteCollection $routes): void {
    $routes->resource('api/signup',['only' => ['create']]);
    $routes->options('signup', static function () {
        $response = response();
        $response->setStatusCode(204);
        $response->setHeader('Allow:', 'OPTIONS, POST');
        return $response;
    });
    $routes->options('api/(:any)', static function () {});
});


$routes->group('', ['filter' => 'cors'], static function (RouteCollection $routes): void {
    $routes->resource('api/signin',['only' => ['create']]);
    $routes->options('signin', static function () {
        $response = response();
        $response->setStatusCode(204);
        $response->setHeader('Allow:', 'OPTIONS, POST');
        return $response;
    });
    $routes->options('api/(:any)', static function () {});
});


$routes->group('', ['filter' => ['cors', 'authFilter']], static function (RouteCollection $routes): void {
    
    $routes->put('api/updateprofile/(:num)', 'Api\\Users::update_profile/$1');
    $routes->get('api/getuserid/(:num)', 'Api\\Users::showuser/$1');
    $routes->put('api/changepassword/(:num)', 'Api\\Users::change_password/$1');
    $routes->post('api/uploadpicture','Api\\Users::updateProfilePicture');

    $routes->options('users', static function () {
        $response = response();
        $response->setStatusCode(204);
        $response->setHeader('Allow:', 'OPTIONS, POST, PATCH, PUT, GET');
        return $response;
    });
    $routes->options('api/(:any)', static function () {});
});


$routes->group('', ['filter' => ['cors','authFilter']], static function (RouteCollection $routes): void {
    
    $routes->put('api/mfa/activate/(:num)', 'Api\Mfa::activate_mfa/$1');
    $routes->post('api/mfa/otpvalidation', 'Api\Mfa::otpvalidation');
    $routes->get('api/mfa/getqrcode/(:num)', 'Api\Mfa::getQrcode/$1');

    $routes->options('mfa', static function () {
        $response = response();
        $response->setStatusCode(204);
        $response->setHeader('Allow:', 'OPTIONS, POST, PATCH, PUT, GET');
        return $response;
    });
    $routes->options('api/(:any)', static function () {});
});

$routes->group('', ['filter' => 'cors'], static function (RouteCollection $routes): void {
    
    $routes->post('api/addproduct', 'Api\Products::addProduct');
    $routes->put('api/updateproduct/(:num)', 'Api\Products::updateProduct/$1');
    $routes->delete('api/deleteproduct/(:num)', 'Api\Products::deleteProduct/$1');
    $routes->get('api/productlist/(:num)', 'Api\Products::listProducts/$1');
    $routes->get('api/productsearch/(:any)', 'Api\Products::searchProduct/$1');


    $routes->options('products', static function () {
        $response = response();
        $response->setStatusCode(204);
        $response->setHeader('Allow:', 'OPTIONS, POST, PATCH, PUT, GET');
        return $response;
    });
    $routes->options('api/(:any)', static function () {});
});


