<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('GuestController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'GuestController::index');
$routes->get('/page-inscription', 'GuestController::pageInscription');
$routes->get('/page-réinitialisation-mot-de-passe', 'GuestController::pageResetPassword');
$routes->post('/connexion', 'GuestController::login');
$routes->post('/inscription', 'GuestController::register');

$routes->group('auth/utilisateurs', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {

    $routes->get('accueil', 'UtilisateurController::index');

    $routes->get('ajax-utilisateur/(:num)', 'UtilisateurController::ajaxutilisateur/$1');

    $routes->post('modification-etat-utilisateur', 'UtilisateurController::modificationetat');
    
    $routes->get('deconnexion', 'UtilisateurController::logout');

});

$routes->group('auth/tarifs', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {

    $routes->get('/', 'TarifController::index');

    $routes->get('liste', 'TarifController::liste');

    $routes->get('page-ajout', 'TarifController::pageAjout');

    $routes->get('page-modification/(:num)', 'TarifController::pageModification/$1');

    $routes->get('ajax-suppression/(:num)', 'TarifController::ajaxSuppression/$1');

    $routes->post('ajout', 'TarifController::ajout');

    $routes->post('modification', 'TarifController::modification');

    $routes->post('suppression', 'TarifController::suppression');

});

$routes->group('auth/portefeuille', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {

    $routes->get('/', 'PorteFeuilleController::index');

    $routes->get('ajax-historique-portefeuille/(:num)', 'PorteFeuilleController::ajaxSuppressionHistoriquePortefeuille/$1');

    $routes->post('ajout', 'PorteFeuilleController::ajout');

    $routes->post('suppression-historique-portefeuille', 'PorteFeuilleController::suppressionHistoriquePortefeuille');

    $routes->get('liste-portefeuille-non-validé', 'PorteFeuilleController::pagePortefeuille');

    $routes->get('ajax-validation-portefeuille/(:num)', 'PorteFeuilleController::ajaxValidationPortefeuille/$1');

    $routes->post('validation-portefeuille', 'PorteFeuilleController::validationPortefeuille');

});

$routes->group('auth/place', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {

    $routes->get('liste', 'PlaceController::index');

    $routes->post('ajout', 'PlaceController::ajout');

    $routes->get('ajax-suppression-place/(:num)', 'PlaceController::ajaxSuppressionPlaces/$1');

    $routes->post('suppression-place', 'PlaceController::suppressionPlace');

});

$routes->group('auth/tableau-de-bord', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {

    $routes->get('/', 'TableauDeBordController::index');

    $routes->post('filtre', 'TableauDeBordController::index');

});

$routes->group('auth/stationnements', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {

    $routes->get('ajax-envele-voitures/(:num)', 'StationnementController::ajaxEnleveVoiture/$1');

    $routes->get('export-ticket-en-pdf/(:num)', 'StationnementController::exportticket/$1');

    $routes->post('ajout', 'StationnementController::ajout');

    $routes->post('enleve', 'StationnementController::enleve');

});

$routes->group('auth/amende', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {

    $routes->get('/', 'AmendeController::index');

    $routes->get('facture/(:num)', 'AmendeController::facture/$1');

    $routes->get('export-facture-en-pdf/(:num)', 'AmendeController::exportfacture/$1');

    $routes->get('payement/(:num)', 'AmendeController::payement/$1');

    $routes->post('payement-dette', 'AmendeController::payementdette');

});

$routes->group('auth/voiture', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {

    $routes->get('/', 'VoitureController::index');

    $routes->get('page-ajout', 'VoitureController::pageAjout');

    $routes->get('page-modification/(:num)', 'VoitureController::pageModification/$1');

    $routes->get('ajax-suppression/(:num)', 'VoitureController::ajaxSuppression/$1');

    $routes->post('ajout', 'VoitureController::ajout');

    $routes->post('modification', 'VoitureController::modification');

    $routes->post('suppression', 'VoitureController::suppression');

});

$routes->group('auth/utilisateurs', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {

    $routes->get('/', 'UtilisateurController::liste');

    $routes->get('page-accueil', 'UtilisateurController::accueil');

});

$routes->group('auth/parametres', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {

    $routes->get('/', 'ParametreController::index');

    $routes->get('profile', 'ParametreController::profile');

    $routes->get('page-modification-mot-de-passe', 'ParametreController::motdepasse');

    $routes->post('modification', 'ParametreController::modification');

    $routes->post('modification-profile', 'ParametreController::modificationProfile');

    $routes->post('modification-mot-de-passe', 'ParametreController::modificationMotDePasse');

    $routes->post('modification-amende', 'ParametreController::modificationAmende');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
