<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

/*
|--------------------------------------------------------------------------
| General constants defined in this project
|--------------------------------------------------------------------------
|| Used for various purpouses
 */
define('DIR_CONFIG', './application/config'); // default config files directory
define('DIR_CONFIG_OPENSSL', './application/config/openssl.cnf'); // default config files directory
define('DIR_PRIVATE_KEY', './application/config/private_key.pem'); // default /private_key.pem for sha sign
define('DIR_PUBLIC_KEY', './application/config/public_key.pem'); // default /public_key.pem for sha sign

define('TITLE_PAGE', "NeoHub");
define('TITLE_PAGE_TRACE', "Neodata Consola");
define('TITLE_GENERAL', "<span style='vertical-align:middle;'><img class='mb-2' src='/assets/img/small.png' width='24' height='24'/>eoHub</span>");
define('TITLE_GENERAL_TRACE', "<span style='vertical-align:middle;'><img class='mb-2' src='/assets/img/small.png' width='24' height='24'/> Consola</span>");
define('TITLE_TRACE', "<span style='vertical-align:middle;'><img class='mb-2' src='/assets/img/small.png' width='24' height='24'/>eodata<br/>Consola</span>");

define('ERROR_GENERAL', 'INNER ERROR');
define('DEFAULT_LANGUAGE', 'es-ar');
define('DEFAULT_TIMEZONE', 'America/Montevideo');
define('FORMAT_DATE_DMYHMS', 'd/m/Y H:i:s'); // default DMYHMS date format
define('FORMAT_DATE_DMY', 'd/m/Y'); // default DMY date format
define('FORMAT_DATE', 'Y-m-d H:i:s'); // default Full date format
define('FORMAT_DATE_SMALL', 'Y-d-m'); // default Only date format
define('FORMAT_DATE_DB', 'Y-m-d'); // default Only date format
define('TOKEN_AUTHENTICATION_TTL', '+1200 minutes');
define('TOKEN_TRANSACTION_TTL', '+2000 minutes');
define('API_VERSION', '1.01a');
define('ID_APPLICATION_AUTH',7);

/*
LDAP Validation
 */
define('LDAP_USER', ''); //
define('LDAP_PASSWORD', ''); //
define('LDAP_SERVER', ''); //
define('LDAP_TREE', ''); //

/*
File storage paths
*/
define('FILE_STORAGE', './storage'); //
define('FILE_ATTACHED', './attached'); //

/*
| Custom modules -> models paths
 */
define('MOD_BACKEND', 'mod_backend'); //
define('MOD_SUPPORT', 'mod_support'); //
define('MOD_INFRASTRUCTURE', 'mod_infrastructure'); //
define('MOD_FINANCES', 'mod_finances'); //
define('MOD_API', 'mod_api'); //
