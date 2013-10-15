<?php
	
	
	//load config
	@require_once( dirname(__FILE__).'/config.php' );
	
	//include core
	@require_once( CORE_PATH.'core.php' );
	
	//base settings
	DataBase::SetDbData( DB_HOST, DB_USER, DB_PASS, DB_NAME );
	Template::SetDirExt( TEMPLATES_PATH, '.html' );
	
	
	//Loader function
	function RunModule( $plugin )
	{
		if( !@include_once( MODULES_PATH . Tools::SecureAlfa( $plugin ) . '.php' ) )
		{
			Tools::Message( LANG_CORE_ERROR, LANG_CORE_MODULE_ERROR );
		}
		else
		{
			if( is_callable( array( Tools::SecureAlfa( $plugin ), 'Run' ) ) )
			{
				return call_user_func( array( Tools::SecureAlfa( $plugin ), 'Run' ) );
			}
			else
			{
				Tools::Message( LANG_CORE_ERROR, LANG_CORE_MODULE_ERROR );
			}
		}
		
		return false;
	}
	
	
?>