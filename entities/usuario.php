<?php
class usuario{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idUsuario'=>$data['idUsuario'],
                'idRol'=>$data['idRol'],
                'idCargo'=>$data['idCargo'],
                'idNivel'=>$data['idNivel'],
                'nomUsuario'=>$data['nomUsuario'],
                'apeUsuario'=>$data['apeUsuario'],
                'loginUsuario'=>$data['loginUsuario'],
                'passUsuario'=>$data['passUsuario'],
                'emailUsuario'=>$data['emailUsuario'],
                'fechnacUsuario'=>$data['fechnacUsuario'],
                'sexUsuario'=>$data['sexUsuario'],
                'estUsuario'=>$data['estUsuario'],
                'fechCrea'=>$data['fechCrea'],
                'fechEdita'=>$data['fechEdita'],
                'usuCrea'=>$data['usuCrea'],
                'usuEdita'=>$data['usuEdita']
        );
        $this->setArray = $resultado;
    }
    
	function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO usuario VALUES(
						NULL, {$data['idRol']}, {$data['idCargo']}, {$data['idNivel']}, 
						'{$data['nomUsuario']}', '{$data['apeUsuario']}', '{$data['loginUsuario']}', 
						MD5('{$data['passUsuario']}'), '{$data['emailUsuario']}', '{$data['fechnacUsuario']}', 
						'{$data['sexUsuario']}', '{$data['estUsuario']}', NOW(), NULL, {$data['usuCrea']}, NULL
						); ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }
		
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE usuario SET
						id_rol={$data['idRol']}, 
						id_cargo={$data['idCargo']}, 
						id_nivel={$data['idNivel']}, 
						nom_usuario='{$data['nomUsuario']}', 
						ape_usuario='{$data['apeUsuario']}', 
						login_usuario='{$data['loginUsuario']}', 
						email_usuario='{$data['emailUsuario']}', 
						fechnac_usuario='{$data['fechnacUsuario']}', 
						sex_usuario='{$data['sexUsuario']}', 
						est_usuario='{$data['estUsuario']}', 
						fech_edita=NOW(),
						usu_edita={$data['usuEdita']}
						WHERE id_usuario={$data['idUsuario']}; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	function updateStatus($id) {
		$consulta = "	UPDATE usuario SET
						est_usuario = 'E'
						WHERE id_usuario = $id; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
		
	function delete($id) {
		$data = $this->setArray;
		$consulta = "	DELETE FROM usuario WHERE id_usuario = $id; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	function login($login, $pass){
		$consulta = " 	SELECT u.id_usuario
						FROM usuario u 
						WHERE u.login_usuario LIKE '$login' 
						AND u.pass_usuario LIKE  MD5('$pass'); ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$idUsuario = mysql_result($resultado, 0, "id_usuario");
			$usuario = $this->buscarSesion($idUsuario);
			if($usuario<>""){
				$_SESSION['usuario'] = $usuario;
				
				require_once(entities.'permiso.php');
				$permiso = new permiso();
				$_SESSION['usuario']['permisos'] = $permiso->getByUsuarioRol($usuario['id'], $usuario['rol']);
			}
			return true;
		}else{
			return false;
		}
	}
	
	public function buscarSesion($idUsuario){
		$consulta = " 	SELECT u.id_usuario, u.nom_usuario, u.ape_usuario, u.id_rol, u.sex_usuario, 
						email_usuario, est_usuario
						FROM usuario u 
						WHERE u.id_usuario = $idUsuario
						AND u.est_usuario='A'; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){			
			$usuario['id'] = mysql_result($resultado, 0, "id_usuario");
			$usuario['nombre'] = mysql_result($resultado, 0, "nom_usuario");
			$usuario['apellido'] = mysql_result($resultado, 0, "ape_usuario");
			$usuario['rol'] = mysql_result($resultado, 0, "id_rol");
			$usuario['sexo'] = mysql_result($resultado, 0, "sex_usuario");
			$usuario['email'] = mysql_result($resultado, 0, "email_usuario");
			$usuario['estado'] = mysql_result($resultado, 0, "est_usuario");
		}else{
			$usuario = "";
		}
		mysql_free_result($resultado);
		return $usuario;
	}	
	
	public function get($id){
		$consulta = "	SELECT id_usuario, id_rol, id_cargo, id_nivel, nom_usuario,
						ape_usuario, login_usuario, pass_usuario, email_usuario,
						fechnac_usuario, sex_usuario, est_usuario
						FROM usuario 
						WHERE id_usuario = $id;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$usuario= array(
				"idUsuario" => mysql_result($resultado, 0, "id_usuario"),
				"idRol" => mysql_result($resultado, 0, "id_rol"),
				"idCargo" => mysql_result($resultado, 0, "id_cargo"),
				"idNivel" => mysql_result($resultado, 0, "id_nivel"),
				"nomUsuario" => mysql_result($resultado, 0, "nom_usuario"),
				"apeUsuario" => mysql_result($resultado, 0, "ape_usuario"),
				"loginUsuario" => mysql_result($resultado, 0, "login_usuario"),
				"passUsuario" => mysql_result($resultado, 0, "pass_usuario"),
				"emailUsuario" => mysql_result($resultado, 0, "email_usuario"),
				"fechnacUsuario" => mysql_result($resultado, 0, "fechnac_usuario"),
				"sexUsuario" => mysql_result($resultado, 0, "sex_usuario"),
				"estUsuario" => mysql_result($resultado, 0, "est_usuario") 
			);
		}else{
			$usuario = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $usuario;
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
							OR n.nom_nivel LIKE '%$buscar%' OR c.nom_cargo LIKE '%$buscar%'
							OR r.nom_rol LIKE '%$buscar%')";
		}
		
		$consulta = " 	SELECT u.id_usuario AS 'ID', IFNULL(n.nom_nivel, 'No especificado') AS '&Aacute;rea', 
						IFNULL(c.nom_cargo, 'No especificado') AS  'Cargo', u.ape_usuario AS 'Apellidos',
						u.nom_usuario AS 'Nombre', IFNULL(r.nom_rol, 'No especificado') AS 'Tipo de usuario'					
						FROM usuario u
						LEFT OUTER JOIN rol r ON u.id_rol = r.id_rol
						LEFT OUTER JOIN nivel n ON u.id_nivel = n.id_nivel
						LEFT OUTER JOIN cargo c ON u.id_cargo = c.id_cargo
						WHERE u.est_usuario <> 'E'
						$condicion
						$orden
						$limite
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$cliente = $general->consulta($resultado);
		}else{
			$cliente = "";
		}
		mysql_free_result($resultado);
		return $cliente;
	}	
	
	public function numRows($buscar=''){
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND (u.nom_usuario LIKE '%$buscar%' OR u.ape_usuario LIKE '%$buscar%'
							OR n.nom_nivel LIKE '%$buscar%' OR c.nom_cargo LIKE '%$buscar%'
							OR r.nom_rol LIKE '%$buscar%')";
		}
		$consulta = "	SELECT COUNT(u.id_usuario) AS 'total'
						FROM usuario u
						LEFT OUTER JOIN rol r ON u.id_rol = r.id_rol
						LEFT OUTER JOIN nivel n ON u.id_nivel = n.id_nivel
						LEFT OUTER JOIN cargo c ON u.id_cargo = c.id_cargo
						WHERE u.est_usuario <> 'E'
						$condicion;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$cliente = mysql_result($resultado, 0, "total");
		}else{
			$cliente = 0;
		}
		mysql_free_result($resultado);
		$this->numRows = $cliente;
	}
	
	public function getNameByID($idUsuario){
		$consulta = " 	SELECT u.nom_usuario
						FROM usuario u 
						WHERE u.id_usuario = $idUsuario; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$usuario = mysql_result($resultado, 0, "nom_usuario");
		}else{
			$usuario = "";
		}
		mysql_free_result($resultado);
		return $usuario;
	}	
	
	public function getAgeByID($idUsuario){
		$consulta = " 	SELECT TRUNCATE(((TO_DAYS(NOW()) - TO_DAYS(u.fechnac_usuario))/365), 0) AS 'edad'
						FROM usuario u 
						WHERE u.id_usuario = $idUsuario; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$usuario = mysql_result($resultado, 0, "edad");
		}else{
			$usuario = "";
		}
		mysql_free_result($resultado);
		return $usuario;
	}
	
	public function checkPassword($idUsuario, $passUsuario){
		$consulta = " 	SELECT id_usuario
						FROM usuario u 
						WHERE id_usuario = $idUsuario 
						AND pass_usuario LIKE  MD5('$passUsuario'); ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			return true;
		}else{
			return false;
		}
	}
	
	function updatePassword($idUsuario, $passUsuario){
		$consulta = " 	UPDATE usuario SET
						pass_usuario = MD5('$passUsuario')
						WHERE id_usuario = $idUsuario; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		return $resultado;
	}
	
	public function getCombo(){
		$consulta = " 	SELECT u.id_usuario, u.nom_usuario, u.ape_usuario
                                FROM usuario u
                                WHERE u.est_usuario = 'A'
                                ORDER BY u.ape_usuario, u.nom_usuario ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$usuario[$i]['id'] = $fila['id_usuario'];
				$usuario[$i]['nombre'] = $fila['ape_usuario'] . ", " . $fila['nom_usuario'];
				$i++;
			}
		}else{
			$usuario = "";
		}
		mysql_free_result($resultado);
		return $usuario;
	}	
}
?>