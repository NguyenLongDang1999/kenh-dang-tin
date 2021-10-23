<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// Frontend
$routes->group('', ['namespace' => 'App\Controllers\Frontend'], function ($routes) {
    // Home
    $routes->get('/', 'HomeController::index', ['as' => 'user.home.index']);

    // Category
    $routes->get('forums/(:any)/s(:num)', 'CategoryController::category/$1/$2', ['as' => 'user.category.category']);
    $routes->get('danh-muc-san-pham', 'CategoryController::index', ['as' => 'user.category.index']);
    $routes->get('san-pham-moi-nhat', 'CategoryController::newProduct', ['as' => 'user.category.newProduct']);
    $routes->get('san-pham-hot', 'CategoryController::vipProduct', ['as' => 'user.category.vipProduct']);

    // Product
    $routes->get('threads/(:any)/s(:num)', 'ProductController::showDetail/$1/$2', ['as' => 'user.product.showDetail']);
});

// Backend
$routes->group('administrator', ['namespace' => 'App\Controllers\Backend'], function ($routes) {
    // Dashboard
    $routes->get('/', 'DashboardController::index', ['as' => 'admin.dashboard.index']);

    // Category
    $routes->group('category', ['namespace' => 'App\Controllers\Backend'], function ($routes) {
        // Index
        $routes->get('/', 'CategoryController::index', ['as' => 'admin.category.index']);
        $routes->get('getList', 'CategoryController::getList', ['as' => 'admin.category.getList']);

        // Reorder
        $routes->get('reorder', 'CategoryController::reorder', ['as' => 'admin.category.reorder']);
        $routes->get('(:num)/subcategorites/reorderSubcategorites', 'CategoryController::reorderSubcategorites/$1', ['as' => 'admin.category.reorderSubcategorites']);
        $routes->post('postOrder', 'CategoryController::postOrder', ['as' => 'admin.category.postOrder']);

        // Create
        $routes->get('create', 'CategoryController::create', ['as' => 'admin.category.create']);
        $routes->post('store', 'CategoryController::store', ['as' => 'admin.category.store']);

        // Update
        $routes->get('edit/(:num)', 'CategoryController::edit/$1', ['as' => 'admin.category.edit']);
        $routes->post('update/(:num)', 'CategoryController::update/$1', ['as' => 'admin.category.update']);

        // Recycle
        $routes->get('recycle', 'CategoryController::recycle', ['as' => 'admin.category.recycle']);
        $routes->get('getListRecycle', 'CategoryController::getListRecycle', ['as' => 'admin.category.getListRecycle']);

        // Subcategorites
        $routes->get('(:num)/subcategorites', 'CategoryController::subcategorites/$1', ['as' => 'admin.category.subcategorites']);
        $routes->get('getListSubcategory/(:num)', 'CategoryController::getListSubcategory/$1', ['as' => 'admin.category.getListSubcategory']);

        // Update Multi Column
        $routes->post('multiStatus', 'CategoryController::multiStatus', ['as' => 'admin.category.multiStatus']);
        $routes->post('multiDestroy', 'CategoryController::multiDestroy', ['as' => 'admin.category.multiDestroy']);
        $routes->post('multiRestore', 'CategoryController::multiRestore', ['as' => 'admin.category.multiRestore']);
        $routes->post('multiPurgeDestroy', 'CategoryController::multiPurgeDestroy', ['as' => 'admin.category.multiPurgeDestroy']);

        // Check Exists
        $routes->post('checkExists', 'CategoryController::checkExists', ['as' => 'admin.category.checkExists']);
    });

    // Product
    $routes->group('product', ['namespace' => 'App\Controllers\Backend'], function ($routes) {
        // Index
        $routes->get('/', 'ProductController::index', ['as' => 'admin.product.index']);
        $routes->get('getList', 'ProductController::getList', ['as' => 'admin.product.getList']);

        // Create
        $routes->get('create', 'ProductController::create', ['as' => 'admin.product.create']);
        $routes->post('store', 'ProductController::store', ['as' => 'admin.product.store']);

        // Update
        $routes->get('edit/(:num)', 'ProductController::edit/$1', ['as' => 'admin.product.edit']);
        $routes->post('update/(:num)', 'ProductController::update/$1', ['as' => 'admin.product.update']);
        $routes->post('update/deleteProductImage', 'ProductController::deleteProductImage', ['as' => 'admin.product.deleteProductImage']);

        // Recycle
        $routes->get('recycle', 'ProductController::recycle', ['as' => 'admin.product.recycle']);
        $routes->get('getListRecycle', 'ProductController::getListRecycle', ['as' => 'admin.product.getListRecycle']);

        // Update Multi Column
        $routes->post('multiStatus', 'ProductController::multiStatus', ['as' => 'admin.product.multiStatus']);
        $routes->post('multiDestroy', 'ProductController::multiDestroy', ['as' => 'admin.product.multiDestroy']);
        $routes->post('multiRestore', 'ProductController::multiRestore', ['as' => 'admin.product.multiRestore']);
        $routes->post('multiPurgeDestroy', 'ProductController::multiPurgeDestroy', ['as' => 'admin.product.multiPurgeDestroy']);

        // Check Exists
        $routes->post('checkExists', 'ProductController::checkExists', ['as' => 'admin.product.checkExists']);
    });

    // Pages
    $routes->group('pages', ['namespace' => 'App\Controllers\Backend'], function ($routes) {
        // Index
        $routes->get('/', 'PagesController::index', ['as' => 'admin.pages.index']);
        $routes->get('getList', 'PagesController::getList', ['as' => 'admin.pages.getList']);

        // Reorder
        $routes->get('reorder', 'PagesController::reorder', ['as' => 'admin.pages.reorder']);
        $routes->post('postOrder', 'PagesController::postOrder', ['as' => 'admin.pages.postOrder']);

        // Create
        $routes->get('create', 'PagesController::create', ['as' => 'admin.pages.create']);
        $routes->post('store', 'PagesController::store', ['as' => 'admin.pages.store']);

        // Update
        $routes->get('edit/(:num)', 'PagesController::edit/$1', ['as' => 'admin.pages.edit']);
        $routes->post('update/(:num)', 'PagesController::update/$1', ['as' => 'admin.pages.update']);

        // Recycle
        $routes->get('recycle', 'PagesController::recycle', ['as' => 'admin.pages.recycle']);
        $routes->get('getListRecycle', 'PagesController::getListRecycle', ['as' => 'admin.pages.getListRecycle']);

        // Update Multi Column
        $routes->post('multiStatus', 'PagesController::multiStatus', ['as' => 'admin.pages.multiStatus']);
        $routes->post('multiDestroy', 'PagesController::multiDestroy', ['as' => 'admin.pages.multiDestroy']);
        $routes->post('multiRestore', 'PagesController::multiRestore', ['as' => 'admin.pages.multiRestore']);
        $routes->post('multiPurgeDestroy', 'PagesController::multiPurgeDestroy', ['as' => 'admin.pages.multiPurgeDestroy']);

        // Check Exists
        $routes->post('checkExists', 'PagesController::checkExists', ['as' => 'admin.pages.checkExists']);
    });
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
