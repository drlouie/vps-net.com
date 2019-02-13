<?php

/** 
 * The base configurations of the VPS-NET-WEB
 *
 * This file has the following configurations: ABSPATH. 
 *
 * @package VPS-NET-WEB
 * @sub-package LOCAL-CONFIG
**/

/**
 * VPS-NET-WEB Localized Language, defaults to English.
**/

define ('VPSLANG', '');

/** Server absolute path to the VPS-NET-WEB directory. */
if ( !defined('VPSABS') )
	define('VPSABS', dirname(__FILE__) . '/');

error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );

// read and verify composition of cookies
$OpenCanvasVersion = $_COOKIE["OpenCanvasVersion"];
$OpenCanvasDesign = $_COOKIE["OpenCanvasDesign"];
if ( preg_match('/[^0-9]/',$OpenCanvasVersion) || 
preg_match('/[^0-9A-Za-z_-]/',$OpenCanvasDesign)
){
	##--> Hack attempt / or bad input
	print "<script language=\"Javascript\" type=\"text/javascript\">alert('Error 1574: It is advisable you take note of this error and report it to the site administrator. Thanks.');</script>";
	exit;
}
$ISIN = $_COOKIE["IN"];
if (preg_match('/[^0-9A-Za-z_-]/',$ISIN)){
	##--> Hack attempt / or bad input
	print "<script language=\"Javascript\" type=\"text/javascript\">alert('Error 1575: It is advisable you take note of this error and report it to the site administrator. Thanks.');</script>";
	exit;
}

##-->> sanitize request variables
$_REQUEST = str_replace("'", '', $_REQUEST);
$_REQUEST = str_replace("\"", '', $_REQUEST);
$_REQUEST = str_replace("%", '', $_REQUEST);

/** Sets up DB functions and connection */
require_once(VPSABS . 'vps-db.php');

/** Sets up DB functions and connection */
require_once(VPSABS . 'vps-links.php');

/** Sets up DB functions and connection */
require_once(VPSABS . 'dateNewest.php');

/** data functions */
require_once(VPSABS . 'dataToolie.php');

/** spoken numbers */
require_once(VPSABS . 'NumberToWord.php');
?>
