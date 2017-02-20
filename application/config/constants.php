<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| Define Constants for database's table name and table prefix
|--------------------------------------------------------------------------
|
| These Constants are used when working with database
|
*/
define ('DATEFORMAT', '%d-%m-%Y');


define('TBL_PRE','tbl_'); // define prefix for table.
define('TBL_USER',	TBL_PRE.'user');
define('TBL_MSME',	TBL_PRE.'msme');
define('TBL_STATES',	TBL_PRE.'states');
define('TBL_CITIES',	TBL_PRE.'cities');
define('TBL_CHANNEL_PARTNER',	TBL_PRE.'channel_partner');
define('TBL_OTP_HISTORY',	TBL_PRE.'otp_history');
define('TBL_ANALYST',	TBL_PRE.'analyst');
define('TBL_BANK_MASTER',	TBL_PRE.'bank_master');
define('TBL_BANK_EMPLOYEE',	TBL_PRE.'bank_employee');
define('TBL_ADMIN',	TBL_PRE.'admin');
define('TBL_ENTERPRISE_PROFILE',	TBL_PRE.'enterprise_profile');
define('TBL_LOAN_REQUIREMENT',	TBL_PRE.'loan_requirement');
define('TBL_ENTERPRISE_BACKGROUND',	TBL_PRE.'enterprise_background');
define('TBL_OWNER_DETAILS',	TBL_PRE.'owner_details');
define('TBL_ENTERPISE_FINANCIALS',	TBL_PRE.'enterpise_financials');
define('TBL_BANKING_CREDIT_FACILITIES',	TBL_PRE.'banking_credit_facilities');
define('TBL_BUSINESS_DETAILS',	TBL_PRE.'business_details');
define('TBL_BUSINESS_DETAILS_LIST',	TBL_PRE.'business_details_list');
define('TBL_SECURITY_DETAILS',	TBL_PRE.'security_details');
define('TBL_BANK_APPLICATION',	TBL_PRE.'bank_application');
define('TBL_LOAN_APPLICATION',	TBL_PRE.'loan_application');
define('TBL_MESSAGE_INBOX',	TBL_PRE.'message_inbox');
define('TBL_MESSAGE',	TBL_PRE.'message');
define('TBL_UPLOAD_DOCUMENTS',	TBL_PRE.'upload_documents');
define('TBL_UPLOAD_DOCUMENTS_ADDMORE',	TBL_PRE.'upload_documents_addmore');
define('TBL_ANALYST_DOCUMENTS',	TBL_PRE.'analyst_documents');
define('TBL_ANALYST_DIRECTOR_DOCUMENTS',	TBL_PRE.'analyst_director_documents');
define('TBL_UPLOAD_DOCUMENTS_ADDITIONAL',	TBL_PRE.'upload_documents_additional');
define('TBL_BANK_FILTER',	TBL_PRE.'bank_filter');
define('TBL_UPLOAD_DOCUMENTS_OWNER',	TBL_PRE.'upload_documents_owner');

/* End of file constants.php */
/* Location: ./application/config/constants.php */
