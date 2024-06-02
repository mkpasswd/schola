<?
// define('__PURELOCAL','yo');
// YO !
define('__BAGAGE','yo');
define('APPNAME','SCHOLA');

do {
	if(defined('__BAGAGE')) {
		define('ROOT',dirname(realpath(__FILE__)));
		define('SITE','https://schola.le-bagage.net/adherents');
		error_reporting(E_ALL  ^ E_STRICT );
		ini_set('display_errors', 'On');
		ini_set('session.gc_maxlifetime',43200); // 12 heures
		break;
		};
	if(defined('__PURELOCAL')) {
		define('ROOT',dirname(realpath(__FILE__)));
		define('SITE',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/schola');
		error_reporting(E_ALL  ^ E_STRICT );
		ini_set('display_errors', 'On');
		ini_set('session.gc_maxlifetime',43200); // 12 heures
		break;
		};
	//DOCKERISÉ
	define('ROOT','/var/www/html/schola');
	define('SITE','~faut-voir~');
	define('LOGLEVEL',1);
	error_reporting(E_ALL);
	ini_set('display_errors', 'Off');
	ini_set('session.gc_maxlifetime',1800); //une demie heure
	//(isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
	} while(false);

ini_set('include_path', ROOT.'/include'.PATH_SEPARATOR.ROOT.'/include/LMKbits');
ini_set('error_log',ROOT.'/logs/error.log');

?>
