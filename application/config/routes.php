<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['About-Us'] = "home/about";
$route['vision'] = "home/vision";
 
$route['mission'] = "home/mission";
$route['quote'] = "home/quote";
$route['assocham_quote'] = "home/assocham_quote";
$route['assocham_quoteSecretery'] = "home/assocham_quoteSecretery";
$route['mudra_quote'] = "home/mudra_quote";
$route['type-of-loan'] = "home/type_of_loan";
$route['lead-bank-partners'] = "home/lead_bank_partners";
$route['participating-bank-partners'] = "home/participating_bank_partners";
$route['nbfc'] = "home/nbfc";
$route['insurance'] = "home/insurance";
$route['how-to-apply'] = "home/how_to_apply";
$route['information-required'] = "home/information_required";
$route['documents-required'] = "home/documents_required";
$route['track-your-application'] = "home/track_your_application";
$route['Faq'] = "home/faq";
$route['Privacy-Policy'] = "home/privacy";
$route['Terms-Conditions'] = "home/terms";
$route['Register'] = "home/register";
$route['Msme-Register'] = "home/msme_register";
$route['Msme-Otp'] = "home/msme_otp";
$route['Channel-Partner-Register'] = "home/channel_partner_register";
$route['Channel-Partner-Otp'] = "home/channel_partner_otp";
$route['manage/dashboard']='manage/dashboard';
//$route['manage'] = 'manage/dashboard';
$route['assets/:any'] = 'asset_controller/index'; 
$route['manage/login/logout']='manage/login/logout'; 
$route['manage/login/forgetpass']='manage/login/forgetpass';
$route['home/manage/dashboard']='manage/dashboard'; //added on 01-08-2016
$route['emi-calculator'] = "home/emi_calculator";
$route['download-form'] = "home/download_form";
$route['offer-from-partner'] = "home/offer_from_partner";
$route['circular'] = "home/circular";
$route['contact-us'] = "home/contact_us";
$route['404_override'] = 'my404';

$route['verify/(:any)'] = "/home/verify/$1";


/* End of file routes.php */
/* Location: ./application/config/routes.php */
