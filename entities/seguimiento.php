<?php
class seguimiento{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idSeguimiento'=>$data['idSeguimiento'],
                'idPropuesta'=>$data['idPropuesta'],
                'idAccion'=>$data['idAccion'],
                'sigacSeguimiento'=>$data['sigacSeguimiento'],
                'comenSeguimiento'=>$data['comenSeguimiento'],
                'alerSeguimiento'=>$data['alerSeguimiento'],
                'fechCrea'=>$data['fechCrea'],
                'usuCrea'=>$data['usuCrea']
        );
        $this->setArray = $resultado;
    }
	
    function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO seguimiento VALUES(
						NULL, {$data['idPropuesta']}, {$data['idAccion']}, 
						'{$data['sigacSeguimiento']}', '{$data['comenSeguimiento']}', 
						'{$data['alerSeguimiento']}', NOW(), {$data['usuCrea']}
						); ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }	
	
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE seguimiento SET
						id_propuesta={$data['idPropuesta']}, 
						id_accion={$data['idAccion']}, 
						sigac_seguimiento='{$data['sigacSeguimiento']}',
						comen_seguimiento='{$data['comenSeguimiento']}',
						aler_seguimiento='{$data['alerSeguimiento']}'
						WHERE id_seguimiento = {$data['idSeguimiento']}; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
		
	function delete($id) {
		$consulta = "	DELETE FROM seguimiento WHERE id_seguimiento = $id; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	public function get($id){
		$consulta = "	SELECT id_seguimiento, id_propuesta, id_accion, 
						sigac_seguimiento, comen_seguimiento, aler_seguimiento											
						FROM seguimiento
						WHERE id_seguimiento = $id;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$seguimiento= array(
				"idSeguimiento" => mysql_result($resultado, 0, "id_seguimiento"),
				"idPropuesta" => mysql_result($resultado, 0, "id_propuesta"),
				"idAccion" => mysql_result($resultado, 0, "id_accion"),
				"sigacSeguimiento" => mysql_result($resultado, 0, "sigac_seguimiento"),
				"comenSeguimiento" => mysql_result($resultado, 0, "comen_seguimiento"),
				"alerSeguimiento" => mysql_result($resultado, 0, "aler_seguimiento")
			);
		}else{
			$seguimiento = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $seguimiento;
	}
	
	public function show($id){
		$consulta = " 	SELECT s.id_seguimiento AS 'ID', s.comen_seguimiento AS 'Comentario',
                                IF(s.sigac_seguimiento='0000-00-00 00:00:00', '', s.sigac_seguimiento) AS 'Siguiente Acci&oacute;n', 
                                IF(s.aler_seguimiento=1, 'S&iacute;', 'No') AS 'Alerta', 
                                s.fech_crea AS 'Fecha'
                                FROM seguimiento s
                                WHERE id_propuesta = $id
                                ORDER BY s.fech_crea DESC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$seguimiento = $general->consulta($resultado);
		}else{
			$seguimiento = "";
		}
		mysql_free_result($resultado);
		return $seguimiento;
	}
	
	public function getLast($idPropuesta){
		$consulta = "	SELECT IFNULL(a.nom_accion, 'No especificado') AS 'accion',
						s.sigac_seguimiento AS 'sigac',
						s.comen_seguimiento AS 'comentario'
						FROM seguimiento s
						LEFT OUTER JOIN accion a ON s.id_accion = a.id_accion
						WHERE s.id_propuesta = $idPropuesta
						ORDER BY s.fech_crea DESC
						LIMIT 1;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$seguimiento= array(
				"accion" => mysql_result($resultado, 0, "accion"),
				"sigac" => mysql_result($resultado, 0, "sigac"),
				"comentario" => mysql_result($resultado, 0, "comentario")
			);
		}else{
			$seguimiento = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $seguimiento;
	}
	
	public function showByPropuesta($buscar=""){
		
		$condicion = "";
		if($buscar<>""){
			$condicion .= "	AND (p.cod_propuesta LIKE '$buscar' OR c.nomcom_cliente LIKE '%$buscar%'
							OR c.cod_cliente LIKE '$buscar' OR tp.nom_tipo_propuesta LIKE '%$buscar%'
							OR ta.nom_tipo_area LIKE '%$buscar%' OR ts.nom_tipo_servicio LIKE '%$buscar%'
							OR tp.cod_tipo_propuesta LIKE '$buscar' OR ta.cod_tipo_area LIKE '$buscar'
							OR ts.cod_tipo_servicio LIKE '$buscar' OR si.nom_situacion LIKE '$buscar'
							OR p.var_propuesta LIKE '$buscar' OR p.porc_propuesta LIKE '$buscar'
							)";
		}
		
		$consulta = " 	SELECT s.id_seguimiento AS 'ID',
						c.cod_cliente AS 'Cod. Cliente',  c.nomcom_cliente AS 'Cliente',
						p.cod_propuesta AS 'C&oacute;digo', s.comen_seguimiento AS 'Seguimiento'						
						FROM seguimiento s
						INNER JOIN propuesta p ON s.id_propuesta = p.id_propuesta
						INNER JOIN cliente c ON p.id_cliente = c.id_cliente
						LEFT OUTER JOIN tipo_servicio ts ON p.id_tipo_servicio = ts.id_tipo_servicio
						LEFT OUTER JOIN tipo_area ta ON p.id_tipo_area = ta.id_tipo_area
						LEFT OUTER JOIN tipo_propuesta tp ON p.id_tipo_propuesta = tp.id_tipo_propuesta
						LEFT OUTER JOIN situacion si ON p.id_situacion = si.id_situacion
						WHERE p.est_propuesta <> 'E'
						$condicion
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$seguimiento = $general->consulta($resultado);
		}else{
			$seguimiento = "";
		}
		mysql_free_result($resultado);
		return $seguimiento;
	}
}
?>