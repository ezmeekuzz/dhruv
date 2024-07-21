<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
/*Administrator*/
$routes->get('/admin', 'Admin\LoginController::index');
$routes->get('/admin/login', 'Admin\LoginController::index');
$routes->get('/admin/dashboard', 'Admin\DashboardController::index');
$routes->post('/admin/login/authenticate', 'Admin\LoginController::authenticate');
$routes->get('/admin/logout', 'Admin\LogoutController::index');
$routes->get('/admin/add-property-type', 'Admin\AddPropertyTypeController::index');
$routes->post('/admin/addpropertytype/insert', 'Admin\AddPropertyTypeController::insert');
$routes->get('/admin/property-type-masterlist', 'Admin\PropertyTypeMasterlistController::index');
$routes->post('/admin/propertytypemasterlist/getData', 'Admin\PropertyTypeMasterlistController::getData');
$routes->delete('/admin/propertytypemasterlist/delete/(:num)', 'Admin\PropertyTypeMasterlistController::delete/$1');
$routes->get('/admin/edit-property-type/(:num)', 'Admin\EditPropertyTypeController::index/$1');
$routes->post('/admin/editpropertytype/update', 'Admin\EditPropertyTypeController::update');
$routes->get('/admin/add-user', 'Admin\AddUserController::index');
$routes->post('/admin/adduser/insert', 'Admin\AddUserController::insert');
$routes->get('/admin/user-masterlist', 'Admin\UserMasterlistController::index');
$routes->get('/admin/usermasterlist/getData', 'Admin\UserMasterlistController::getData');
$routes->delete('/admin/usermasterlist/delete/(:num)', 'Admin\UserMasterlistController::delete/$1');
$routes->get('/admin/edit-user/(:num)', 'Admin\EditUserController::index/$1');
$routes->post('/admin/edituser/update', 'Admin\EditUserController::update');
$routes->get('/admin/add-state', 'Admin\AddStateController::index');
$routes->post('/admin/addstate/insert', 'Admin\AddStateController::insert');
$routes->get('/admin/state-masterlist', 'Admin\StateMasterlistController::index');
$routes->get('/admin/statemasterlist/getData', 'Admin\StateMasterlistController::getData');
$routes->delete('/admin/statemasterlist/delete/(:num)', 'Admin\StateMasterlistController::delete/$1');
$routes->get('/admin/edit-state/(:num)', 'Admin\EditStateController::index/$1');
$routes->post('/admin/editstate/update', 'Admin\EditStateController::update');
$routes->get('/admin/add-city', 'Admin\AddCityController::index');
$routes->post('/admin/addcity/insert', 'Admin\AddCityController::insert');
$routes->get('/admin/city-masterlist', 'Admin\CityMasterlistController::index');
$routes->get('/admin/citymasterlist/getData', 'Admin\CityMasterlistController::getData');
$routes->delete('/admin/citymasterlist/delete/(:num)', 'Admin\CityMasterlistController::delete/$1');
$routes->get('/admin/edit-city/(:num)', 'Admin\EditCityController::index/$1');
$routes->post('/admin/editcity/update', 'Admin\EditCityController::update');
$routes->get('/admin/add-listing-agent', 'Admin\AddListingAgentController::index');
$routes->post('/admin/addlistingagent/insert', 'Admin\AddListingAgentController::insert');
$routes->get('/admin/listing-agent-masterlist', 'Admin\ListingAgentMasterlistController::index');
$routes->get('/admin/listingagentmasterlist/getData', 'Admin\ListingAgentMasterlistController::getData');
$routes->delete('/admin/listingagentmasterlist/delete/(:num)', 'Admin\ListingAgentMasterlistController::delete/$1');
$routes->get('/admin/edit-listing-agent/(:num)', 'Admin\EditListingAgentController::index/$1');
$routes->post('/admin/editlistingagent/update', 'Admin\EditListingAgentController::update');
$routes->get('/admin/add-property', 'Admin\AddPropertyController::index');
$routes->get('/admin/addproperty/getCities/(:num)', 'Admin\AddPropertyController::getCities/$1');
$routes->post('/admin/addproperty/insert', 'Admin\AddPropertyController::insert');
$routes->get('/admin/property-masterlist', 'Admin\PropertyMasterlistController::index');
$routes->get('/admin/propertymasterlist/getData', 'Admin\PropertyMasterlistController::getData');
$routes->delete('/admin/propertymasterlist/delete/(:num)', 'Admin\PropertyMasterlistController::delete/$1');
$routes->get('/admin/propertymasterlist/propertyDetails', 'Admin\PropertyMasterlistController::propertyDetails');
$routes->delete('admin/propertymasterlist/deleteImage/(:num)', 'Admin\PropertyMasterlistController::deleteImage/$1');
$routes->get('/admin/edit-property/(:num)', 'Admin\EditPropertyController::index/$1');
$routes->post('admin/editproperty/update/(:num)', 'Admin\EditPropertyController::update/$1');
$routes->get('/admin/messages', 'Admin\MessagesController::index');
$routes->get('/admin/messages/getData', 'Admin\MessagesController::getData');
$routes->delete('/admin/messages/delete/(:num)', 'Admin\MessagesController::delete/$1');
$routes->get('/admin/subscribers', 'Admin\SubscribersController::index');
$routes->get('/admin/subscribers/getData', 'Admin\SubscribersController::getData');
$routes->delete('/admin/subscribers/delete/(:num)', 'Admin\SubscribersController::delete/$1');
/*Administrator*/
$routes->get('/', 'HomeController::index');
$routes->post('/propertydetails/sendMessage', 'PropertyDetailsController::sendMessage');
$routes->post('/subscribe', 'SubscribeController::index');
$routes->post('/home/getCitiesByState', 'HomeController::getCitiesByState');
$routes->post('/home/getProperties', 'HomeController::getProperties');
$routes->post('/search', 'SearchController::index');
require APPPATH . 'Config/Propertyroutes.php';