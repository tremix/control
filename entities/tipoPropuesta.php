<?php
class tipoPropuesta{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idTipoPropuesta'=>$data['idTipoPropuesta'],
                'nomTipoPropuesta'=>$data['nomTipoPropuesta'],
                'codTipoPropuesta'=>$data['codTipoPropuesta'],
                'descrTipoPropuesta'=>$data['descrTipoPropuesta']
        );
        $this->setArray = $resultado;
    }
    function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO tipo_propuesta VALUES(
						NULL, '{$data['nomTipoPropuesta']}',
						'{$data['codTipoPropuesta']}', '{$data['descrTipoPropuesta']}'
						);		
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }	
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE tipo_propuesta SET
						nom_tipo_propuesta='{$data['nomTipoPropuesta']}',
						cod_tipo_propuesta='{$data['codTipoPropuesta']}', 
						descr_tipo_propuesta='{$data['descrTipoPropuesta']}'
						WHERE id_tipo_propuesta = '{$data['idTipoPropuesta']}';
						;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	function delete($id) {
    }
	
	public function show(){		
		$consulta = " 	SELECT tp.id_tipo_propuesta AS 'ID', tp.nom_tipo_propuesta AS 'Nombre',
						tp.cod_tipo_propuesta AS 'C&oacute;digo', tp.descr_tipo_propuesta AS 'Descripci&oacute;n'
						FROM tipo_propuesta tp
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$tipoPropuesta = $general->consulta($resultado);
		}else{
			$tipoPropuesta = "";
		}
		mysql_free_result($resultado);
		return $tipoPropuesta;
	}
	
	public function get($id){
		$consulta = " 	SELECT tp.id_tipo_propuesta, tp.nom_tipo_propuesta,
						tp.cod_tipo_propuesta, tp.descr_tipo_propuesta
						FROM tipo_propuesta tp
						WHERE tp.id_tipo_propuesta = $id; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$tipoPropuesta['idTipoPropuesta'] = mysql_result($resultado, 0, 'id_tipo_propuesta');
			$tipoPropuesta['nomTipoPropuesta'] = mysql_result($resultado, 0, 'nom_tipo_propuesta');
			$tipoPropuesta['codTipoPropuesta'] = mysql_result($resultado, 0, 'cod_tipo_propuesta');
			$tipoPropuesta['descrTipoPropuesta'] = mysql_result($resultado, 0, 'descr_tipo_propuesta');
		}else{
			$tipoPropuesta = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $tipoPropuesta;
	}
	
	public function getCombo(){
		$consulta = " 	SELECT tp.id_tipo_propuesta, tp.nom_tipo_propuesta,
						tp.cod_tipo_propuesta, tp.descr_tipo_propuesta
						FROM tipo_propuesta tp
						ORDER BY tp.nom_tipo_propuesta ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$tipoPropuesta[$i]['id'] = $fila['id_tipo_propuesta'];
				$tipoPropuesta[$i]['nombre'] = "({$fila['cod_tipo_propuesta']}) " . $fila['nom_tipo_propuesta'];
				$tipoPropuesta[$i]['descripcion'] = $fila['descr_tipo_propuesta'];
				$i++;
			}
		}else{
			$tipoPropuesta = "";
		}
		mysql_free_result($resultado);
		return $tipoPropuesta;
	}
	
	public function getNameByID($idTipoPropuesta){
		$consulta = "	SELECT CONCAT(nom_tipo_propuesta, ' (',cod_tipo_propuesta, ')') AS 'nom_tipo_propuesta'
                                FROM tipo_propuesta
                                WHERE id_tipo_propuesta = $idTipoPropuesta;
                        ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$tipoPropuesta = mysql_result($resultado, 0, "nom_tipo_propuesta");
		}else{
			$tipoPropuesta = 0;
		}
		mysql_free_result($resultado);
		return $tipoPropuesta;
	}	
}
?>