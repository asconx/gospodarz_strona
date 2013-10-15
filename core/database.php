<?php
	
	/*
	*
	*	This file contains database module
	*
	*/
	
	class DataBase
	{
		
		private static $QueryResult; // SQL query results
		private static $QueryCounter = 0; // query counter
		private static $ConnectionId; // connection ID
		
		private static $DbHost = 'localhost'; //default db host
		private static $DbUser = 'root'; //default db user
		private static $DbPass = ''; //default db password
		private static $DbName = 'picms'; //default db database name
		private static $Charset = 'utf8'; //default db charset
		
		//set db connection data
		public static function SetDbData( $host, $user, $pass, $db )
		{
			self::$DbHost = $host;
			self::$DbUser = $user;
			self::$DbPass = $pass;
			self::$DbName = $db;
		}
		
		//connect to database function - we need to connect to DB only when we want to make a query.
		private static function Connect() 
		{
			//connect to DB using username, host and password
			if ( !( self::$ConnectionId = @mysql_connect( self::$DbHost, self::$DbUser, self::$DbPass ) ) ) 
			{
				Tools::Message( LANG_CORE_ERROR, LANG_CORE_CANT_CONNECT_DB );
			}
			
			//select DB
			if ( @!mysql_select_db( self::$DbName, self::$ConnectionId ) ) 
			{
				Tools::Message( LANG_CORE_ERROR, LANG_CORE_CANT_SELECT );
			}
			
			//set names
			self::Query( 'SET NAMES "' . self::$Charset . '";' );
		}
		
		//query function - return fatal error if query is wrong
		public static function Query( $sqlquery, $showQuery = false, $silent = false ) 
		{
			
			//check if query is not empty
			if ( $sqlquery != '' )
			{
				//check if we are connected to DB
				if ( empty( self::$ConnectionId ) )
				{
					self::Connect();
				}
				
				//execute query
				self::$QueryResult = @mysql_query( $sqlquery, self::$ConnectionId );
				
				//if there was error
				if ( !self::$QueryResult )
				{
					//show error if in debug mode
					if( DEBUG_MODE )
					{
						if( $silent )
						{
							echo LANG_CORE_QUERY_WRONG;
						}
						else
						{
							if( $showQuery )
							{
								Tools::Message( LANG_CORE_ERROR, LANG_CORE_QUERY_WRONG . 
												'<br /><br />' . $sqlquery . '<br /><br />' . mysql_error() );
							}
							else
							{
								Tools::Message( LANG_CORE_ERROR, LANG_CORE_QUERY_WRONG . 
												'<br /><br />' . $sqlquery . '<br /><br />' . mysql_error() );
							}
						}
					}
					
					return false;
				}
				else
				{
					//otherwise increase query counter
					self::$QueryCounter++;
					return self::$QueryResult;
				}
			}
		}
		
		//return number of queries
		public static function ShowCounter() 
		{
			return self::$QueryCounter;
		} 
		
		//show how many records are there
		public static function NumRows( $res = 0 ) 
		{
			//if there was no buffer specified use this in object
			if ( $res == 0 )
			{
				//return result
				return @mysql_num_rows( self::$QueryResult );
			} 
			else //otherwise use this specified one
			{
				//return result
				return @mysql_num_rows( $res );
			}
		}
		
		//this one works same as fetch array function in PHP :)
		public static function Fetch( $res = 0 ) 
		{
			//if there was no buffer specified use the one in object
			if ( $res == 0 ) 
			{
				return @mysql_fetch_array( self::$QueryResult );
			} 
			else //otherwise use the specified one
			{
				return @mysql_fetch_array( $res );
			}
		}
		
		//returns array from selected table
		public static function Select( $table, $params = '', $fields = '*' ) 
		{
			//initialize results
			$result = array();
			
			//make query
			self::Query('SELECT ' . $fields . ' FROM ' . DB_PREFIX . $table . ' ' . $params . ';' );
			
			//create array
			while ( $r = self::Fetch() ) 
			{
				if( isset($r['id']) )
				{
					$result[$r['id']] = $r;
				}
				else
				{
					$result[] = $r;
				}
			}
			
			return $result;
		}
		
		//insert values into table
		public static function Insert( $table, $fields = '', $values = ''  ) 
		{
			//make query
			self::Query('INSERT INTO ' . DB_PREFIX . $table . ' (' . $fields . ') VALUES (' . $values . ');' );
		}
		
		//insert values into table
		public static function Update( $table, $fields = '', $where = ''  ) 
		{
			//make query
			self::Query('UPDATE ' . DB_PREFIX . $table . ' SET ' .  $fields . ' WHERE ' . $where . ';' );
		}
		
		//returns array from selected table
		public static function SelectForSelect( $selectedId, $fieldName, $table, $params = '', $fields = '*' ) 
		{
			$result = array();
			
			$values = self::Select( $table, $params, $fields );
			
			foreach( $values as $k => $r )
			{
				if( $selectedId == $k )
				{
					$result[] = array($k, $r[$fieldName], true);
				}
				else
				{
					$result[] = array($k, $r[$fieldName], true);
				}
			}
			
			return $result;
		}
		
	}
	
?>