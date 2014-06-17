<?php
class alerta{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idAlerta'=>$data['idAlerta'],
                'idUsuario'=>$data['idUsuario'],
                'idRol'=>$data['idRol'],
                'conteAlerta'=>$data['conteAlerta'],
                'linkAlerta'=>$data['linkAlerta'],
                'nomlinkAlerta'=>$data['nomlinkAlerta'],
                'fechAlerta'=>$data['fechAlerta'],
                'fechCrea'=>$data['fechCrea'],
                'usuCrea'=>$data['usuCrea'],
        );
        $this->setArray = $resultado;
    }
    function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO alerta VALUES(
						NULL, {$data['idUsuario']}, {$data['idRol']}, '{$data['conteAlerta']}',
						'{$data['linkAlerta']}', '{$data['nomlinkAlerta']}', '{$data['fechAlerta']}',
						NOW(), {$data['usuCrea']}
						);";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }	
	function update() {
    }
	function delete($id) {
    }
	
	public function get($id){
		$consulta = "	SELECT conte_alerta, link_alerta, nomlink_alerta, 
						fech_alerta, usu_crea
						FROM alerta
						WHERE id_alerta = $id;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$alerta= array(
				"contenido" => mysql_result($resultado, 0, "conte_alerta"),
				"link" => mysql_result($resultado, 0, "link_alerta"),
				"nomLink" => mysql_result($resultado, 0, "nomlink_alerta"),
				"fecha" => mysql_result($resultado, 0, "fech_alerta"),
				"creador" => mysql_result($resultado, 0, "usu_crea") 
			);
		}else{
			$alerta = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $alerta;
	}
	
	public function getByUsuarioRol($idUsuario, $idRol){
		$consulta = " 	SELECT a.id_alerta, a.conte_alerta, a.link_alerta, a.nomlink_alerta,
						a.fech_alerta, a.usu_crea
						FROM alerta a
						WHERE ((a.id_usuario = $idUsuario
						OR a.id_rol = $idRol)
						OR (a.id_usuario IS NULL AND a.id_rol IS NULL))
						AND a.id_alerta NOT IN(
							SELECT la.id_alerta FROM leido_alerta la WHERE la.id_usuario = $idUsuario
						)
						ORDER BY a.fech_alerta DESC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i = 1;
			while($fila = mysql_fetch_array($resultado)){
				$alerta[$i]['id'] = $fila['id_alerta'];
				$alerta[$i]['contenido'] = $fila['conte_alerta'];
				$alerta[$i]['link'] = $fila['link_alerta'];
				$alerta[$i]['nomLink'] = $fila['nomlink_alerta'];
				$alerta[$i]['fecha'] = $fila['fech_alerta'];
				$alerta[$i]['creador'] = $fila['usu_crea'];
				$i++;
			}
		}else{
			$alerta = "";
		}
		mysql_free_result($resultado);
		return $alerta;
	}
	public function show($buscar="", $pag = ""){
		
		$sentido = "";
		$orden = "";
		$limite = "";
		
		if(is_array($pag)){
			if($pag['colPag']<>""){			
				if($pag['ascPag']){
					$sentido = "ASC";
				}else{
					$sentido = "DESC";
				}
				$orden = "ORDER BY {$pag['colPag']} $sentido";
			}
			
			$pag['actualPag'] *= $pag['cantPag'];
			
			$limite = "LIMIT {$pag['actualPag']}, {$pag['cantPag']}";
		}
		
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND (u.nom_usuario LIKE '%$buscar%' OR u.ape_usuario LIKE '%$buscar%'
							OR r.nom_rol LIKE '%$buscar%' OR a.conte_alerta LIKE '%$buscar%')";
		}
		
		$consulta = " 	SELECT a.id_alerta AS 'ID', IFNULL(r.nom_rol, 'Ninguno') AS 'Tipo de Usuario', 
						IF(a.id_usuario IS NOT NULL, CONCAT(u.nom_usuario, ' ', u.ape_usuario), 'Todos') AS  'Usuario',
						a.conte_alerta AS 'Contenido', a.fech_alerta AS 'Fecha', 
						IF(la.id_alerta IS NOT NULL, 'S&iacute;', 'No') AS 'Le&iacute;do',
						IF(a.usu_crea = 0, 'Sistema', CONCAT(u2.nom_usuario, ' ', u2.ape_usuario)) AS 'Creado por'
						FROM alerta a
						LEFT OUTER JOIN rol r ON a.id_rol = r.id_rol
						LEFT OUTER JOIN usuario u ON a.id_usuario = u.id_usuario
						LEFT OUTER JOIN leido_alerta la ON la.id_alerta = a.id_alerta
						LEFT OUTER JOIN usuario u2 ON a.usu_crea = u2.id_usuario
						WHERE (a.id_usuario = {$_SESSION['usuario']['id']} OR a.id_rol = {$_SESSION['usuario']['rol']})
						OR (a.id_usuario IS NULL AND a.id_rol IS NULL)
						$condicion
						$orden
						$limite
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$alerta = $general->consulta($resultado);
		}else{
			$alerta = "";
		}
		mysql_free_result($resultado);
		return $alerta;
	}	
	
	public function numRows($buscar=''){
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND (u.nom_usuario LIKE '%$buscar%' OR u.ape_usuario LIKE '%$buscar%'
							OR r.nom_rol LIKE '%$buscar%' OR a.conte_alerta LIKE '%$buscar%')";
		}
		$consulta = "	SELECT COUNT(a.id_alerta) AS 'total'
						FROM alerta a
						LEFT OUTER JOIN rol r ON a.id_rol = r.id_rol
						LEFT OUTER JOIN usuario u ON a.id_usuario = u.id_usuario
						LEFT OUTER JOIN leido_alerta la ON la.id_alerta = a.id_alerta
						LEFT OUTER JOIN usuario u2 ON a.usu_crea = u2.id_usuario
						WHERE (a.id_usuario = {$_SESSION['usuario']['id']} OR a.id_rol = {$_SESSION['usuario']['rol']})
						OR (a.id_usuario IS NULL AND a.id_rol IS NULL)
						$condicion;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$alerta = mysql_result($resultado, 0, "total");
		}else{
			$alerta = 0;
		}
		mysql_free_result($resultado);
		$this->numRows = $alerta;
	}
}
?>