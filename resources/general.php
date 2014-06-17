<?php
class general{
	public function consulta($resultado){
		//Obtener el número de columnas recuperados en la consulta.
		$num = mysql_num_fields($resultado);
		//Ingresamos en el primer registro del array los datos del resultado de la consulta			
		for($i=0; $i<$num; $i++){
			$resultadoOrd[0][] = mysql_field_name($resultado, $i);
		}
		$i = 1;
		while($fila = mysql_fetch_array($resultado)){
			for($j=0; $j<$num; $j++){
				$resultadoOrd[$i][$resultadoOrd[0][$j]] = $fila[$resultadoOrd[0][$j]];
			}
			$i++;
		}
		return $resultadoOrd;
	}
	public function ordenarPorCol($datos, $columna, $asc=true){
		//Usamos un array auxiliar donde podremos reordenar los datos
		//y otro para guardar los datos generales.		
		//Usando los datos de la columna seleccionada pasaremos los datos
		//a un array.
		for($i=1; $i<=count($datos); $i++){
			$auxDatos[$i] = $datos[$i][$columna];
		}
		
		$auxDatosGen = $datos;
		
		//Guardamos la cabecera en un array extra.
		$cabecera = $datos[0];
		
		//Ahora borraremos los datos del array de datos para poder
		//poner alli los datos reordenados.
		unset($datos);
		
		//Ahora ordenaremos.
		if($asc){
			asort($auxDatos);
		}else{
			arsort($auxDatos);
		}
		
		//Luego usaremos el nuevo orden de la columna para reordenar los datos generales.
		//Anterior a ello le pondremos al cabecera.
		$datos[0] = $cabecera;
		foreach($auxDatos as $key => $value){
			$datos[] = $auxDatosGen[$key];
		}
		
		return $datos;
	}
	public function grilla($datos, $titulo='', $ico='', $link='', $opIcon=true, $difLink=false, $pag=false, $paramPag=''){
		$difDiv = "";
		//Usaremos $difLink también para generar un DIV diferente para las llamadas AJAX de las grillas.
		if($difLink){
			$difDiv = "Dif";
		}
		if(is_array($datos)){
			$col = count($datos[0])-1;
			$fil = count($datos)-1;
			
			//Desde aquí pondremos los elementos necesarios para la paginación.
			$paginacion = "";
			if($pag){
				$select = array(10=>"", 20=>"", 50=>"", 100=>"");
				$select[$paramPag['cantPag']] = "SELECTED";
				
				$colSel = $paramPag['colPag'];
				$simboloPag = "";
				if($paramPag['ascPag']){
					$simboloPag = "&#8595;";
				}else{					
					$simboloPag = "&#8593;";
				}
				
				$cantPaginas = ceil($paramPag['totalPag']/$paramPag['cantPag']);
			
				$paginacion .= "<input type='hidden' id='totalPag' name='totalPag' value='{$paramPag['totalPag']}' />";
				$paginacion .= "<input type='hidden' id='actualPag' name='actualPag' value='{$paramPag['actualPag']}' />";
				$paginacion .= "<input type='hidden' id='colPag' name='colPag' value='{$paramPag['colPag']}' />";
				$paginacion .= "<input type='hidden' id='ascPag' name='ascPag' value='{$paramPag['ascPag']}' />";
				$paginacion .= "<table id='paginacion'>";
				$paginacion .= "<tr>";
				$paginacion .= "<td>";
				$paginacion .= "<label for='cantPag'>Cantidad:</label>";
				$paginacion .= "<select id='cantPag' name='cantPag' size='1'>";
				$paginacion .= "<option value='10' {$select[10]}>10 registros</option>";
				$paginacion .= "<option value='20' {$select[20]}>20 registros</option>";
				$paginacion .= "<option value='50' {$select[50]}>50 registros</option>";
				$paginacion .= "<option value='100' {$select[100]}>100 registros</option>";
				$paginacion .= "</select>";
				$paginacion .= "</td>";
				$paginacion .= "<td><a href='#' id='selPag' name='0' class='sel'><< Primero</a></td>";
				
				if($paramPag['actualPag']<>0){
					$paginacion .= "<td><a href='#' id='selPag' name='".($paramPag['actualPag']-1)."' class='sel'>< Anterior</a></td>";
				}
				
				if(($cantPaginas - $paramPag['actualPag'])>10){
					for($i = $paramPag['actualPag']; $i<=($paramPag['actualPag']+5); $i++){
						$class = "";
						if($paramPag['actualPag']==$i){
							$class = "class='sel'";
						}
						$paginacion .= "<td><a href='#' id='selPag' name='$i' $class>".($i+1)."</a></td>";					
					}
					$paginacion .= "<td><a>. . .</a></td>";
					for($i = ($cantPaginas-5); $i<=$cantPaginas; $i++){
						$class = "";
						if($paramPag['actualPag']==($i-1)){
							$class = "class='sel'";
						}
						$paginacion .= "<td><a href='#' id='selPag' name='".($i-1)."' $class>$i</a></td>";					
					}
					
				}else{
					if($cantPaginas>=$paramPag['cantPag']){
						for($i =($cantPaginas - $paramPag['cantPag'] + 1); $i<=$cantPaginas; $i++){
							$class = "";
							if($paramPag['actualPag']==($i-1)){
								$class = "class='sel'";
							}
							$paginacion .= "<td><a href='#' id='selPag' name='".($i-1)."' $class>$i</a></td>";					
						}
					}else{						
						for($i = 1; $i<= $cantPaginas; $i++){
							$class = "";
							if($paramPag['actualPag']==($i-1)){
								$class = "class='sel'";
							}
							$paginacion .= "<td><a href='#' id='selPag' name='".($i-1)."' $class>$i</a></td>";					
						}
					}
				}
							
				if($paramPag['actualPag']<>($cantPaginas-1)){
					$paginacion .= "<td><a href='#' id='selPag' name='".($paramPag['actualPag']+1)."' class='sel'>Siguiente ></a></td>";
				}	
				$paginacion .= "<td><a href='#' id='selPag' name='".($cantPaginas-1)."' class='sel'>&Uacute;ltimo >></a></td>";
				$paginacion .= "</tr>";
				$paginacion .= "</table>";
			}
						
			$tabla = "";
			$tabla .= "<div id='contenedorGrilla$difDiv'>";
			if($titulo<>''){
				$tabla .= "<script src='".scripts."grilla.js' language='javascript' type='text/javascript'></script>";
				$tabla .= "<link href='".css."grilla.css' type='text/css' rel='stylesheet' />";
			}
			$tabla .= "<h1 id='grilla'>".$titulo."</h1>";
			$tabla .= "<table id='grilla'>";
			$tabla .= "<thead>";
			$tabla .= "<tr>";
			if($ico<>''){
				$tabla .= "<td></td>";
			}
			if($link<>''){
				$tabla .= "<td>Opciones</td>";
			}
			
			if($pag){
				for($i=1; $i<=$col; $i++){
					$adicional = "";
					$class = "";
					if(($i+1) == $colSel){
						$adicional = $simboloPag;
						$class = " class='sel'";
					}
					$tabla .= "<td><a href='#' id='colPag' name='".($i+1)."' $class>".$datos[0][$i]." $adicional</a></td>";
				}
			}else{
				for($i=1; $i<=$col; $i++){
					$tabla .= "<td>".$datos[0][$i]."</td>";
				}
				
			}
			$tabla .= "</tr>";
			$tabla .= "</thead>";
			$tabla .= "<tbody>";
			for($i=1; $i<=$fil; $i++){
				$class = "";
				if($i%2==0){
					$class = " class='alt'";
				}
				$tabla .= "<tr $class>";
				if($ico<>''){
					$tabla .= "<td class='cent'>";
					$tabla .= "<img src='".images.$ico."' ".sizeImg." />";
					$tabla .= /*($i).*/"</td>";
				}
				if($link<>''){
					$editar = "Editar";
					$eliminar = "Eliminar";
					$word = "Word";
					$excel = "Excel";
					if($opIcon){
						$editar = "<img src='".images."icon_edit.png' alt='Editar' ".sizeImg."/>";
						$eliminar = "<img src='".images."icon_delete.png' alt='Eliminar' ".sizeImg."/>";
						//$word = "<img src='".images."icon_word.png' alt='Exportar a Word' ".sizeImg."/>";
						//$excel = "<img src='".images."icon_excel.png' alt='Exportar a Excel' ".sizeImg."/>";
					}
					$dif = "";
					if($difLink){
						$dif = "Dif";
					}
					$tabla .= "<td>";
					$tabla .= "<a id='editar$dif' href='$link?opMant$dif=li&id=".$datos[$i][$datos[0][0]]."' >$editar</a> - ";
					$tabla .= "<a id='eliminar$dif' href='$link?opMant$dif=el&id=".$datos[$i][$datos[0][0]]."' >$eliminar</a>";
					/*if($extra){
						$tabla .= " - <a id='word$dif' href='$link?opMant$dif=wo&id=".$datos[$i][$datos[0][0]]."' >$word</a> - ";
						$tabla .= "<a id='excel$dif' href='$link?opMant$dif=ex&id=".$datos[$i][$datos[0][0]]."' >$excel</a>";
					}*/
					$tabla .= "</td>";
				}
				for($j=1; $j<=$col; $j++){
					$tabla .= "<td>".$datos[$i][$datos[0][$j]]."</td>";
				}
				$tabla .= "</tr>";
			}
			$tabla .= "</tbody>";
			$tabla .= "</table>";
			
			$tabla .= $paginacion;
			
			$tabla .= "</div>";
			
			return $tabla;		
		}else{
			$msj = "";
			$msj .= "<div id='contenedorGrilla$difDiv'>";
			$msj .= "<script src='".scripts."grilla.js' language='javascript' type='text/javascript'></script>";
			$msj .= "<link href='".css."grilla.css' type='text/css' rel='stylesheet' />";
			$msj .= "<h1 id='grilla'>".$titulo."</h1>";
			$msj .= "<table id='grilla'>";
			$msj .= "<tr id='none'>";
			$msj .= "<td><p>No se tienen registros.</p></td>";
			$msj .= "</tr>";
			$msj .= "</table>";
			$msj .= "</div>";
			return $msj;
		}
	}
	public function combo($entitie, $nomCombo, $nomLabel, $id=0, $extra=''){
		$combo = "";
		if($nomLabel<>''){
			$combo .= "<label for='$nomCombo'>$nomLabel</label>";
		}
                $combo .= "<select id='{$nomCombo}' name='{$nomCombo}' size='1' {$extra}>";
		$combo .= "<option value='NULL'>Selecciona un elemento</option>";
		if(is_array($entitie)){
			for($i=0; $i<count($entitie); $i++){
				$select = "";
				if($id==$entitie[$i]['id']){
					$select = " SELECTED ";
				}
				$combo .= "<option value='";
				$combo .= $entitie[$i]['id'];
				if(isset($entitie[$i]['descripcion'])){
					$combo .= "' title='{$entitie[$i]['descripcion']}";
				}
                                $combo .= "' {$select}>".$entitie[$i]['nombre'];
				$combo .= "</option>";
			}
		}
		$combo .= "</select>";
		return $combo;
	}
	public function checkbox($entitie, $nomCheckbox, $boolSalto, $listCheckbox=0){
		$checkbox = "";
		$salto = "";
		if($boolSalto){
			$salto = "<br />";
		}
		if($entitie<>""){
			for($i=0; $i<count($entitie); $i++){
				$select = "";
				if(is_array($listCheckbox)){
					for($j=0; $j<count($listCheckbox); $j++){
						if($entitie[$i]['id']==$listCheckbox[$j]['id']){
							$select = " CHECKED ";
						}
					}
				}
				$checkbox .= "<input type='checkbox'";
				$checkbox .= " id='$nomCheckbox".($i+1)."'";
				$checkbox .= " name='$nomCheckbox".($i+1)."'";
				$checkbox .= " value='".$entitie[$i]['id']."'";
				$checkbox .= " $select />";
				$checkbox .= "<label for='$nomCheckbox".($i+1)."'>";
				$checkbox .= $entitie[$i]['nombre'];
				$checkbox .= "</label>";
				$checkbox .= $salto;
			}
		}
		
		return $checkbox;
	}
	public function generarClave($numCaracteres=8){
		$caracteres = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		
		$clave = "";
		for($i=1; $i<=$numCaracteres; $i++){
			$clave .= $caracteres[round(rand(0, (strlen($caracteres)-1)))];
		}
		return $clave;
	}
	public function validarCorreo($correo){
		return preg_match("/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/", $correo);
	}
	public function enviarMail($destinatario, $asunto, $mensaje){
		require_once(resources.'phpmailer/class.phpmailer.php');
		require_once(resources.'phpmailer/class.smtp.php');
		
		$mail = new PHPMailer();
				
		$mail->IsSMTP(); 	
		$mail->IsHTML(true); 		
		$mail->Host = "dho.com.pe";		
		$mail->From = "intranet@dho.com.pe";		
		$mail->FromName = "Intranet DHO Consultores";
		$mail->SMTPAuth = true;		
		$mail->Username = "intranet@dho.com.pe";
		$mail->Password = "1nTr4n3tD4o";		
		$mail->Subject = $asunto;
		$mail->AltBody = $mensaje; 
		
		$html = "";
		
		$html .= "
			<html>
				<head>
					<style>
						p, h1, a{font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #000;}
						h1{font-size: 14px; color: #FF9900;}
						a{text-decoration: underline; font-weight: bold; color: #444;}
						p.postdata{font-size: 10px; font-weight: bold; color: #666;}
					</style>
				</head>
				<body>
					<h1>{$asunto}</h1>
					<p>{$mensaje}</p>
					<p class='postdata'>Este es un mensaje autom&aacute;tico del sistema, por favor no responder a &eacute; ni escribir a esta direcci&oacute;n de correo electr&oacute;nico.</p>
				</body>
			</html>
			";
		
		$mail->MsgHTML($html);
		if(is_array($destinatario)){
			foreach($destinatario as $d){				
				$mail->AddAddress($d);
			}
		}else{
			$mail->AddAddress($destinatario);
		}
		return $mail->Send();
	}
	
	function enviarCita($destinatario, $asunto, $fecha_inicio, $fecha_fin) {
	
		ini_set('SMTP', 'mail.dho.com.pe');
		ini_set('sendmail_from', 'intranet@dho.com.pe');

		$nombre_from = "Intranet DHO Consultores";
		$email_from = "intranet@dho.com.pe";
		$evento_nombre = $asunto;
		$evento_descripcion = "\n";
		$meeting_location = ""; 
		
		
		//Convertimos la fecha de formato MYSQL (YYYY-MM-DD HH:MM:SS) a formato UTC (yyyymmddThhmmssZ)
		$meetingstamp = strtotime($fecha_inicio . " UTC");    
		$meetingstampb = strtotime($fecha_fin . " UTC");     
		$dtstart= gmdate("Ymd\THis\Z",$meetingstamp);
		$dtend= gmdate("Ymd\THis\Z",$meetingstampb);
		$todaystamp = gmdate("Ymd\THis\Z");
		
		//Creamos identificador único aleatorio para el mensaje
		$cal_uid = date('Ymd').'T'.date('His')."-".rand()."ejemplo.com";
		
		//Establecemos el formato del MIME 
		$mime_boundary = "----Meeting Booking----".md5(time());
		
		//Creamos los headers del mail
		$headers = "From: ".$nombre_from." <".$email_from.">\n";
		$headers .= "Reply-To: ".$nombre_from." <".$email_from.">\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
		$headers .= "Content-class: urn:content-classes:calendarmessage\n";
		
		//Creamos el cuerpo de texto del mail (HTML)
		$message = "";
		$message .= "--$mime_boundary\n";
		$message .= "Content-Type: text/html; charset=UTF-8\n";
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= "<html>\n";
		$message .= "<body>\n";
		$message .= '<p>Convocatoria generada por la Intranet DHO Consultores.</p>';
		$message .= "</body>\n";
		$message .= "</html>\n";
		$message .= "--$mime_boundary\n";
		
		//Ahora armamos los datos en formato iCalendar
		$ical =    'BEGIN:VCALENDAR
		PRODID:-//Microsoft Corporation//Outlook 12.0 MIMEDIR//EN
		VERSION:2.0
		METHOD:PUBLISH
		
		X-MS-OLK-FORCEINSPECTOROPEN:TRUE
		
		BEGIN:VEVENT
		ORGANIZER:MAILTO:'.$email_from.'
		CREATED:'.$dtstart.'
		DESCRIPTION;'.$asunto.'
		DTSTART:'.$dtstart.'
		DTEND:'.$dtend.'
		LOCATION:'.$meeting_location.'
		TRANSP:OPAQUE
		SEQUENCE:0
		LANGUAGE=en-us
		UID:'.$cal_uid.'
		DTSTAMP:'.$todaystamp.'
		DESCRIPTION:'.$evento_descripcion.'
		SUMMARY:'.$asunto.'
		PRIORITY:5
		CLASS:PUBLIC
		UID:040000008200E00074C5B7101A82E008000000008062306C6261CA01000000000000000
		
		X-MICROSOFT-CDO-BUSYSTATUS:BUSY
		X-MICROSOFT-CDO-IMPORTANCE:1
		X-MICROSOFT-DISALLOW-COUNTER:FALSE
		X-MS-OLK-ALLOWEXTERNCHECK:TRUE
		X-MS-OLK-AUTOFILLLOCATION:FALSE
		X-MS-OLK-CONFTYPE:0

		BEGIN:VALARM
		TRIGGER:-PT1440M
		ACTION:DISPLAY
		DESCRIPTION:Reminder
		END:VALARM
		END:VEVENT
		END:VCALENDAR
		
		';
		
		//Agregamos al cuerpo del mensaje la iCal
		$message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST\n';
		$message .= "Content-Transfer-Encoding: 8bit\n\n";
		$message .= $ical;
				
		//Enviamos el mail y validamos si se envió o no
		return mail($destinatario, $asunto, $message, $headers); 
	}	 
}
?>