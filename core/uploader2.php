<?php

class Uploader {
	
	public static $formInputName = 'file'; //nazwa pola z formularza, w ktorym jest plik
	public static $uploadFolder = 'upload/'; //folder w ktorym trzymamy pliki
	public static $allowedExtensionsImages = array( 'jpg', 'png', 'gif', 'bmp' ); //dozwolone rozszerzenia obrazkow
	public static $allowedExtensionsOther = array( ); //dozwolone inne rozszerzenia
	public static $notAllowedExtensions = array( 'php', 'php3', 'php4', 'php5' ); //dozwolone inne rozszerzenia
	public static $maxImageWidth = 800; //maksymalna szerokosc obrazka
	public static $maxImageHeight = 600; //maksymalna wysokosc obrazka
	public static $uploadedFile = ''; //nazwa lub status uploadowanego pliku
	public static $maxUploadedFileSize = 209795152; //maksymalna wielkosc pliku
	
	/**
	 * Zmiana rozmiarow obrazka
	 */
	public static function resizeImage($newWidth, $newHeight, $fileName, $extension) {
		
		// Get new sizes
		list($width, $height) = @getimagesize($fileName);
		if( $newWidth/$width > 0 ) $newWidth = $width;
		$newHeightTmp = (int)($height*($newWidth/$width));
		if( $newHeightTmp > $newHeight ) {
			$newWidth = (int)($width*($newHeight/$height));
		} else {
			$newHeight = $newHeightTmp;
		}
		if( $newHeightTmp > $height ) {
			$newHeight = $height;
			$newWidth = $width;
		}
		
		//create empty image
		$resizedImg = @imagecreatetruecolor($newWidth, $newHeight);
		
		//get content
		if( $extension == 'jpg' )
			$source = @imagecreatefromjpeg($fileName);
		elseif( $extension == 'png' )
			$source = @imagecreatefrompng($fileName);
		elseif( $extension == 'gif' )
			$source = @imagecreatefromgif($fileName);
		elseif( $extension == 'bmp' )
			$source = @imagecreatefromwbmp($fileName);
		
		// Resize
		@imagecopyresampled($resizedImg, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
		
		// Output
		@imagejpeg($resizedImg, $fileName);
		@imagedestroy($resizedImg);
	}
	
	
	/**
	 * Sprawdzanie czy katalog istnieje oraz utworzenie go w razie gdyby go nie było
	 */
	public static function checkDir($dir) {
		$result = true;
		$dir = dirname($dir);
		
		if( !file_exists($dir) ) {
			if( !@mkdir($dir, 0777, true) ) {
				$result = false;
			}
		}
		
		return $result;
	}
	
	
	/**
	 * Pobieranie id uzytkownika
	 */
	public static function getUserId() {
		$result = 0;
		if( isset( $_SESSION['uid'] ) )
		{
			$result = (int)$_SESSION['uid'];
		}
		return $result;
	}
	
	
	/**
	 * Operacje na obrazku po uploadzie
	 */
	public static function checkImage($fileName, $extension) {
		
		//resize image
		//self::resizeImage(self::$maxImageWidth, self::$maxImageHeight, $fileName, $extension);
		
	}
	
	/**
	 * Sprawdzenie czy zostal dodany obrazek i przeniesienie go w odpowiednie miejsce
	 */
	public static function uploadCheck($name) {
		$result = 1;
		
		if( isset($_FILES[self::$formInputName] ) )
		{
			if( $_FILES[self::$formInputName]['tmp_name'] != '' )
			{
				if( filesize ( $_FILES[self::$formInputName]['tmp_name'] ) <= self::$maxUploadedFileSize ) {
					
					$foo = explode('.', $_FILES[self::$formInputName]['name']);
					
					if( is_array($foo) ) {
						
						$extension = strtolower($foo[count($foo)-1]); 
						
						$isImage = in_array($extension, self::$allowedExtensionsImages);
						$isOther = in_array($extension, self::$allowedExtensionsOther);
						$notAllowedExt = in_array($extension, self::$notAllowedExtensions);
						
						if( !$notAllowedExt ) {
							
							$itemId = (int)Tools::GetUserQuery(Tools::InGet('q'), 1);
							
							$newName = self::$uploadFolder . $itemId . '/' . date('Y-m').'/'. $name .'.'.$extension;
							
							if( self::checkDir($newName) ) {
								
								if( !@move_uploaded_file($_FILES[self::$formInputName]['tmp_name'], $newName ) ) {
									$result = 2;
								} else {
									@chmod($newName, 0666);
									$result = $newName;
								}
								
							} else {
								$result = 3;
							}
							
						} else {
							$result = 4;
						}
						
					} else {
						$result = 5;
					}
					
				} else {
					$result = 6;
				}
			} else {
				$result = 7;
			}
			
		}
		
		self::$uploadedFile = $result;
		return $result;
	}
	
	
	/**
	 * Akcje wykonywane po dodaniu obrazka
	 */
	public static function uploadActions($category) {
		
		$result = 0;
		
		self::removeFile();
		
		$name = '';
		if( isset($_FILES[self::$formInputName]['name']) )
		{
			$name = Tools::SecureAlfa($_FILES[self::$formInputName]['name']).'_'.date('YmdHis').self::getUserId();
		}
		
		$upFile = self::uploadCheck($name);
		
		$catt = (int)$category;
		
		if( is_string($upFile) && !is_numeric($upFile) ) {
			DataBase::Query('INSERT INTO desk_files (uid, filename, name, category) VALUES ('.(int)self::getUserId().', "'.addslashes($upFile).'", "'.$name.'", '.$catt.');');
		} else {
			$result = $upFile;
		}
		
		return $result;
	}
	
	public static function listFiles($category) {
		DataBase::Query('SELECT * FROM desk_files WHERE category=' . $category . ' ORDER BY id DESC ' );
		$data = '<table cellspacing="0" cellpadding="5"><tr class="tableHeader"><td>Nazwa</td><td style="width: 200px;">Akcje</td></tr>';
		while( $row = DataBase::Fetch() ) {
			$name = $row['name'];
			if( empty($name) ) {
				$name = basename($row['filename']);
			}
			$data .= '<tr><td>'.$name.'</td><td><a href="/'.$row['filename'].'">Pobierz</a>&nbsp;&nbsp;&nbsp;<a href="?removeFile='.$row['id'].'">Usuń</a></td></tr>';
		}
		$data .= '</table>';
		
		return $data;
	}
	
	public static function removeFile()
	{
		if( isset($_GET['removeFile']) )
		{
			DataBase::Query( 'DELETE FROM desk_files WHERE id=' . (int)$_GET['removeFile'] );
		}
	}
	
}

?>