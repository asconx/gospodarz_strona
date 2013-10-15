<?php
	
	/*
	*
	*	This file shows how a module must look like to be loaded by core. Use this file when u wan to make new module.
	*	IMPORTANT: class name must be equal to filename without extension!  
	*
	*/
	
	class panel_goscie
	{
		public static function Run()
		{
			Template::SetBlock( 'module_title',  'Core ' . VERSION . ' - Example module' );
			
			//TO DO: Your code here
			Template::SetBlock( 'module_content', 'TO DO: Your content here' );
			
			Template::Show();
		}
	}
	
?>