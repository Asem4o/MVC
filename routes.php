<?php
/** @var \Routing\Router $router */
$router->registerRoute(
    'users\/(.*?)\/',
    'GET',
    function ($matches) {
        if (isset($matches[1][0])) {
            (new \Controller\UsersController())->login($matches[1][0]);
        } else {
            echo "No match found";
        }
    }
);

////$router->registerRoute(
////    'users\/(.*?)\/delete',
////    'GET',
////    function ($matches) {
////        if (isset($matches[1][0])) {
////            (new \Controller\UsersController())->delete($matches[1][0]);
////        } else {
////            echo "No match found";
////        }
////    }
////);
