<?php

class UploadManager {
	
	/**
	 * Pobieranie id uzytkownika
	 */
	private function getUserId() {
		return 1;
	}
	
	/**
	 * usuwanie pliku uzytkownika
	 */
	public function removeFile($id) {
		$this->databaseQuery('DELETE FROM desk_files WHERE id='.(int)$id.' AND uid='.$this->getUserId());
	}
	
	/**
	 * Listowanie plikow z wybranej kategorii
	 */
	public function listUserFiles($category) {
		$res = $this->databaseQuery('SELECT  * FROM desk_files WHERE category='.(int)$category.' AND uid='.$this->getUserId() );
		$data = '<table cellspacing="0" cellpadding="5" style="font-size: 14px;"><tr class="tableHeader"><td>Nazwa</td><td style="width: 200px;">Akcje</td></tr>';
		while( $row = $this->databaseFetch($res) ) {
			$name = $row['name'];
			if( empty($name) ) {
				$name = basename($row['filename']);
			}
			$data .= '<tr><td><a href="?showFile='.$row['id'].'">'.$name.'</a></td><td><a href="?removeFile='.$row['id'].'">usuñ</a></td></tr>';
		}
		$data .= '</table>';
		
		return $data;
	}
	
	/**
	 * Listowanie plikow z wybranej kategorii
	 */
	public function getFile($id) {
		$res = $this->databaseQuery('SELECT  * FROM desk_files WHERE id='.(int)$id );
		if( $row = $this->databaseFetch($res) ) {
			$data = file_get_contents($row['filename']);
			header('Content-Type: '.mime_content_type($row['filename']));
			die($data);
		}
		die('Error');
	}
	
	public function databaseQuery($query) {
		$con = mysql_connect( 'mysql3.iq.pl', 'pihost_base', 'pibase2009' );
		mysql_select_db( 'pihost_base', $con );
		return mysql_query($query,$con);
	}
	public function databaseFetch($query) {
		return mysql_fetch_array($query);
	}
	
}








$x = new UploadManager();

if( isset($_GET['showFile']) ) {
	$x->getFile((int)$_GET['showFile']);
}

if( isset($_GET['removeFile']) ) {
	$x->removeFile((int)$_GET['removeFile']);
}
echo $x->listUserFiles(1);



?>