<?php
	
	/*
	*
	*	This file contains CMS template module
	*
	*/
	
	class Template
	{
		
		private static $Folder = './template/'; //default template files directory
		private static $Extension = '.tpl'; //default template file extension 
		private static $OpenTag = '{'; //template block open tag
		private static $CloseTag = '}'; //template block close tag
		private static $Blocks = array( array(), array() ); //template blocks
		private static $TplResult = array( '', '' ); //template data
		
		//set directory and extension for template files
		public static function SetDirExt( $dir, $ext = '.tpl' )
		{
			self::$Folder = $dir;
			self::$Extension = $ext;
		}
		
		//parse loaded template data
		private static function Parse($cacheId = 0)
		{
			//check if cache exists
			if( !isset(self::$TplResult[$cacheId]) ) {
				self::$TplResult[$cacheId] = '';
			}
			
			//check if blocks exists
			if( !isset(self::$Blocks[$cacheId]) ) {
				self::$Blocks[$cacheId] = array();
			}
			
			//check if template was loaded
			if ( empty( self::$TplResult[$cacheId] ) && DEBUG_MODE )
			{
				Tools::Message( LANG_CORE_ERROR, LANG_CORE_TEMPLATE_PARSE_NOT_LOADED );
			}
			
			//get blocks names
			$search  = array_keys( self::$Blocks[$cacheId] ); 
			
			//for each block
			for ( $i = 0; $i < count($search); $i++ ) 
			{
				//set block name as [open tag]block_name[close tag]
				$search[$i] = self::$OpenTag . $search[$i] . self::$CloseTag;
			}
			
			//replace old block names with new ones
			$replace = array_values( self::$Blocks[$cacheId] );
			
			//change blocks declarations into content 
			self::$TplResult[$cacheId] = str_replace( $search, $replace, self::$TplResult[$cacheId] );
			
		}
		
		//load template file
		public static function Load( $file, $cacheId = 0 )
		{
			//check if cache exists
			if( !isset(self::$TplResult[$cacheId]) ) {
				self::$TplResult[$cacheId] = '';
			}
			
			//get template file contents and add to TplResult
			if ( !( self::$TplResult[$cacheId] .= @file_get_contents( self::$Folder . $file . self::$Extension ) ) )
			{
				if ( DEBUG_MODE )
				{
					Tools::Message( LANG_CORE_ERROR, LANG_CORE_TEMPLATE_LOAD_FILE_FAILED );
				}
			}
		}
		
		//add string to TplResult
		public static function Add( $str, $cacheId = 0 )
		{
			//check if cache exists
			if( !isset(self::$TplResult[$cacheId]) ) {
				self::$TplResult[$cacheId] = '';
			}
			
			//add string to TplResult
			self::$TplResult[$cacheId] .= $str;
			
		}
		
		//set block
		public static function SetBlock( $name, $value, $cacheId = 0 )
		{
			//check if blocks exists
			if( !isset(self::$Blocks[$cacheId]) ) {
				self::$Blocks[$cacheId] = array();
			}
			
			//add block to block array
			self::$Blocks[$cacheId][$name] = $value; 
		}
		
		//set active block
		public static function SetActiveBlock( $blockName, $idActive, $BlocksCount, $cacheId = 0 )
		{
			//check if blocks exists
			if( !isset(self::$Blocks[$cacheId]) ) {
				self::$Blocks[$cacheId] = array();
			}
			
			//add block to block array
			for( $i = 1; $i <= $BlocksCount; $i++ )
			{
				if( $i == $idActive )
				{
					self::$Blocks[$cacheId][$blockName.$i] = 'class="selected"';
				}
				else
				{
					self::$Blocks[$cacheId][$blockName.$i] = '';
				}
			}
		}
		
		//show parsed template file
		public static function Show( $cacheId = 0 )
		{
			//parse template file content
			self::Parse( $cacheId );
			
			//show core version and author
			if ( array_key_exists( 'version', $_GET ) )
			{
				Tools::Message( LANG_CORE_VERSION, '<strong>' . CORE_VERSION . 
								'</strong> by <strong>Adam Nowocin</strong> (Ascon)' );
			} 
			else
			{
				//application/xhtml (little hack ;p)
				if( array_key_exists( 'HTTP_ACCEPT', $_SERVER ) )
				{
					//optionally we can send header here, if broswer accepts content-type: application/xhtml+xml
					if( array_key_exists( 'HTTP_USER_AGENT', $_SERVER ) )
					{
						if( preg_match( '/W3C_Validator/', $_SERVER['HTTP_USER_AGENT'] ) )
						{
							//w3c hack
							header( 'Content-type: application/xhtml+xml;charset=utf-8' );
						}
					}
				}
				
				//template or sub template? 
				if( $cacheId > 0 )
				{
					$foo = self::$TplResult[$cacheId];
					self::$Blocks[$cacheId] = array();
					self::$TplResult[$cacheId] = '';
					return $foo;
				}
				else
				{
					//show parser file content
					die( self::$TplResult[0] );
				}
			}
		}
	}
	
?>