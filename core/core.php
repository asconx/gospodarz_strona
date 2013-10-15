<?php
	
	/*
	*
	*	This file contains core basic configuration
	*
	*/
	
	//core debug mode on(true)/off(false)
	define( 'DEBUG_MODE', true ); 
	
	//core version
	define( 'CORE_VERSION', '4.5' );
	
	//initialize session
	session_start();
	
	//error reporting
	if ( DEBUG_MODE ) 
	{
		error_reporting( E_ALL | E_STRICT );
	}
	else
	{
		error_reporting( 0 );
	}
	
	//set core language
	$lang = 'en'; 
	
	//set dafault time zone
	date_default_timezone_set('Europe/Warsaw');
	
	//cms core path
	if( !defined( 'CORE_PATH' ) ) die( 'Core path not defined!' );
	
	//load selected language
	@require_once( CORE_PATH.'lang/'.$lang.'.php' ); 
	
	//load cms core modules 
	@require_once( CORE_PATH.'tools.php' ); //Tools module
	@require_once( CORE_PATH.'template.php' ); //Template module
	@require_once( CORE_PATH.'database.php' ); //Database module
	@require_once( CORE_PATH.'element.php' ); //Element module
	@require_once( CORE_PATH.'forms.php' ); //Forms module
	@require_once( CORE_PATH.'uploader2.php' ); //Upload module
	
?>