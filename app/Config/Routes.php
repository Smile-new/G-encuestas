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


$routes->get('/administrador', 'Administrador::index');

//Users
    $routes->get('usuarios', 'Usuarios::index');
    $routes->get('usuarios/create', 'Usuarios::create');
    $routes->post('usuarios/store', 'Usuarios::store');
    $routes->get('usuarios/edit/(:num)', 'Usuarios::edit/$1');
    $routes->post('usuarios/update/(:num)', 'Usuarios::update/$1');
    $routes->post('usuarios/delete/(:num)', 'Usuarios::delete/$1');



    //Encuestas
   // Routes for Encuestas (Surveys)
$routes->get('encuestas', 'Encuestas::index');
$routes->get('encuestas/create', 'Encuestas::create');
$routes->post('encuestas/store', 'Encuestas::store');
$routes->get('encuestas/edit/(:num)', 'Encuestas::edit/$1');
$routes->post('encuestas/update/(:num)', 'Encuestas::update/$1');
$routes->post('encuestas/delete/(:num)', 'Encuestas::delete/$1');
$routes->get('encuestas/estatus/(:num)', 'Encuestas::estatus/$1');



//Preguntas
$routes->get('preguntas/getPreguntasConOpcionesPorEncuesta/(:num)', 'Preguntas::getPreguntasConOpcionesPorEncuesta/$1');
$routes->get('preguntas', 'Preguntas::index');

//Encuestador
   $routes->get('home', 'Encuestador::index'); // Ruta base para el encuestador
$routes->get('cam', 'Encuestador::cam'); // Ruta para la vista de la cámara
$routes->get('formularios', 'Encuestador::formularios'); // Ruta para la lista de formularios
$routes->get('encuestas/ver/(:num)', 'Encuestador::verEncuesta/$1'); // Muestra una encuesta específica
$routes->post('encuestas/guardar', 'Encuestador::guardarRespuestas'); // Guarda las respuestas de la encuesta



//Rutas publicas  // Página de inicio


$routes->get('/nosotrosp', 'PublicController::nosotros');
$routes->get('/encuestasp', 'PublicController::encuestas');
$routes->get('/encuestas-contestadasp', 'PublicController::encuestasContestadas');

$routes->get('/login', 'LoginController::index');
$routes->post('/login/procesar', 'LoginController::procesar');
$routes->get('/logout', 'LoginController::logout');



//Estadisticas
$routes->get('estadistica', 'EstadisticasController::index');
$routes->get('estadistica/getPreguntas/(:num)', 'EstadisticasController::getPreguntas/$1');
$routes->get('estadistica/getDistritosFederales/(:num)', 'EstadisticasController::getDistritosFederales/$1');
$routes->get('estadistica/getDistritosLocales/(:num)', 'EstadisticasController::getDistritosLocales/$1');
$routes->get('estadistica/getMunicipios/(:num)', 'EstadisticasController::getMunicipios/$1');
$routes->get('estadistica/getSecciones/(:num)', 'EstadisticasController::getSecciones/$1');
$routes->get('estadistica/getComunidades/(:num)', 'EstadisticasController::getComunidades/$1');
$routes->get('estadistica/getRespuestas', 'EstadisticasController::getRespuestas');
$routes->get('estadistica/getOpcionesPregunta/(:num)', 'EstadisticasController::getOpcionesPregunta/$1');




//Administrador
    $routes->get('dashboard', 'Administrador::index'); // Alias para /administrador/dashboard   
    


//Operador
    $routes->get('dash', 'Operador::dashboard'); 
    $routes->get('estat', 'Operador::estadisticas');
    $routes->get('tab', 'Operador::tablas');



    //pagina
    $routes->get('/acerca', 'Home::acerca');

// Acceso a tudominio.com/contacto
$routes->get('/contacto', 'Home::contacto');

// Acceso a tudominio.com/servicios
$routes->get('/servicios', 'Home::servicios');
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
