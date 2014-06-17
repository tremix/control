<?php
class pagina{
	public function comprobar(){
		if(isset($_SESSION['usuario'])){
			$bool = true;
			$permisos = $_SESSION['usuario']['permisos'];
			if($_SERVER['PHP_SELF'] != preURL.'inicio.php' and $_SERVER['PHP_SELF'] != preURL.'perfil.php'){
				foreach($permisos as $key=>$value){
					if($_SERVER['PHP_SELF'] == preURL.$permisos[$key]['link']){
						$bool = false;
					}				
				}
				
				if($bool){
					header('location: inicio.php');
				}
			}
		}else{
			if($_SERVER["PHP_SELF"]<>preURL.'index.php'){
				header('location: index.php');
			}
		}
	}
	public function menu(){
	
		$menu = "";
		
		if(isset($_SESSION['usuario'])){			
			$formularios = $_SESSION['usuario']['permisos'];
			if(is_array($formularios)){
				
				$menu = "<ul id='menu'>";
				
				$actual = $_SERVER['PHP_SELF'];
				
				$class = "";
				if($actual == preURL.'inicio.php'){
					$class = "class='sel'";
				}
				
				$menu .= "<li>";
				$menu .= "<a href='inicio.php' $class>Inicio</a>";
				$menu .= "</li>";
				
				foreach($formularios as $key=>$value){
						$class = "";
						if($actual == preURL.$formularios[$key]['link']){
							$class = "class='sel'";
						}
						
						$menu .= "<li>";
						$menu .= "<a href='{$formularios[$key]['link']}' $class>{$formularios[$key]['formulario']}</a>";
						$menu .= "</li>";
					
				}
				$menu .= "</ul>";
			}else{
				if($_SERVER["PHP_SELF"]<>preURL.'index.php'){
					header('location: '.resources.'salir.php');
				}
			}
		}
		
		return $menu;
	}
	public function alertas(){
		require_once('config.php'); 
		require_once(entities.'alerta.php');
		require_once(entities.'usuario.php');
		$alerta = new alerta();
		$usuario = new usuario();
	
		$idUsuario = $_SESSION['usuario']['id'];
		$idRol = $_SESSION['usuario']['rol'];
		
		$alertas = $alerta->getByUsuarioRol($idUsuario, $idRol);
		
		$html = "";
		
		if(is_array($alertas)){
			$html .= "<table id='grilla'>";		
			$html .= "<thead>";	
			$html .= "<tr>";
			$html .= "<td width='50%'>Contenido</td>";
			$html .= "<td>Fecha</td>";
			$html .= "<td>Enviado por</td>";
			$html .= "<td>Le&iacute;do</td>";
			$html .= "</tr>";			
			$html .= "</thead>";			
			$html .= "<tbody>";	
			for($i=1; $i<=count($alertas); $i++){
				$class = "";
				if($i%2==0){
					$class = " class='alt'";
				}
				
				$enviadoPor = "Sistema";
				if($alertas[$i]['creador']!=0){
					$enviadoPor = $usuario->getNameByID($alertas[$i]['creador']);
				}
				
				$html .= "<tr $class>";
				$html .= "<td>{$alertas[$i]['contenido']} <a href='{$alertas[$i]['link']}'>{$alertas[$i]['nomLink']}</a></td>";
				$html .= "<td>{$alertas[$i]['fecha']}</td>";
				$html .= "<td>$enviadoPor</td>";
				$html .= "<td>";
				$html .= "<a href='alertas_mant.php?opMant=lei&id={$alertas[$i]['id']}' id='accionAlerta'>";
				$html .= "<img src='".images."icon_check.png' ".sizeImg." title='Marcar como le&iacute;do' />";
				$html .= "</a> ";
				$html .= "<a href='alertas_mant.php?opMant=env&id={$alertas[$i]['id']}' id='accionAlerta'>";
				$html .= "<img src='".images."icon_send.png' ".sizeImg." title='Enviar al correo' />";
				$html .= "</a> ";
				$html .= "</td>";
				$html .= "</tr>";
			}		
			$html .= "</tbody>";
			$html .= "</table>";
		}else{
			$html .= "<table>";
			$html .= "<tr>";
			$html .= "<td>";
			$html .= "<p>No tiene ninguna alerta por leer.</p>";
			$html .= "</td>";
			$html .= "</tr>";
			$html .= "</table>";
		}
		return $html;
	}
}
?>