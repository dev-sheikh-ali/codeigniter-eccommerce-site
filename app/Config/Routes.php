<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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



$routes->group("admin",function($routes){
       $routes->get('home','AdminController::index',['as'=>'admin.home']);

	   $routes->get('profile','AdminController::profile',['as'=>'admin.profile']);

	   $routes->get('users','AdminController::users',['as'=>'users']);
	   $routes->post('addUser','AdminController::addUser',['as'=>'add.user']);
	   $routes->get('getAllUsers','AdminController::getAllUsers',['as'=>'get.all.users']);
	   $routes->post('getUserInfo','AdminController::getUserInfo',['as'=>'get.user.info']);
	   $routes->post('updateUser','AdminController::updateUser',['as'=>'update.user']);
	   $routes->post('deleteUser','AdminController::deleteUser',['as'=>'delete.user']);

	   $routes->get('categories','AdminController::categories',['as'=>'categories']);
	   $routes->post('addCategory','AdminController::addCategory',['as'=>'add.category']);
	   $routes->get('getAllCategories','AdminController::getAllCategories',['as'=>'get.all.categories']);
	   $routes->post('getCategoryInfo','AdminController::getCategoryInfo',['as'=>'get.category.info']);
	   $routes->post('updateCategory','AdminController::updateCategory',['as'=>'update.category']);
	   $routes->post('deleteCategory','AdminController::deleteCategory',['as'=>'delete.category']);

	   $routes->get('subcategories','AdminController::subcategories',['as'=>'subcategories']);
	   $routes->post('addSubCategory','AdminController::addSubCategory',['as'=>'add.subcategory']);
	   $routes->get('getAllSubCategories','AdminController::getAllSubCategories',['as'=>'get.all.subcategories']);
	   $routes->post('getSubCategoryInfo','AdminController::getSubCategoryInfo',['as'=>'get.subcategory.info']);
	   $routes->post('updateSubCategory','AdminController::updateSubCategory',['as'=>'update.subcategory']);
	   $routes->post('deleteSubCategory','AdminController::deleteSubCategory',['as'=>'delete.subcategory']);

	   $routes->get('paymenttypes','AdminController::paymenttypes',['as'=>'paymenttypes']);
	   $routes->post('addPaymenttype','AdminController::addPaymenttype',['as'=>'add.paymenttype']);
	   $routes->get('getAllPaymenttypes','AdminController::getAllPaymenttypes',['as'=>'get.all.paymenttypes']);
	   $routes->post('getPaymenttypeInfo','AdminController::getPaymenttypeInfo',['as'=>'get.paymenttype.info']);
	   $routes->post('updatePaymenttype','AdminController::updatePaymenttype',['as'=>'update.paymenttype']);
	   $routes->post('deletePaymenttype','AdminController::deletePaymenttype',['as'=>'delete.paymenttype']);

	   $routes->get('products','AdminController::products',['as'=>'products']);
	   $routes->post('addProduct','AdminController::addProduct',['as'=>'add.product']);
	   $routes->get('getAllProducts','AdminController::getAllProducts',['as'=>'get.all.products']);
	   $routes->post('getProductInfo','AdminController::getProductInfo',['as'=>'get.product.info']);
	   $routes->post('updateProduct','AdminController::updateProduct',['as'=>'update.product']);
	   $routes->post('deleteProduct','AdminController::deleteProduct',['as'=>'delete.product']);


});

$routes->group("auth",function($routes){
	$routes->get('login','Auth::index',['as'=>'login']);
	$routes->get('register','Auth::register',['as'=>'register']);
	$routes->post('registerSave','Auth::save',['as'=>'register.save']);
	$routes->post('loginCheck','Auth::check',['as'=>'login.check']);
	$routes->post('logout','Auth::logout',['as'=>'logout']);

});

$routes->group("pages",function($routes){
	$routes->get('home','Pages::index',['as'=>'home']);
	$routes->get('profile','Pages::profile',['as'=>'profile']);


});

$routes->group('',['filter'=>'AuthCheck'],function($routes){
	//All routes protected by this filter.
	//$routes->get('/pages','Pages::index');
	$routes->get('/pages/profile','Pages::profile');
});

$routes->group('',['filter'=>'AlreadyLoggedIn'],function($routes){
	//All routes protected by this filter.
	$routes->get('/auth','Auth::index');
	$routes->get('/auth/register','Auth::register');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
