<?php
	
	/*
	*
	*	This file contains CMS tools module - some usefull functions
	*
	*/
	
	class Tools
	{
		//form field buttom is long
		public static $isLong = false;
		
		//return secured data
		public static function Secure( $text ) 
		{
			if( $text == false )
			{
				$text = '';
			}
			
			return mysql_real_escape_string(htmlspecialchars($text, ENT_QUOTES));
		}
		
		//return secured alphabetic data
		public static function SecureAlfa( $text ) 
		{
			return preg_replace( '/[^a-zA-Z0-9.\-,_]*/', '', $text );
		}
		
		//return encrypted data
		public static function Encrypt( $text ) 
		{
			return urlencode(base64_encode( $text ));
		}
		
		//return decrypted data
		public static function Decrypt( $text ) 
		{
			return urldecode(base64_decode( $text ));
		}
		
		//return $_GET[$field] if exists and is not empty
		public static function InGet( $field )
		{
			$result = false;
			
			if( array_key_exists( $field, $_GET ) ) 
			{
				if( $_GET[$field] != '' ) 
				{
					$result = $_GET[$field];
				}
			}
			
			return $result;
		}
		
		//return $_POST[$field] if exists and is not empty
		public static function InPost( $field )
		{
			$result = false;
			
			if( array_key_exists( $field, $_POST ) ) 
			{
				if( $_POST[$field] != '' ) 
				{
					$result = $_POST[$field];
				}
			}
			
			return $result;
		}
		
		//return $_SESSION[$field] if exists and is not empty
		public static function InSession( $field )
		{
			$result = false;
			
			if( array_key_exists( $field, $_SESSION ) ) 
			{
				if( $_SESSION[$field] != '' ) 
				{
					$result = $_SESSION[$field];
				}
			}
			
			return $result;
		}
		
		//check if  part of $query string is equal to $str 
		public static function UserQuery( $str, $query, $index )
		{
			$foo = explode( ',', $query );
			
			if( isset( $foo[$index] ) ) 
			{
				if( $foo[$index] == $str )
				{
					return true;
				}
			} 
			
			return false;
		}
		
		//return part of $query string
		public static function GetUserQuery( $query, $index = 0 )
		{
			$foo = explode( ',', $query );
			
			if( isset( $foo[$index] ) ) 
			{
				return $foo[$index];
			} 
			
			return '';
		}
		
		//return part of $query string
		public static function GetUserQueryLast( $query )
		{
			$foo = explode( ',', $query );
			
			if( is_array($foo) ) 
			{
				return $foo[count($foo)-1];
			}
			else
			{
				return $foo;
			}
			
			return '';
		}
		
		//critical error
		public static function Message($title, $msg) 
		{
			header( 'Content-Type: text/html;charset=utf-8;');
			
			die( '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl">
	
	<head>
		
		<title>'.$title.'</title>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		
		<style type="text/css">
			html { background-color: #f0f0f0; text-align: left; font-family: FreeSans, Sans-Serif; font-size: 12px; color: #555; margin: 0; }
			body { width: 700px; margin: 100px auto; padding: 20px; border: 1px solid #ccc; background-color: #fff; }
			h1 { padding: 10px; margin: 0; color: #555; font-size: 24px;; }
			p { padding: 20px 10px; font-size: 14px; }
		</style>
		
	</head>
	
	<body>
		
		<h1>'.$title.'</h1>
		
		<p>
			'.$msg.'
		</p>
		
	</body>
	
</html>' );
		
		}
		
		//developer mode
		public static function DeveloperMode($text) 
		{
			if( self::InGet($text) )
			{
				$_SESSION[$text] = 1;
			}
			
			if( !self::InSession($text) )
			{
				die('
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl">
	<head>
		<title>Maintenance</title>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
		<style type="text/css">
			body { background: #fff; color: #000; padding: 30px; text-align: center; font-family: Tahoma, Verdana, Sans; font-size: 10px; }
			strong { font-size: 16px; }
			p { margin: 0; padding: 0 0 10px 0; }
			#wrapper { margin: 0 auto; width: 400px; padding: 115px 0 115px 270px; background: url(/worker.png) no-repeat 50px 0; }
		</style>
		<script type="text/javascript">
		<!--
			function cliSize() {
				var myHeight = 0;
				if( typeof( window.innerWidth ) == \'number\' ) {
					myHeight = window.innerHeight;
				} else if( document.documentElement && document.documentElement.clientHeight ) {
					myHeight = document.documentElement.clientHeight;
				} else if( document.body && document.body.clientHeight ) {
					myHeight = document.body.clientHeight; }
				return myHeight;
			}
			function ustawMargines() {
				var margines = (cliSize() - document.body.offsetHeight) / 2;
				if ( margines > 0 ) document.body.style.marginTop = margines + "px";
			}
		//-->
		</script>
	</head>
	<body>
		<div id="wrapper">
			<p><strong>Trwają prace konserwacyjne.</strong></p>
			<p>(this site is currently under maintenance)</p>
		</div>
		<script type="text/javascript">
		<!--
			ustawMargines();
			window.onresize = ustawMargines;
		//-->
		</script>
	</body>
</html>');
			}
		
		}
		
		//info note
		public static function Info($text)
		{
			return '<p style="padding: 10px; border: 1px solid #ddd; background-color: #eee; width: 90%;"><img src="' . INDEX_PATH . 'cms/images/skins/common/online.png" alt="" style="width: 16px; height: 16px; padding-right: 5px; vertical-align: text-bottom;"/> '.$text.'</p>';
		}
		
		//success info
		public static function Success($text)
		{
			return '<p style="padding: 10px; border: 1px solid #ddd; background-color: #eee; width: 90%;"><img src="' . INDEX_PATH . 'cms/images/skins/common/ok.png" alt="" style="width: 16px; height: 16px; padding-right: 5px; vertical-align: text-bottom;"/> '.$text.'</p>';
		}
		
		//failure info
		public static function Failure($text)
		{
			return '<p style="padding: 10px; border: 1px solid #ddd; background-color: #eee; width: 90%;"><img src="' . INDEX_PATH . 'cms/images/skins/common/cancel.png" alt="" style="width: 16px; height: 16px; padding-right: 5px; vertical-align: text-bottom;"/> '.$text.'</p>';
		}
		
		//return form field html
		public static function FormContainer( $methodName, $fields, $action = '', $method = 'post' )
		{
			return '<form action="' . $action . '" method="' . $method . '"><div><input type="hidden" name="methodName" value="' . $methodName . '" />' . $fields . '</div></form>';
		}
		
		//return form field html
		public static function FormField($label, $name = '', $value = '', $type = 9, $attr = '')
		{
			$result = '';
			
			if( $type == 0 ) 
			{
				$result = '<div class="floater"><label>'.$label.':</label><input name="'.$name.'" value="'.$value.'" type="text" class="inputField" ' . $attr . ' /></div>';
			}
			elseif( $type == 1 ) 
			{
				$result = '<div class="floater"><label>'.$label.':</label><textarea name="'.$name.'" rows="10" cols="40" class="textField" ' . $attr . '>'.$value.'</textarea></div>';
				self::$isLong = true;
			}
			elseif( $type == 2 ) 
			{
				$options = '';
				foreach ( $value as $k => $r )
				{
					$options .= '<option value="'.$r[0].'" '.($r[2]!=false?'selected="selected"':'').'>'.$r[1].'</option>';
				}
				$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'" ' . $attr . '>'.$options.'</select></div>';
			}
			elseif( $type == 3 ) 
			{
				$result = '<div class="floater"><label>'.$label.':</label><input name="'.$name.'" value="'.$value.'" type="checkbox" class="checkField" ' . $attr . ' /></div>';
			}
			else
			{
				if( self::$isLong )
				{
					$result = '<div class="floater buttonFloater"><input type="submit" class="inputButton" value="'.$label.'" ' . $attr . ' /></div>';
				}
				else
				{
					$result = '<div class="floater buttonFloaterShort"><input type="submit" class="inputButton" value="'.$label.'" ' . $attr . ' /></div>';
				}
				
				self::$isLong = false;
			}
			
			return $result;
		}
		
		public static function Redirect($location)
		{
			header( 'Location: ' . $location );
			die;
		}
	}
	
?>