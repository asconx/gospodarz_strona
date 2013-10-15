<?php
	
	/*
	*
	*	This file contains CMS element module
	*
	*/
	 
	class E
	{
		
		public static function get($_obj, $_value = '', $_params = '')
		{
			$result = '';
			$value = '';
			$attr = '';
			
			if( !empty($_value) ) 
			{
				if( is_string($_value) )
				{
					$value = $_value;
				}
				else
				{
					$value = '<pre>'.print_r($_value, true).'</pre>';
				}
			}
			
			if( is_string($_params) )
			{
				if( !empty($_params) )
				{
					$attr .= ' class="'.$_params.'"';
				}
			}
			else
			{
				if( is_array($_params) ) 
				{
					foreach( $_params as $key => $val )
					{
						$attr .= ' ' . $key . '="' . $val . '"';
					}
				}
			}
			
			if( in_array( $_obj, array('br', 'hr', 'img', 'input', 'meta', 'link') ) )
			{
				$result = '<' . $_obj . ' value="'. htmlspecialchars($value, ENT_QUOTES) .'"' . $attr . ' />';
			}
			else
			{
				$result = '<' . $_obj . $attr . '>' . $value . '</' . $_obj . '>';
			}
			
			return $result;
		}
		
	}
	
?>