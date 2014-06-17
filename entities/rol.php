<?php
class rol{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idRol'=>$data['idRol'],
                'nomRol'=>$data['nomRol'],
                'estRol'=>$data['estRol']
        );
        $this->setArray = $resultado;
    }
   
   	function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO rol VALUES(
						NULL, '{$data['nomRol']}', 1); ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }	
	
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE rol SET						
						nom_rol='{$data['nomRol']}'
						WHERE id_rol = {$data['idRol']}; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	function updateStatus($id) {
		$consulta = "	UPDATE rol SET
						est_rol = 0
						WHERE id_rol = $id; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
		
	function delete($id) {
		$data = $this->setArray;
		$consulta = "	DELETE FROM rol WHERE id_rol = $id; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	public function get($id){
		$consulta = "	SELECT id_rol, nom_rol, est_rol					
						FROM rol
						WHERE id_rol = $id;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$rol= array(
				"idRol" => mysql_result($resultado, 0, "id_rol"),
				"nomRol" => mysql_result($resultado, 0, "nom_rol"),
				"estRol" => mysql_result($resultado, 0, "est_rol")
			);
		}else{
			$rol = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $rol;
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
			$condicion .= "	AND r.nom_rol LIKE '%$buscar'%";
		}
		
		$consulta = " 	SELECT r.id_rol AS 'ID', r.nom_rol AS 'Nombre'			
						FROM rol r
						WHERE r.est_rol <> 0
						$condicion
						$orden
						$limite
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$rol = $general->consulta($resultado);
		}else{
			$rol = "";
		}
		mysql_free_result($resultado);
		return $rol;
	}	
	
	public function numRows($buscar=''){
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND r.nom_rol LIKE '%$buscar'%";
		}
		$consulta = "	SELECT COUNT(r.id_rol) AS 'total'
						FROM rol r
						WHERE r.est_rol <> 0
						$condicion;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$rol = mysql_result($resultado, 0, "total");
		}else{
			$rol = 0;
		}
		mysql_free_result($resultado);
		$this->numRows = $rol;
	}
	
	public function getCombo(){
		$consulta = " 	SELECT r.id_rol, r.nom_rol
						FROM rol r
						WHERE est_rol <> 0
						ORDER BY r.nom_rol ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$rol[$i]['id'] = $fila['id_rol'];
				$rol[$i]['nombre'] = $fila['nom_rol'];	
				$i++;
			}
		}else{
			$rol = "";
		}
		mysql_free_result($resultado);
		return $rol;
	}
	
	public function getByID($idRol){
		$consulta = " 	SELECT r.id_rol, r.nom_rol
						FROM rol r
						WHERE id_rol = $idRol; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$rol['id'] = mysql_result($resultado, 0, 'id_rol');
			$rol['nombre'] = mysql_result($resultado, 0, 'nom_rol');	
		}else{
			$rol = "";
		}
		mysql_free_result($resultado);
		return $rol;
	}	
}
?>