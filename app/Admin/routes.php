<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('pages', PageController::class);
    $router->resource('news', NewsController::class);
    $router->resource('menu', MenuController::class);
    $router->resource('sliders', SliderController::class);
    $router->resource('statuses', StatusController::class);
    $router->resource('statusrepairs', StatusRepairController::class);
    $router->resource('stocks', StockController::class);
    $router->resource('banners', BannerController::class);
    $router->resource('users', UserController::class);
    $router->resource('orders', OrderController::class);
    $router->resource('order_repairs', OrderRepairController::class);


});
