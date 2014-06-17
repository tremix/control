<?php
class tipoServicio{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idTipoServicio'=>$data['idTipoServicio'],
                'idTipoArea'=>$data['idTipoArea'],
                'nomTipoServicio'=>$data['nomTipoServicio'],
                'codTipoServicio'=>$data['codTipoServicio'],
                'descrTipoServicio'=>$data['descrTipoServicio']
        );
        $this->setArray = $resultado;
    }
     function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO tipo_servicio VALUES(
						NULL, {$data['idTipoArea']}, '{$data['nomTipoServicio']}',
						'{$data['codTipoServicio']}', '{$data['descrTipoServicio']}'
						);		
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }	
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE tipo_servicio SET
						id_tipo_area='{$data['idTipoArea']}',
						nom_tipo_servicio='{$data['nomTipoServicio']}',
						cod_tipo_servicio='{$data['codTipoServicio']}', 
						descr_tipo_servicio='{$data['descrTipoServicio']}'
						WHERE id_tipo_servicio = '{$data['idTipoServicio']}';
						;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	function delete($id) {
    }
	
	public function show(){		
		$consulta = " 	SELECT ts.id_tipo_servicio AS 'ID', ts.nom_tipo_servicio AS 'Nombre',
						ts.cod_tipo_servicio AS 'C&oacute;digo', ts.descr_tipo_servicio AS 'Descripci&oacute;n',
						ta.cod_tipo_area AS '&Aacute;rea'
						FROM tipo_servicio ts
						INNER JOIN tipo_area ta ON ts.id_tipo_area = ta.id_tipo_area
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$tipoServicio = $general->consulta($resultado);
		}else{
			$tipoServicio = "";
		}
		mysql_free_result($resultado);
		return $tipoServicio;
	}
	
	public function get($id){
		$consulta = " 	SELECT ts.id_tipo_servicio, ts.id_tipo_area,
						ts.nom_tipo_servicio, ts.cod_tipo_servicio, 
						ts.descr_tipo_servicio
						FROM tipo_servicio ts
						WHERE ts.id_tipo_servicio = $id; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$tipoServicio['idTipoServicio'] = mysql_result($resultado, 0, 'id_tipo_servicio');
			$tipoServicio['idTipoArea'] = mysql_result($resultado, 0, 'id_tipo_area');
			$tipoServicio['nomTipoServicio'] = mysql_result($resultado, 0, 'nom_tipo_servicio');
			$tipoServicio['codTipoServicio'] = mysql_result($resultado, 0, 'cod_tipo_servicio');
			$tipoServicio['descrTipoServicio'] = mysql_result($resultado, 0, 'descr_tipo_servicio');
		}else{
			$tipoServicio = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $tipoServicio;
	}
	
	public function getCombo($idTipoArea=''){
		$where = "";
		if($idTipoArea<>'' and $idTipoArea<>'NULL'){
			$where = "WHERE ts.id_tipo_area = $idTipoArea";
		}
		$consulta = " 	SELECT ts.id_tipo_servicio, ts.nom_tipo_servicio,
						ts.cod_tipo_servicio, ts.descr_tipo_servicio
						FROM tipo_servicio ts
						$where
						ORDER BY ts.nom_tipo_servicio ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$tipoServicio[$i]['id'] = $fila['id_tipo_servicio'];
				$tipoServicio[$i]['nombre'] = "({$fila['cod_tipo_servicio']}) " . $fila['nom_tipo_servicio'];
				$tipoServicio[$i]['descripcion'] = $fila['descr_tipo_servicio'];
				$i++;
			}
		}else{
			$tipoServicio = "";
		}
		mysql_free_result($resultado);
		return $tipoServicio;
	}	
		
	public function getTipoAreaByID($idTipoServicio){
		$consulta = "	SELECT id_tipo_area FROM tipo_servicio WHERE id_tipo_servicio = $idTipoServicio; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$tipoServicio = mysql_result($resultado, 0, 'id_tipo_area');
		}else{
			$tipoServicio = "";
		}
		mysql_free_result($resultado);
		return $tipoServicio;
	}
	
	public function getNameByID($idTipoServicio){
		$consulta = "	SELECT CONCAT(nom_tipo_servicio, ' (',cod_tipo_servicio, ')') AS 'nom_tipo_servicio'
                                FROM tipo_servicio
                                WHERE id_tipo_servicio = $idTipoServicio;
                        ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$tipoServicio = mysql_result($resultado, 0, "nom_tipo_servicio");
		}else{
			$tipoServicio = 0;
		}
		mysql_free_result($resultado);
		return $tipoServicio;
	}
}
?>