<?php
class direccion{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idDireccion'=>$data['idDireccion'],
                'idCliente'=>$data['idCliente'],
                'idDistrito'=>$data['idDistrito'],
                'idCodigoPostal'=>$data['idCodigoPostal'],
                'idPais'=>$data['idPais'],
                'idDepartamento'=>$data['idDepartamento'],
                'idProvincia'=>$data['idProvincia'],
                'conteDireccion'=>$data['conteDireccion'],
                'urbDireccion'=>$data['urbDireccion'],
                'refDireccion'=>$data['refDireccion'],
                'princDireccion'=>$data['princDireccion'],
                'fechCrea'=>$data['fechCrea'],
                'fechEdita'=>$data['fechEdita'],
                'usuCrea'=>$data['usuCrea'],
                'usuEdita'=>$data['usuEdita']
        );
        $this->setArray = $resultado;
    }
	
    function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO direccion VALUES(
						NULL, {$data['idCliente']}, {$data['idDistrito']}, {$data['idCodigoPostal']},
						{$data['idPais']}, {$data['idDepartamento']}, {$data['idProvincia']},
						'{$data['conteDireccion']}', '{$data['urbDireccion']}', '{$data['refDireccion']}',
						'{$data['princDireccion']}', NOW(), NULL, {$data['usuCrea']}, NULL
						); ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }	
	
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE direccion SET
						id_cliente={$data['idCliente']}, 
						id_distrito={$data['idDistrito']}, 
						id_codigo_postal={$data['idCodigoPostal']},
						id_pais={$data['idPais']}, 
						id_departamento={$data['idDepartamento']}, 
						id_provincia={$data['idProvincia']}, 
						conte_direccion='{$data['conteDireccion']}', 
						urb_direccion='{$data['urbDireccion']}', 
						ref_direccion='{$data['refDireccion']}',
						princ_direccion='{$data['princDireccion']}',
						fech_edita=NOW(), 
						usu_edita={$data['usuEdita']}
						WHERE id_direccion = {$data['idDireccion']}; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
		
	function delete($id) {
		$consulta = "	DELETE FROM direccion WHERE id_direccion = $id; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	public function get($id){
		$consulta = "	SELECT id_direccion, id_cliente, id_distrito, id_codigo_postal,
						id_pais, id_departamento, id_provincia, conte_direccion, 
						urb_direccion, ref_direccion, princ_direccion											
						FROM direccion
						WHERE id_direccion = $id;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$direccion= array(
				"idDireccion" => mysql_result($resultado, 0, "id_direccion"),
				"idCliente" => mysql_result($resultado, 0, "id_cliente"),
				"idDistrito" => mysql_result($resultado, 0, "id_distrito"),
				"idCodigoPostal" => mysql_result($resultado, 0, "id_codigo_postal"),
				"idPais" => mysql_result($resultado, 0, "id_pais"),
				"idDepartamento" => mysql_result($resultado, 0, "id_departamento"),
				"idProvincia" => mysql_result($resultado, 0, "id_provincia"),
				"conteDireccion" => mysql_result($resultado, 0, "conte_direccion"),
				"urbDireccion" => mysql_result($resultado, 0, "urb_direccion"),
				"refDireccion" => mysql_result($resultado, 0, "ref_direccion"),
				"princDireccion" => mysql_result($resultado, 0, "princ_direccion")
			);
		}else{
			$direccion = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $direccion;
	}
	
	public function show($id){
		$consulta = " 	SELECT d.id_direccion AS 'ID', d.conte_direccion AS 'Direcci&oacute;n', 
						d.urb_direccion AS 'Urbanizaci&oacute;n', d.ref_direccion AS 'Referencia',
						IF(d.princ_direccion=1, 'S&iacute;', 'No') AS  'Principal'
						FROM direccion d
						WHERE id_cliente = $id; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$direccion = $general->consulta($resultado);
		}else{
			$direccion = "";
		}
		mysql_free_result($resultado);
		return $direccion;
	}	
	
	public function getMain($idCliente){
		$consulta = "	SELECT id_direccion, id_cliente, id_distrito, id_codigo_postal,
						id_pais, id_departamento, id_provincia, conte_direccion, 
						urb_direccion, ref_direccion, princ_direccion												
						FROM direccion
						WHERE id_cliente = $idCliente
						ORDER BY princ_direccion DESC;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$direccion= array(
				"idDireccion" => mysql_result($resultado, 0, "id_direccion"),
				"idCliente" => mysql_result($resultado, 0, "id_cliente"),
				"idDistrito" => mysql_result($resultado, 0, "id_distrito"),
				"idCodigoPostal" => mysql_result($resultado, 0, "id_codigo_postal"),
				"idPais" => mysql_result($resultado, 0, "id_pais"),
				"idDepartamento" => mysql_result($resultado, 0, "id_departamento"),
				"idProvincia" => mysql_result($resultado, 0, "id_provincia"),
				"conteDireccion" => mysql_result($resultado, 0, "conte_direccion"),
				"urbDireccion" => mysql_result($resultado, 0, "urb_direccion"),
				"refDireccion" => mysql_result($resultado, 0, "ref_direccion"),
				"princDireccion" => mysql_result($resultado, 0, "princ_direccion")
			);
		}else{
			$direccion = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $direccion;
	}
}
?>