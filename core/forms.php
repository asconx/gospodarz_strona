<?php
	
	/*
	*
	*	This file contains CMS tools module - some usefull functions
	*
	*/
	
	class Forms
	{
		//form field buttom is long
		public static $isLong = false;
		
		//form field data
		public static $formFieldData = false;
		
		//return form field html
		public static function FormContainer( $methodName, $fields, $action = '', $method = 'post' )
		{
			return '<form action="' . $action . '" method="' . $method . '"><div><input type="hidden" name="methodName" value="' . $methodName . '" />' . $fields . '</div></form>';
		}
		
		//return form field html
		public static function FormField($label, $name = '', $value = '', $type = 999, $attr = '', $additional = '')
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
				if( $name != 'field_type' )
				{
					$name = $name . '[]';
				}
				
				$sel = 0;
				if( $additional != '' )
				{
					$options = '<option value="-1">' . $additional . '</option>';
				}
				else
				{
					$options = '';
				}
				if( is_array($value) ) 
				{
					foreach ( $value as $k => $r )
					{
						$options .= '<option value="'.$r[0].'" '.($r[2]!=false?'selected="selected"':'').'>'.$r[1].'</option>';
						if( $r[2]!=false ) $sel++;
					}
				}
				else
				{
					$opt = explode(',', $value);
					foreach ( $opt as $k => $r )
					{
						if( strpos($r, '}') !== false ) {
							$options .= '<option value="'.$k.'" selected="selected">'.str_replace('}', '', $r).'</option>';
							$sel++;
						} else {
							$options .= '<option value="'.$k.'">'.$r.'</option>';
						}
					}
				}
				if( $sel > 1 )
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'" ' . $attr . ' style="height: 200px;" multiple="multiple">'.$options.'</select></div>';
				}
				else
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'" ' . $attr . '>'.$options.'</select><a class="multisel" href="javascript:void(0);" onclick="$(this).prev().attr(\'multiple\',\'multiple\').css(\'height\', 200);">Wybierz wiele</a></div>';
				}
			}
			elseif( $type == 3 ) 
			{
				$result = '<div class="floater"><label>'.$label.':</label><input name="'.$name.'" value="1" type="checkbox" class="checkField" ' . $attr . ' /></div>';
			}
			elseif( $type == 4 ) 
			{
				$result = '<div class="floater"><label>'.$label.':</label><input type="file" name="'.$name.'" ' . $attr . ' /></div>';
			}
			elseif( $type == 5 ) 
			{
				$users = DataBase::Select( 'users' );
				$sel = 0;
				
				if( $additional != '' )
				{
					$options = '<option value="0">' . $additional . '</option>';
				}
				else
				{
					$options = '';
				}
				foreach ( $users as $k => $r )
				{
					$selected = false;
					
					if( is_array( $value ) )
					{
						if( in_array( $r['id'], $value ) ) {
							$selected = true;
							$sel++;
						}
					}
					else
					{
						if( $value == $r['id'] )
						{
							$selected = true;
							$sel++;
						}
					}
					
					$options .= '<option value="'.$r['id'].'" '.($selected?'selected="selected"':'').'>'.$r['name'].'</option>';
				}
				if( $sel > 1 )
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'[]" ' . $attr . ' style="height: 200px;" multiple="multiple">'.$options.'</select></div>';
				}
				else
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'[]" ' . $attr . '>'.$options.'</select><a class="multisel" href="javascript:void(0);" onclick="$(this).prev().attr(\'multiple\',\'multiple\').css(\'height\', 200);">Wybierz wiele</a></div>';
				}
			}
			elseif( $type == 6 ) 
			{
				$fields = DataBase::Select( 'fields', 'WHERE category=1' );
				$sel = 0;
				
				if( $additional != '' )
				{
					$options = '<option value="0">' . $additional . '</option>';
				}
				else
				{
					$options = '';
				}
				foreach ( $fields as $k => $r )
				{
					$selected = false;
					
					if( is_array( $value ) )
					{
						if( in_array( $r['id'], $value ) ) {
							$selected = true;
							$sel++;
						}
					}
					else
					{
						if( $value == $r['id'] )
						{
							$selected = true;
							$sel++;
						}
					}
					
					$options .= '<option value="'.$r['id'].'" '.($selected?'selected="selected"':'').'>'.$r['name'].'</option>';
				}
				if( $sel > 1 )
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'[]" ' . $attr . ' style="height: 200px;" multiple="multiple">'.$options.'</select></div>';
				}
				else
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'[]" ' . $attr . '>'.$options.'</select><a class="multisel" href="javascript:void(0);" onclick="$(this).prev().attr(\'multiple\',\'multiple\').css(\'height\', 200);">Wybierz wiele</a></div>';
				}
			}
			elseif( $type == 7 ) 
			{
				$fields = DataBase::Select( 'fields', 'WHERE category=2' );
				$sel = 0;
				
				if( $additional != '' )
				{
					$options = '<option value="0">' . $additional . '</option>';
				}
				else
				{
					$options = '';
				}
				foreach ( $fields as $k => $r )
				{
					$selected = false;
					
					if( is_array( $value ) )
					{
						if( in_array( $r['id'], $value ) ) {
							$selected = true;
							$sel++;
						}
					}
					else
					{
						if( $value == $r['id'] )
						{
							$selected = true;
							$sel++;
						}
					}
					
					$options .= '<option value="'.$r['id'].'" '.($selected?'selected="selected"':'').'>'.$r['name'].'</option>';
				}
				if( $sel > 1 )
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'[]" ' . $attr . ' style="height: 200px;" multiple="multiple">'.$options.'</select></div>';
				}
				else
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'[]" ' . $attr . '>'.$options.'</select><a class="multisel" href="javascript:void(0);" onclick="$(this).prev().attr(\'multiple\',\'multiple\').css(\'height\', 200);">Wybierz wiele</a></div>';
				}
			}
			elseif( $type == 8 ) 
			{
				$fields = DataBase::Select( 'fields', 'WHERE category=3' );
				$sel = 0;
				
				if( $additional != '' )
				{
					$options = '<option value="0">' . $additional . '</option>';
				}
				else
				{
					$options = '';
				}
				foreach ( $fields as $k => $r )
				{
					$selected = false;
					
					if( is_array( $value ) )
					{
						if( in_array( $r['id'], $value ) ) {
							$selected = true;
							$sel++;
						}
					}
					else
					{
						if( $value == $r['id'] )
						{
							$selected = true;
							$sel++;
						}
					}
					
					$options .= '<option value="'.$r['id'].'" '.($selected?'selected="selected"':'').'>'.$r['name'].'</option>';
				}
				if( $sel > 1 )
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'[]" ' . $attr . ' style="height: 200px;" multiple="multiple">'.$options.'</select></div>';
				}
				else
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'[]" ' . $attr . '>'.$options.'</select><a class="multisel" href="javascript:void(0);" onclick="$(this).prev().attr(\'multiple\',\'multiple\').css(\'height\', 200);">Wybierz wiele</a></div>';
				}
			}
			elseif( $type == 9 ) 
			{
				$fields = DataBase::Select( 'fields', 'WHERE category=4' );
				$sel = 0;
				
				if( $additional != '' )
				{
					$options = '<option value="0">' . $additional . '</option>';
				}
				else
				{
					$options = '';
				}
				foreach ( $fields as $k => $r )
				{
					$selected = false;
					
					if( is_array( $value ) )
					{
						if( in_array( $r['id'], $value ) ) {
							$selected = true;
							$sel++;
						}
					}
					else
					{
						if( $value == $r['id'] )
						{
							$selected = true;
							$sel++;
						}
					}
					
					$options .= '<option value="'.$r['id'].'" '.($selected?'selected="selected"':'').'>'.$r['name'].'</option>';
				}
				if( $sel > 1 )
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'[]" ' . $attr . ' style="height: 200px;" multiple="multiple">'.$options.'</select></div>';
				}
				else
				{
					$result = '<div class="floater"><label>'.$label.':</label><select class="selectField" name="'.$name.'[]" ' . $attr . '>'.$options.'</select><a class="multisel" href="javascript:void(0);" onclick="$(this).prev().attr(\'multiple\',\'multiple\').css(\'height\', 200);">Wybierz wiele</a></div>';
				}
			}
			elseif( $type == 10 ) 
			{
				$result = '<input type="hidden" name="'.$name.'" ' . $attr . ' />';
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
		
		//return form field html
		public static function ShowFieldData($fieldName, $fieldValue, $category)
		{
			if( !isset(self::$formFieldData[$category]) )
			{
				$fields = DataBase::Select('field_types', 'WHERE cid=' . $category );
				$fieldsByName = array();
				if( is_array($fields) )
				{
					foreach( $fields as $k => $r )
					{
						$fieldFields = unserialize($r['fields']);
						$r['fields'] = $fieldFields;
						$fieldsByName[$fieldFields['name']] = $r;
					}
				}
				self::$formFieldData[$category] = $fieldsByName;
			}
			
			$label = '';
			$name = '';
			$value = '';
			$type = 999;
			$attr = '';
			$result = '';
			
			if( isset(self::$formFieldData[$category][$fieldName]) )
			{
				$label = self::$formFieldData[$category][$fieldName]['fields']['label'];
				$name = $fieldName;
				$value = $fieldValue;
				$type = self::$formFieldData[$category][$fieldName]['fields']['type'];
				$attr = '';
				if( $type == 2 )
				{
					$foo = explode(',', self::$formFieldData[$category][$fieldName]['fields']['value']);
					$resu = '';
					foreach($foo as $k => $r )
					{
						if( is_array( $value ) )
						{
							if( in_array( $k, $value ) ) 
							{
								if( $resu == '' )
								{
									$resu = $r;
								}
								else
								{
									$resu .= ', ' . $r;
								}
							}
						}
						else
						{
							if( $k == $value )
							{
								$value = $r;
								break;
							}
						}
					}
					if( is_array( $value ) )
					{
						$value = $resu;
					}
				}
			}
			
			if( $category == 900 ) 
			{
				$result = '<div class="floater bigger"><strong>'.$fieldName.':</strong> <div>' . $fieldValue . '</div></div>';
			}
			
			if( $type == 0 ) 
			{
				$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>' . $value . '</div></div>';
			}
			elseif( $type == 1 ) 
			{
				$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>' . $value . '</div></div>';
			}
			elseif( $type == 2 ) 
			{
				if( is_array($value) ) 
				{
					foreach ( $value as $k => $r )
					{
						if( $r[2]!=false )
						{
							$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>' . $r[1] . '</div></div>';
						}
					}
				}
				else
				{
					$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>' . $value . '</div></div>';
				}
			}
			elseif( $type == 3 ) 
			{
				if( $fieldValue == 1 )
				{
					$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>TAK</div></div>';
				}
				else
				{
					$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>NIE</div></div>';
				}
			}
			elseif( $type == 4 ) 
			{
				$result = 23495283;
			}
			elseif( $type == 5 ) 
			{
				$users = DataBase::Select( 'users' );
				$selected = '';
				foreach ( $users as $k => $r )
				{
					if( is_array( $value ) )
					{
						if( in_array( $r['id'], $value ) ) {
							if( $selected == '' )
							{
								$selected .= $r['name'];
							}
							else
							{
								$selected .= ', ' . $r['name'];
							}
						}
					}
					else
					{
						if( $value == $r['id'] )
						{
							$selected = $r['name'];
						}
					}
				}
				$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>'.($selected==''?'Nieznany użytkownik':$selected).'</div></div>';
			}
			elseif( $type == 6 ) 
			{
				$fields = DataBase::Select( 'fields', 'WHERE category=1' );
				$selected = '';
				foreach ( $fields as $k => $r )
				{
					if( is_array( $value ) )
					{
						if( in_array( $r['id'], $value ) ) {
							if( $selected == '' )
							{
								$selected .= '<a href="t,'.(int)$r['id'].',tematy.html">' . $r['name'] . '</a>';
							}
							else
							{
								$selected .= ', <a href="t,'.(int)$r['id'].',tematy.html">' . $r['name'] . '</a>';
							}
						}
					}
					else
					{
						if( $value == $r['id'] )
						{
							$selected = '<a href="t,'.(int)$r['id'].',tematy.html">' . $r['name'] . '</a>';
						}
					}
				}
				$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>'.($selected==''?'Nieznany temat':$selected).'</div></div>';
			}
			elseif( $type == 7 ) 
			{
				$fields = DataBase::Select( 'fields', 'WHERE category=2' );
				$selected = '';
				foreach ( $fields as $k => $r )
				{
					if( is_array( $value ) )
					{
						if( in_array( $r['id'], $value ) ) {
							if( $selected == '' )
							{
								$selected .= '<a href="e,'.(int)$r['id'].',elementy.html">' . $r['name'] . '</a>';
							}
							else
							{
								$selected .= ', <a href="e,'.(int)$r['id'].',elementy.html">' . $r['name'] . '</a>';
							}
						}
					}
					else
					{
						if( $value == $r['id'] )
						{
							$selected = '<a href="e,'.(int)$r['id'].',elementy.html">' . $r['name'] . '</a>';
						}
					}
				}
				$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>'.($selected==''?'Nieznany element':$selected).'</div></div>';
			}
			elseif( $type == 8 ) 
			{
				$fields = DataBase::Select( 'fields', 'WHERE category=3' );
				$selected = '';
				foreach ( $fields as $k => $r )
				{
					if( is_array( $value ) )
					{
						if( in_array( $r['id'], $value ) ) {
							if( $selected == '' )
							{
								$selected .= '<a href="s,'.(int)$r['id'].',komplety.html">' . $r['name'] . '</a>';
							}
							else
							{
								$selected .= ', <a href="s,'.(int)$r['id'].',komplety.html">' . $r['name'] . '</a>';
							}
						}
					}
					else
					{
						if( $value == $r['id'] )
						{
							$selected = '<a href="s,'.(int)$r['id'].',komplety.html">' . $r['name'] . '</a>';
						}
					}
				}
				$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>'.($selected==''?'Nieznany komplet':$selected).'</div></div>';
			}
			elseif( $type == 9 ) 
			{
				$fields = DataBase::Select( 'fields', 'WHERE category=4' );
				$selected = '';
				foreach ( $fields as $k => $r )
				{
					if( is_array( $value ) )
					{
						if( in_array( $r['id'], $value ) ) {
							if( $selected == '' )
							{
								$selected .= '<a href="c,'.(int)$r['id'].',kontakty.html">' . $r['name'] . '</a>';
							}
							else
							{
								$selected .= ', <a href="c,'.(int)$r['id'].',kontakty.html">' . $r['name'] . '</a>';
							}
						}
					}
					else
					{
						if( $value == $r['id'] )
						{
							$selected = '<a href="c,'.(int)$r['id'].',kontakty.html">' . $r['name'] . '</a>';
						}
					}
				}
				$result = '<div class="floater bigger"><strong>'.$label.':</strong> <div>'.($selected==''?'Nieznany kontakt':$selected).'</div></div>';
			}
			
			return $result;
		}
		
	}
	
?>