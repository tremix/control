<?php
class contacto{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idContacto'=>$data['idContacto'],
                'idCliente'=>$data['idCliente'],
                'nomContacto'=>$data['nomContacto'],
                'apeContacto'=>$data['apeContacto'],
                'cargoContacto'=>$data['cargoContacto'],
                'emailContacto'=>$data['emailContacto'],
                'tfijoContacto'=>$data['tfijoContacto'],
                'tdirecContacto'=>$data['tdirecContacto'],
                'tcel1Contacto'=>$data['tcel1Contacto'],
                'tcel2Contacto'=>$data['tcel2Contacto'],
                'obsContacto'=>$data['obsContacto'],
                'princContacto'=>$data['princContacto'],
                'fechCrea'=>$data['fechCrea'],
                'fechEdita'=>$data['fechEdita'],
                'usuCrea'=>$data['usuCrea'],
                'usuEdita'=>$data['usuEdita']
        );
        $this->setArray = $resultado;
    }
	
    function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO contacto VALUES(
						NULL, {$data['idCliente']}, '{$data['nomContacto']}', '{$data['apeContacto']}',
						'{$data['cargoContacto']}', '{$data['emailContacto']}', '{$data['tfijoContacto']}',
						'{$data['tdirecContacto']}', '{$data['tcel1Contacto']}', '{$data['tcel2Contacto']}',
						'{$data['obsContacto']}', '{$data['princContacto']}', NOW(), 
						NULL, {$data['usuCrea']}, NULL
						); ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }	
	
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE contacto SET
						id_cliente={$data['idCliente']}, 
						nom_contacto='{$data['nomContacto']}', 
						ape_contacto='{$data['apeContacto']}',
						cargo_contacto='{$data['cargoContacto']}', 
						email_contacto='{$data['emailContacto']}', 
						tfijo_contacto='{$data['tfijoContacto']}',
						tdirec_contacto='{$data['tdirecContacto']}', 
						tcel1_contacto='{$data['tcel1Contacto']}', 
						tcel2_contacto='{$data['tcel2Contacto']}',
						obs_contacto='{$data['obsContacto']}', 
						princ_contacto='{$data['princContacto']}', 
						fech_edita=NOW(), 
						usu_edita={$data['usuEdita']}
						WHERE id_contacto = {$data['idContacto']}; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	function updatePrinc($idCliente) {
		$data = $this->setArray;
		$consulta = "	UPDATE contacto SET
						princ_contacto=0
						WHERE id_cliente = {$idCliente}; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
		
	function delete($id) {
		$consulta = "	DELETE FROM contacto WHERE id_contacto = $id; ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	
	public function get($id){
		$consulta = "	SELECT id_contacto, id_cliente, nom_contacto, ape_contacto,
						cargo_contacto, email_contacto, tfijo_contacto, tdirec_contacto,
						tcel1_contacto, tcel2_contacto, obs_contacto, princ_contacto
												
						FROM contacto
						WHERE id_contacto = $id;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$contacto= array(
				"idContacto" => mysql_result($resultado, 0, "id_contacto"),
				"idCliente" => mysql_result($resultado, 0, "id_cliente"),
				"nomContacto" => mysql_result($resultado, 0, "nom_contacto"),
				"apeContacto" => mysql_result($resultado, 0, "ape_contacto"),
				"cargoContacto" => mysql_result($resultado, 0, "cargo_contacto"),
				"emailContacto" => mysql_result($resultado, 0, "email_contacto"),
				"tfijoContacto" => mysql_result($resultado, 0, "tfijo_contacto"),
				"tdirecContacto" => mysql_result($resultado, 0, "tdirec_contacto"),
				"tcel1Contacto" => mysql_result($resultado, 0, "tcel1_contacto"),
				"tcel2Contacto" => mysql_result($resultado, 0, "tcel2_contacto"),
				"obsContacto" => mysql_result($resultado, 0, "obs_contacto"),
				"princContacto" => mysql_result($resultado, 0, "princ_contacto")
			);
		}else{
			$contacto = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $contacto;
	}
	
	public function show($id){
		$consulta = " 	SELECT c.id_contacto AS 'ID', c.nom_contacto AS 'Nombre', c.ape_contacto AS 'Apellidos',
						c.tfijo_contacto AS 'Tel&eacute;fono', c.tcel1_contacto AS 'Celular',
						c.email_contacto AS 'E-mail', IF(c.princ_contacto=1, 'S&iacute;', 'No') AS 'Principal'
						FROM contacto c
						WHERE id_cliente = $id
						ORDER BY c.princ_contacto DESC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$contacto = $general->consulta($resultado);
		}else{
			$contacto = "";
		}
		mysql_free_result($resultado);
		return $contacto;
	}
	
	
	
	public function getMain($idCliente){
		$consulta = "	SELECT id_contacto, id_cliente, nom_contacto, ape_contacto,
						cargo_contacto, email_contacto, tfijo_contacto, tdirec_contacto,
						tcel1_contacto, tcel2_contacto, obs_contacto, princ_contacto												
						FROM contacto
						WHERE id_cliente = $idCliente
						ORDER BY princ_contacto DESC;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$contacto= array(
				"idContacto" => mysql_result($resultado, 0, "id_contacto"),
				"idCliente" => mysql_result($resultado, 0, "id_cliente"),
				"nomContacto" => mysql_result($resultado, 0, "nom_contacto"),
				"apeContacto" => mysql_result($resultado, 0, "ape_contacto"),
				"cargoContacto" => mysql_result($resultado, 0, "cargo_contacto"),
				"emailContacto" => mysql_result($resultado, 0, "email_contacto"),
				"tfijoContacto" => mysql_result($resultado, 0, "tfijo_contacto"),
				"tdirecContacto" => mysql_result($resultado, 0, "tdirec_contacto"),
				"tcel1Contacto" => mysql_result($resultado, 0, "tcel1_contacto"),
				"tcel2Contacto" => mysql_result($resultado, 0, "tcel2_contacto"),
				"obsContacto" => mysql_result($resultado, 0, "obs_contacto"),
				"princContacto" => mysql_result($resultado, 0, "princ_contacto")
			);
		}else{
			$contacto = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $contacto;
	}
}
?>