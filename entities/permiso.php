<?php
class permiso{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idPermiso'=>$data['idPermiso'],
                'idUsuario'=>$data['idUsuario'],
                'idRol'=>$data['idRol'],
                'idFormulario'=>$data['idFormulario'],
                'permiFormulario'=>$data['permiFormulario'],
                'fechCrea'=>$data['fechCrea'],
                'fechEdita'=>$data['fechEdita'],
                'usuCrea'=>$data['usuCrea'],
                'usuEdita'=>$data['usuEdita']
        );
        $this->setArray = $resultado;
    }
    function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO permiso VALUES(
						NULL, {$data['idUsuario']}, {$data['idRol']}, {$data['idFormulario']}, 
						'{$data['permiFormulario']}', NOW(), NULL, {$data['usuCrea']}, NULL
						); ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }	
	
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE permiso SET
						id_permiso={$data['idUsuario']}, 
						id_rol={$data['idRol']}, 
						id_formulario={$data['idFormulario']}, 
						permi_formulario='{$data['permiFormulario']}', 
						fech_edita=NOW(), 
						usu_edita={$data['usuEdita']}
						WHERE id_permiso = {$data['idPermiso']}; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
		
	function delete($id) {
		$data = $this->setArray;
		$consulta = "	DELETE FROM permiso WHERE id_permiso = $id; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	public function get($id){
		$consulta = "	SELECT id_permiso, id_usuario, id_rol, id_formulario, permi_formulario						
						FROM permiso
						WHERE id_permiso = $id;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$permiso= array(
				"idPermiso" => mysql_result($resultado, 0, "id_permiso"),
				"idUsuario" => mysql_result($resultado, 0, "id_usuario"),
				"idRol" => mysql_result($resultado, 0, "id_rol"),
				"idFormulario" => mysql_result($resultado, 0, "id_formulario"),
				"permiFormulario" => mysql_result($resultado, 0, "permi_formulario")
			);
		}else{
			$permiso = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $permiso;
	}
	
	public function getByUsuarioRol($idUsuario, $idRol){
		$consulta = " 	SELECT p.id_formulario, p.permi_formulario,
						f.nom_formulario, f.link_formulario
						FROM permiso p 
						INNER JOIN formulario f ON p.id_formulario = f.id_formulario
						WHERE (p.id_usuario = $idUsuario OR p.id_rol = $idRol)
						OR (p.id_usuario IS NULL AND p.id_rol IS NULL); ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			while($fila = mysql_fetch_array($resultado)){				
				$permiso[$fila['id_formulario']] = array(
					"formulario" => $fila['nom_formulario'],
					"link" => $fila['link_formulario'],
					"permiso" => array($fila['permi_formulario'])
				);
			}
		}else{
			$permiso = "";
		}
		mysql_free_result($resultado);
		return $permiso;
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
							OR r.nom_rol LIKE '%$buscar%' OR f.nom_formulario LIKE '%$buscar%')";
		}
		
		$consulta = " 	SELECT p.id_permiso AS 'ID', IF(p.id_usuario IS NULL AND p.id_rol IS NULL, 'Todos', 
						IF(p.id_rol IS NOT NULL, r.nom_rol, CONCAT(u.nom_usuario , ' ', u.ape_usuario))) 
						AS 'Aplica a', f.nom_formulario AS 'Formulario'
						FROM permiso p
						INNER JOIN formulario f ON p.id_formulario = f.id_formulario
						LEFT OUTER JOIN usuario u ON p.id_usuario = u.id_usuario
						LEFT OUTER JOIN rol r ON p.id_rol = r.id_rol
						WHERE TRUE
						$condicion
						$orden
						$limite
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$permiso = $general->consulta($resultado);
		}else{
			$permiso = "";
		}
		mysql_free_result($resultado);
		return $permiso;
	}	
	
	public function numRows($buscar=''){
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND (u.nom_usuario LIKE '%$buscar%' OR u.ape_usuario LIKE '%$buscar%'
							OR r.nom_rol LIKE '%$buscar%' OR f.nom_formulario LIKE '%$buscar%')";
		}
		$consulta = "	SELECT COUNT(p.id_permiso) AS 'total'
						FROM permiso p				
						INNER JOIN formulario f ON p.id_formulario = f.id_formulario
						LEFT OUTER JOIN usuario u ON p.id_usuario = u.id_usuario
						LEFT OUTER JOIN rol r ON p.id_rol = r.id_rol		
						$condicion;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$permiso = mysql_result($resultado, 0, "total");
		}else{
			$permiso = 0;
		}
		mysql_free_result($resultado);
		$this->numRows = $permiso;
	}
}
?>