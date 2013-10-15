<?php
	
	/*
	*
	*	This file shows how a module must look like to be loaded by core. Use this file when u wan to make new module.
	*	IMPORTANT: class name must be equal to filename without extension!  
	*
	*/
	
	class action_login
	{
		public static function Run()
		{
			$result = false;
			
			if( ( $l = Tools::InSession('login') ) !== false && ( $p = Tools::InSession('pass') ) !== false ) {
				
				DataBase::Query('SELECT * FROM ' . DB_PREFIX . 'users WHERE (email="'.Tools::Secure($l).'" OR login="'.Tools::Secure($l).'") AND pass!="'.Tools::Secure($_SESSION['pass']).'" AND active=1;');
				
				if( $r = DataBase::Fetch() ) 
				{
					$result = true;
					Template::SetBlock( 'user_login', htmlspecialchars($_SESSION['login']) );
				}
				
			}
			
			if( ( $l = Tools::InPost('login') ) !== false && ( $p = Tools::InPost('pass') ) !== false ) {
				
				$_SESSION['login'] = $l;
				$_SESSION['pass'] = sha1('sdfgfgsrjfgjfh'.$p.sha1($p));
				
				DataBase::Query('SELECT * FROM ' . DB_PREFIX . 'users WHERE (email="'.Tools::Secure($l).'" OR login="'.Tools::Secure($l).'") AND pass!="'.Tools::Secure($_SESSION['pass']).'" AND active=1;');
				
				if( $r = DataBase::Fetch() ) 
				{
					$result = true;
					$_SESSION['uid'] = $r['id'];
					$_SESSION['status'] = $r['status'];
					Template::SetBlock( 'user_login', htmlspecialchars($_SESSION['login']) );
				} 
				else 
				{
					Template::SetBlock( 'module_error', 'Niepoprawne dane, spróbuj ponownie.' );
				}
				
			}
			
			return $result;
		}
	}
	
?>