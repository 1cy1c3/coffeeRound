<?php
session_start();

require_once __DIR__ . '/../libs/vendor/autoload.php'; // Require autoloader with many important classes

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

$app = new Silex\Application (); // Initialize global object

/*
 * Register the providers for forms, templates and validations
 */
$app->register ( new Silex\Provider\MonologServiceProvider (), array (
		"monolog.logfile" => "../res/logs/sys.log",
		"monolog.name" => "sys"
) );
$app->register ( new Silex\Provider\FormServiceProvider () );
$app->register ( new Silex\Provider\UrlGeneratorServiceProvider () );
$app->register ( new Silex\Provider\ValidatorServiceProvider () );
$app->register ( new Silex\Provider\TranslationServiceProvider (), array (
		'locale_fallbacks' => array('en'),
) );
$app->register ( new Silex\Provider\TwigServiceProvider (), array (
		'twig.path' => __DIR__ . '/../res/views',
		'twig.options' => array (
				'debug' => false,
				'cache' => false
		)
) );

if (version_compare ( PHP_VERSION, "5.1.2" ) >= 0) { // Autoloader (Interceptor) to include many classes
	function autoload($class) {
		@require_once ("models/" . $class . ".php");
	}
	spl_autoload_register ( 'autoload' );
} else {
	function __autoload($class) {
		require_once ("models/" . $class . ".php");
	}
}

require_once ("../res/etc/prod.php"); // Require settings with constants and security-filter
require_once ("../res/etc/filter.php");

require_once ("controllers.php"); // Require controllers and helpers
require_once ("../res/views/helpers/generator.php");

$app->run (); // Start the web app