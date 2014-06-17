<?php
class tipoArea{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idTipoArea'=>$data['idTipoArea'],
                'idTipoArea'=>$data['idTipoArea'],
                'nomTipoArea'=>$data['nomTipoArea'],
                'codTipoArea'=>$data['codTipoArea'],
                'descrTipoArea'=>$data['descrTipoArea']
        );
        $this->setArray = $resultado;
    }
    function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO tipo_area VALUES(
						NULL, {$data['idTipoPropuesta']}, '{$data['nomTipoArea']}',
						'{$data['codTipoArea']}', '{$data['descrTipoArea']}'
						);		
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }	
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE tipo_area SET
						id_tipo_propuesta='{$data['idTipoPropuesta']}',
						nom_tipo_area='{$data['nomTipoArea']}',
						cod_tipo_area='{$data['codTipoArea']}', 
						descr_tipo_area='{$data['descrTipoArea']}'
						WHERE id_tipo_area = '{$data['idTipoArea']}';
						;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	function delete($id) {
    }
	
	public function show(){		
		$consulta = " 	SELECT ta.id_tipo_area AS 'ID', ta.nom_tipo_area AS 'Nombre',
						ta.cod_tipo_area AS 'C&oacute;digo', ta.descr_tipo_area AS 'Descripci&oacute;n',
						tp.cod_tipo_propuesta AS 'Tipo'
						FROM tipo_area ta
						INNER JOIN tipo_propuesta tp ON ta.id_tipo_propuesta = tp.id_tipo_propuesta
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$tipoArea = $general->consulta($resultado);
		}else{
			$tipoArea = "";
		}
		mysql_free_result($resultado);
		return $tipoArea;
	}
	
	public function get($id){
		$consulta = " 	SELECT ta.id_tipo_area, ta.id_tipo_propuesta,
						ta.nom_tipo_area, ta.cod_tipo_area, 
						ta.descr_tipo_area
						FROM tipo_area ta
						WHERE ta.id_tipo_area = $id; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$tipoArea['idTipoArea'] = mysql_result($resultado, 0, 'id_tipo_area');
			$tipoArea['idTipoPropuesta'] = mysql_result($resultado, 0, 'id_tipo_propuesta');
			$tipoArea['nomTipoArea'] = mysql_result($resultado, 0, 'nom_tipo_area');
			$tipoArea['codTipoArea'] = mysql_result($resultado, 0, 'cod_tipo_area');
			$tipoArea['descrTipoArea'] = mysql_result($resultado, 0, 'descr_tipo_area');
		}else{
			$tipoArea = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $tipoArea;
	}
	public function getCombo($idTipoPropuesta=''){
		$where = "";
		if($idTipoPropuesta<>''){
			$where = "WHERE ta.id_tipo_propuesta = $idTipoPropuesta";
		}
		$consulta = " 	SELECT ta.id_tipo_area, ta.nom_tipo_area,
						ta.cod_tipo_area, ta.descr_tipo_area
						FROM tipo_area ta
						$where
						ORDER BY ta.nom_tipo_area ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$tipoArea[$i]['id'] = $fila['id_tipo_area'];
				$tipoArea[$i]['nombre'] = "({$fila['cod_tipo_area']}) " . $fila['nom_tipo_area'];
				$tipoArea[$i]['descripcion'] = $fila['descr_tipo_area'];
				$i++;
			}
		}else{
			$tipoArea = "";
		}
		mysql_free_result($resultado);
		return $tipoArea;
	}	
	
	public function getTipoPropuestaByID($idTipoArea){
		$consulta = "	SELECT id_tipo_propuesta FROM tipo_area WHERE id_tipo_area = $idTipoArea; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$tipoArea = mysql_result($resultado, 0, 'id_tipo_propuesta');
		}else{
			$tipoArea = "";
		}
		mysql_free_result($resultado);
		return $tipoArea;
	}
	
	public function getNameByID($idTipoArea){
		$consulta = "	SELECT CONCAT(nom_tipo_area, ' (',cod_tipo_area, ')') AS 'nom_tipo_area'
                                FROM tipo_area
                                WHERE id_tipo_area = $idTipoArea;
                        ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$tipoArea = mysql_result($resultado, 0, "nom_tipo_area");
		}else{
			$tipoArea = 0;
		}
		mysql_free_result($resultado);
		return $tipoArea;
	}
}
?>