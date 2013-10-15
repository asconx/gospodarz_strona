<?php

class Uploader {
	
	private $formInputName = 'file'; //nazwa pola z formularza, w ktorym jest plik
	private $uploadFolder = 'upload/'; //folder w ktorym trzymamy pliki
	private $allowedExtensionsImages = array( 'jpg', 'png', 'gif', 'bmp' ); //dozwolone rozszerzenia obrazkow
	private $allowedExtensionsOther = array( 'doc', 'docx', 'txt', 'pdf', 'xls' ); //dozwolone inne rozszerzenia
	private $maxImageWidth = 800; //maksymalna szerokosc obrazka
	private $maxImageHeight = 600; //maksymalna wysokosc obrazka
	private $uploadedFile = ''; //nazwa lub status uploadowanego pliku
	private $maxUploadedFileSize = 209795152; //maksymalna wielkosc pliku
	
	
	/**
	 * Zmiana rozmiarow obrazka
	 */
	public function resizeImage($newWidth, $newHeight, $fileName, $extension) {
		
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
	 * Sprawdzanie zy katalog istnieje oraz utworzenie go w razie gdyby go nie było
	 */
	private function checkDir($dir) {
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
	private function getUserId() {
		return 1;
	}
	
	
	/**
	 * Operacje na obrazku po uploadzie
	 */
	private function checkImage($fileName, $extension) {
		
		//resize image
		$this->resizeImage($maxImageWidth, $maxImageHeight, $fileName, $extension);
		
	}
	
	/**
	 * Sprawdzenie czy zostal dodany obrazek i przeniesienie go w odpowiednie miejsce
	 */
	public function uploadCheck() {
		$result = 1;
		
		if( isset($_FILES[$this->formInputName] ) )
		{
			if( $_FILES[$this->formInputName]['tmp_name'] != '' )
			{
				if( filesize ( $_FILES[$this->formInputName]['tmp_name'] ) <= $this->maxUploadedFileSize ) {
					
					$foo = explode('.', $_FILES[$this->formInputName]['name']);
					
					if( is_array($foo) ) {
						
						$extension = strtolower($foo[count($foo)-1]); 
						
						$isImage = in_array($extension, $this->allowedExtensionsImages);
						$isOther = in_array($extension, $this->allowedExtensionsOther);
						
						if( $isImage || $isOther ) {
							
							if( $isImage ) {
								$newName = $uploadFolder.date('Y-m').'/'.$this->getUserId().'_'.date('YmdHis').'.jpg';
								$this->checkImage( $_FILES[$this->formInputName]['tmp_name'], $extension );
							} else {
								$newName = $uploadFolder.date('Y-m').'/'.$this->getUserId().'_'.date('YmdHis').'.'.$extension;
							}
							
							if( $this->checkDir($newName) ) {
								
								if( !@move_uploaded_file($_FILES[$this->formInputName]['tmp_name'], $newName ) ) {
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
		
		$this->uploadedFile = $result;
		return $result;
	}
	
	
	/**
	 * Akcje wykonywane po dodaniu obrazka
	 */
	public function uploadActions() {
		
		$result = 0;
		
		$upFile = $this->uploadCheck();
		
		$category = 0;
		if( isset($_POST['c']) ) {
			$category = (int)$_POST['c'];
		}
		$name = '';
		if( isset($_POST['n']) ) {
			$name = htmlspecialchars(strip_tags($_POST['n']), ENT_QUOTES);
		}
		
		/*
		CREATE TABLE `uploads` (
		`id` INT NOT NULL AUTO_INCREMENT ,
		`uid` INT NOT NULL ,
		`filename` VARCHAR( 250 ) NOT NULL ,
		`name` VARCHAR( 250 ) NOT NULL ,
		`category` INT NOT NULL ,
		PRIMARY KEY ( `id` )
		) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_polish_ci 
		*/
		if( is_string($upFile) && !is_numeric($upFile) ) {
		$con = mysql_connect( 'mysql3.iq.pl', 'pihost_base', 'pibase2009' );
		mysql_select_db( 'pihost_base', $con );
			mysql_query('INSERT INTO desk_files (uid, filename, name, category) VALUES ('.(int)$this->getUserId().', "'.addslashes($upFile).'", "'.$name.'", '.(int)$category.');', $con);
		} else {
			$result = $upFile;
		}
		
		return $result;
	}
	
}

?>



<?php
$x = new Uploader();
$file = $x->uploadActions();

if( $file == 0 ) {
	echo '<p>Plik dodany poprawnie</p>';
} elseif( $file != 1 ) {
	echo '<p>Nie udalo sie dodac pliku - blad: '.$file.'</p>';
}
?>
<h3>Dodaj plik:</h3>
<form action="" method="post" enctype="multipart/form-data"><div>
	Kategoria:
	<select name="c">
		<option value="1">Prywatne</option>
		<option value="1">Publiczne</option>
	</select><br /><br />
	Zapisz pod nazwa: <input type="text" name="n" /><br /><br />
	<input type="hidden" name="MAX_FILE_SIZE" value="209795152" />
	<input name="file" type="file" /><br /><br />
	<input type="submit" value="Dodaj" />
</div></form>