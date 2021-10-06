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

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

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
