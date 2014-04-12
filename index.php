<?php
	
	   
	header( 'Content-Type: text/html;charset=utf-8;');
	
	//load core
	@require_once( './loader.php' );
	
	//run developer mode
	//Tools::DeveloperMode('deve');
	
	Template::SetBlock( 'module_error', '' );
	
	Template::SetBlock( 'sub_menu', '');
	Template::SetBlock( 'main_tab1', '');
	Template::SetBlock( 'main_tab2', '');
	Template::SetBlock( 'main_tab3', '');
	Template::SetBlock( 'main_tab4', '');
	
	if( RunModule('action_login') )
	{
		if( ( $request = Tools::InGet('q') ) !== false )
		{
			switch( Tools::GetUserQueryLast( $request ) )
			{
				case 'logout.html':
					unset($_SESSION['login']);
					unset($_SESSION['pass']);
					unset($_SESSION['uid']);
					header('Location: /');
					die;
				case 'goscie.html':
					Template::Load('goscie');
					RunModule('panel_goscie');
					break;
				case 'rezerwacja.html':
					Template::Load('rezerwacja');
					RunModule('panel_rezerwacje');
					break;
				case 'rozliczenie.html':
					Template::Load('rozliczenie');
					RunModule('panel_rozliczenia');
					break;
				case 'zaliczka.html':
					Template::Load('zaliczka');
					RunModule('panel_pokoje');
					break;
				case 'pokoje.html':
					Template::Load('pokoje');
					RunModule('panel_pokoje');
					break;
				default:
					Template::Load('index');
					RunModule('panel_grafik');
					break;
			}
		}
		else
		{
			Template::Load('index');
			RunModule('panel_grafik');
		}
		
	}
	else
	{
		Template::Load('module-login');
		Template::Show();
	}
	
	
?>