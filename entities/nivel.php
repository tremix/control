<?php
class nivel{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idNivel'=>$data['idNivel'],
                'nomNivel'=>$data['nomNivel'],
                'depenNivel'=>$data['depenNivel']
        );
        $this->setArray = $resultado;
    }
	function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO nivel VALUES(
						NULL, '{$data['nomNivel']}', {$data['depenNivel']}
						);		
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }	
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE nivel SET
						nom_nivel = '{$data['nomNivel']}'
						depen_nivel = {$data['depenNivel']}
						WHERE id_nivel = {$data['idNivel']}
						;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	public function show(){		
		$consulta = " 	SELECT n.id_nivel AS 'ID', n.nom_nivel AS 'Nombre',
						IFNULL(n2.nom_nivel, 'Ninguno') AS 'Depende de'
						FROM nivel n
						LEFT OUTER JOIN nivel n2 ON  n.depen_nivel = n2.id_nivel
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$nivel = $general->consulta($resultado);
		}else{
			$nivel = "";
		}
		mysql_free_result($resultado);
		return $nivel;
	}
	
	public function get($id){
		$consulta = " 	SELECT n.id_nivel, n.nom_nivel, n.depen_nivel
						FROM nivel n
						WHERE n.id_nivel = $id; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$nivel['idNivel'] = mysql_result($resultado, 0, 'id_nivel');
			$nivel['nomNivel'] = mysql_result($resultado, 0, 'nom_nivel');
			$nivel['depenNivel'] = mysql_result($resultado, 0, 'depen_nivel');
		}else{
			$nivel = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $nivel;
	}
	
	public function getCombo(){
		$consulta = " 	SELECT n.id_nivel, n.nom_nivel
						FROM nivel n
						ORDER BY n.nom_nivel ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$nivel[$i]['id'] = $fila['id_nivel'];
				$nivel[$i]['nombre'] = $fila['nom_nivel'];	
				$i++;
			}
		}else{
			$nivel = "";
		}
		mysql_free_result($resultado);
		return $nivel;
	}
	
	public function getNameByID($idNivel){
		$consulta = " 	SELECT n.nom_nivel
						FROM nivel n
						WHERE id_nivel = $idNivel; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$nivel = mysql_result($resultado, 0, 'nom_nivel');	
		}else{
			$nivel = "No especificado";
		}
		mysql_free_result($resultado);
		return $nivel;
	}	
}
?>