<?php
class leidoAlerta{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idLeidoAlerta'=>$data['idLeidoAlerta'],
                'idAlerta'=>$data['idAlerta'],
                'idUsuario'=>$data['idUsuario'],
                'fechCrea'=>$data['fechCrea'],
        );
        $this->setArray = $resultado;
    }
    function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO leido_alerta VALUES(NULL, {$data['idAlerta']}, {$data['idUsuario']}, NOW()); ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }	
	function update() {
    }
	function delete($id) {
    }
	
	public function getCombo(){
	}	
}
?>