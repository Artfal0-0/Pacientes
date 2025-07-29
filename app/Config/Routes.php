<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('patients', 'PatientController::index');
$routes->get('patients/create', 'PatientController::create');
$routes->post('patients/store', 'PatientController::store');
$routes->get('patients/validate/(:any)', 'PatientController::validateCode/$1');
$routes->get('patients/delete/(:num)', 'PatientController::delete/$1');
$routes->get('patients/chatbot/(:num)', 'PatientController::chatbot/$1');
$routes->get('patients/edit/(:num)', 'PatientController::edit/$1');
$routes->post('patients/update/(:num)', 'PatientController::update/$1');


$routes->get('statistics', 'StatisticsController::statistics');


$routes->get('ia', 'IAController::index');
$routes->post('ia/getResponse', 'IAController::getResponse');


