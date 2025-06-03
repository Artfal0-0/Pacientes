<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('patients', 'PatientController::index');
$routes->get('patients/create', 'PatientController::create');
$routes->post('patients/store', 'PatientController::store');
$routes->get('patients/validate/(:any)', 'PatientController::validateCode/$1');
$routes->get('patients/delete/(:num)', 'PatientController::delete/$1');
$routes->get('patients/chatbot/(:num)', 'PatientController::chatbot/$1');