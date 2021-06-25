<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//views Login
$route['default_controller'] = 'home/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['api/login']['POST'] = 'Login/login_user';
$route['api/logout']['POST'] = 'Login/logout';
$route['api/load_page']['GET']= 'Home/load_page';
$route['api/recovery_email']['POST']= 'Login/recovery_email';
$route['api/recovery']['POST']= 'Login/recovery';
$route['api/new_password']['POST']= 'Login/new_password';


/*Admin User*/
/*api admin user*/
$route['adminUser']['GET']= 'User/index';
$route['api/get_users']['GET']= 'User/list';
$route['api/create_user']['POST']= 'User/create';
$route['api/update_user']['POST']= 'User/update';
$route['api/des_hab_user']['POST']= 'User/des_hab';


/* api eggs */
$route['edittable']['GET']= 'Eggs/edittable';
$route['adminEggs']['GET']= 'Eggs/adminEggs';
$route['api/getEggs']['GET']= 'Eggs/getEggs';
$route['api/changeStateEgg']['POST']= 'Eggs/changeStateEgg';
$route['api/editEgg']['POST']= 'Eggs/editEgg';
$route['api/createEgg']['POST']= 'Eggs/createEgg';
$route['api/getFields']['GET']= 'Eggs/getFields';
$route['api/createEggClient']['POST']= 'Eggs/createEggClient';
$route['api/getEggClient/(:num)']['GET']= 'Eggs/getEggClient/$1';
$route['api/editEggsClient']['POST']= 'Eggs/editEggsClient';
//api eggs-client /

/*Admin Cigar*/
$route['adminCigar']['GET']= 'Cigar/index';
$route['api/getCigars']['GET']= 'Cigar/list';
$route['api/createCigar']['POST']= 'Cigar/create';
$route['api/updateCigar']['POST']= 'Cigar/update';
$route['api/desHabCigar']['POST']= 'Cigar/desHab';

/*Admin Client*/
/*api admin client*/
$route['cliente']['GET']= 'Cliente/index';
$route['api/get_clientes']['GET']= 'Cliente/list';
$route['api/create_clientes']['POST']= 'Cliente/create';
$route['api/update_clientes']['POST']= 'Cliente/update';
$route['api/des_hab_clientes']['POST']= 'Cliente/des_hab';

/*Admin gastos*/
/*api admin gastos*/
$route['gastosGenerales']['GET']= 'Gastos/index';
$route['api/get_gastos']['GET']= 'Gastos/list';
$route['api/create_gastos']['POST']= 'Gastos/create';
$route['api/update_gastos']['POST']= 'Gastos/update';
$route['api/des_hab_gastos']['POST']= 'Gastos/des_hab';

/*Admin Proveedor*/
/*api admin Proveedor*/
$route['adminProveedor']['GET']= 'Proveedor/index';
$route['api/get_proveedor']['GET']= 'Proveedor/list';
$route['api/create_proveedor']['POST']= 'Proveedor/create';
$route['api/update_proveedor']['POST']= 'Proveedor/update';
$route['api/des_hab_proveedor']['POST']= 'Proveedor/des_hab';

/*Admin ProveedorHuevo*/
/*api admin Proveedor*/
$route['adminProveedorHuevo']['GET']= 'ProveedorHuevo/index';
$route['api/get_proveedorHuevo']['GET']= 'ProveedorHuevo/list';

/*Admin ProveedorCigarro*/
/*api admin Proveedor*/
$route['adminProveedorCigarro']['GET']= 'ProveedorCigarro/index';
$route['api/get_proveedorCigarro']['GET']= 'ProveedorCigarro/list';

/*api admin cost*/
$route['adminCost']['GET']= 'Cost/adminCost';
$route['api/getCost']['GET']= 'Cost/getCost';
$route['api/createCost']['POST']= 'Cost/createCost';
$route['api/editCost']['POST']= 'Cost/editCost';
$route['api/getBuys/(:any)']['GET']= 'Cost/getBuys/$1';

/*api Buys */
$route['api/insertBuy']['POST']= 'Buy/insertBuy';
$route['api/getSupplier']['GET']= 'Buy/getSupplier';
$route['api/getProductSupplier/(:num)']['GET']= 'Buy/getProductSupplier/$1';



/*Admin Routes*/
$route['adminRoutes']['GET']= 'Routes/index';

$route['adminCreateRoute']['GET']= 'Routes/indexCreate';
$route['adminDetailsRoute']['GET'] = 'Routes/adminDetails/$1';
$route['adminUpdateRoute']['GET'] = 'Routes/adminUpdate/$1';
$route['api/routes/getRoutes']['GET']= 'Routes/list';
$route['api/routes/getDataForm']['GET']= 'Routes/getDataForm';
$route['api/routes/getDataFormUpdate']['GET']= 'Routes/getDataFormUpdate/$1';
$route['api/routes/getDataClient']['POST']= 'Routes/getDataClient';
$route['api/routes/createRoute']['POST'] = 'Routes/create';
$route['api/routes/detailsRoute']['POST'] = 'Routes/details';
$route['api/routes/updateRoute']['POST'] = 'Routes/update';
$route['api/routes/deleteRoute']['GET'] = 'Routes/delete/$1';
$route['api/routes/getCigars']['GET'] = 'Routes/getCigarsList/';

/* Admin cards */
$route['adminCards']['GET']= 'Cards/cardsAdmin';
$route['api/cards']['GET'] = 'Cards/getDataCards';

///// graphics view 
$route['adminCharts']['GET']= 'Graphics/adminCharts';
$route['charts/general']['GET']= 'Graphics/chartGeneral';
$route['charts/utils']['GET']= 'Graphics/chartUtils';
$route['charts/sale']['GET']= 'Graphics/chartSale';
$route['charts/buys']['GET']= 'Graphics/chartBuys';
$route['charts/expensive']['GET']= 'Graphics/chartExpensive';
$route['charts/credit']['GET']= 'Graphics/chartCredit';
$route['charts/stock']['GET']= 'Graphics/chartStock';

///// graphics api
$route['api/chart/utils']['POST']= 'Graphics/getUtilsByPeriod';
$route['api/chart/sale']['GET']= 'Graphics/getUtilsByPeriod';
$route['api/chart/credit']['GET']= 'Graphics/getUtilsByPeriod';


/* Routes Profile Seller */

/* Admin Route */
$route['adminRoutesSeller']['GET']= 'Routes/indexSeller';
$route['api/routes/getRoutesBySeller']['GET']= 'Routes/listBySeller';
$route['adminCompleteRoute']['GET'] = 'Routes/adminComplete/$1';