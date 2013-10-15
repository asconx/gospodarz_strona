<?php
	
	/*
	*
	*	This file shows how a module must look like to be loaded by core. Use this file when u wan to make new module.
	*	IMPORTANT: class name must be equal to filename without extension!  
	*
	*/
	
	class panel_grafik
	{
		
		public static function NowaRezerwacja($pokoje) {
			
			$pokojeOpcje = '';
			foreach($pokoje as $pid => $pokoj) {
				$pokojeOpcje .= '<option value="'.$pid.'">'.$pokoj['name'].'</option>';
			}
			
			$formularz = '<form action="" method="post">
				<div class="floater"><label>Pokój:</label><select name="room" class="selectField">
					<option value="0">Wybierz</option>
					'.$pokojeOpcje.'
				</select></div>
				<div class="floater"><label>Data przyjazdu:</label><input type="text" id="dateStart" onchange="countDays();" class="inputField datepicker" value="" name="name"></div>
				<div class="floater"><label>Data wyjazdu:</label><input type="text" id="dateEnd" onchange="countDays();" class="inputField datepicker" value="" name="name"></div>
				<div class="floater"><label>Liczba dni:</label><input id="daysTotal" type="text" class="inputField" value="" name="name" disabled="disabled"></div>
			</form>';
			
			
			
			return $formularz;
		}
		
		public static function Grafik($pokoje) {
			
			$rok = 2013;
			
			$grafik = '<div style="overflow: auto;"><table class="tabela" cellpadding="6" border="1" style="width: auto; text-align: center;"><tr><th rowspan="2">Pokój:</th>
			<th colspan="31">Styczeń '.$rok.'</th>
			<th colspan="28">Luty '.$rok.'</th>
			<th colspan="31">Marzec '.$rok.'</th>
			<th colspan="30">Kwiecień '.$rok.'</th>
			<th colspan="31">Maj '.$rok.'</th>
			<th colspan="30">Czerwiec '.$rok.'</th>
			<th colspan="31">Lipiec '.$rok.'</th>
			<th colspan="31">Sierpień '.$rok.'</th>
			<th colspan="30">Wrzesień '.$rok.'</th>
			<th colspan="31">Październik '.$rok.'</th>
			<th colspan="30">Listopad '.$rok.'</th>
			<th colspan="31">Grudzień '.$rok.'</th>
			</tr>
			<tr>
			';
			
			for($i=1;$i<=31;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=28;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=31;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=30;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=31;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=30;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=31;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=31;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=30;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=31;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=30;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			for($i=1;$i<=31;$i++) {
				$grafik .= '<td style="width: 50px;">'.$i.'</td>';
			}
			$grafik .= '</tr>';
			
			foreach($pokoje as $pid => $pokoj) {
				$kalendarz = '';
				for($i=0;$i<365;$i++) $kalendarz .= '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
				$grafik .= '<tr><td style="font-weight: bold;">'.$pokoj['name'].'</td>'.$kalendarz.'</tr>'; 
			}
			$grafik .= '</table></div>';
			
			return $grafik;
		}
		
		public static function Run()
		{
			Template::SetBlock( 'module_title',  'Core ' . VERSION . ' - Example module' );
			
			Template::SetBlock( 'sub_menu', '<div id="moduleMenu"><a href="#">Nowa rezerwacja</a></div>');
			
			$pokoje = array();
			DataBase::Query('SELECT * FROM ' .DB_PREFIX. 'rooms WHERE active=1;');
			while($r = DataBase::Fetch()) {
				$pokoje[$r['id']] = $r;
			}
			
			if (isset($_GET['new'])) {
				$nowaRezerwacja = self::NowaRezerwacja($pokoje);
				Template::SetBlock( 'module_content', $nowaRezerwacja );
			} else {
				$grafik = self::Grafik($pokoje);
				Template::SetBlock( 'module_content', $grafik );
			}
			
			Template::Show();
		}
	}
	
?>