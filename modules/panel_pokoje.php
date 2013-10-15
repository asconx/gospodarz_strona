<?php
	
	/*
	*
	*	This file shows how a module must look like to be loaded by core. Use this file when u wan to make new module.
	*	IMPORTANT: class name must be equal to filename without extension!  
	*
	*/
	
	class panel_pokoje
	{
		public static function Run()
		{
			Template::SetBlock( 'module_title',  'Core ' . VERSION . ' - Example module' );
			
			if( isset($_POST['paction']) ) {
				if((int)$_POST['paction'] == 1) {
					DataBase::Query('UPDATE ' .DB_PREFIX. 'rooms SET name='.(int)$_POST['pnr'].', notes="'.Tools::Secure($_POST['popis']).'", price='.(int)$_POST['pcena'].' WHERE id='.(int)$_POST['pid'].';');
				}
				if((int)$_POST['paction'] == 2) {
					DataBase::Query('UPDATE ' .DB_PREFIX. 'rooms SET active=0 WHERE id='.(int)$_POST['pid'].';');
				}
			}
			
			$pokoje = '';
			DataBase::Query('SELECT * FROM ' .DB_PREFIX. 'rooms WHERE active=1;');
			$i = 0;
			while($r = DataBase::Fetch()) {
				
				$pokojeHtml = '
					<form id="p'.$r['id'].'" action="" method="post" class="pokojBox'.($i%2==1?'2':'').'">
						<input type="hidden" name="pid" value="'.$r['id'].'" />
						<input id="p'.$r['id'].'a" type="hidden" name="paction" value="1" />
						<div class="pokojTop">Pokój '.$r['name'].'</div>
						<div class="czcionka pinfo">
							Numer pokoju: <input type="text" name="pnr" value="'.$r['name'].'" style="width: 50px; border: #c2c5a4 solid 1px;" /></br></br>
							Cena pokoju: <input type="text" name="pcena" value="'.$r['price'].'" style="width: 100px; border: #c2c5a4 solid 1px;" /></br></br>
							Opis: <input type="text" name="popis" value="'.$r['notes'].'" style="width: 300px; border: #c2c5a4 solid 1px;" />
							<div class="titem psave" onclick="$(\'#p'.$r['id'].'a\').val(1);$(\'#p'.$r['id'].'\').submit();">
								<img src="images/save.png" alt="" /><br /> zapisz
							</div>
							<div class="titem premove" onclick="$(\'#p'.$r['id'].'a\').val(2);$(\'#p'.$r['id'].'\').submit();">
								<img src="images/remove.png" alt="" /><br />usuń
							</div>
						</div>
					</form>
				';
				
				$pokoje .= $pokojeHtml;
				$i++;
				
			}
			

			
			//TO DO: Your code here
			Template::SetBlock( 'module_content', $pokoje );
			
			Template::Show();
		}
	}
	
?>