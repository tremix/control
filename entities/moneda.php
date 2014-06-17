<?php
class moneda{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idMoneda'=>$data['idMoneda'],
                'nomMoneda'=>$data['nomMoneda'],
                'simbMoneda'=>$data['simbMoneda']
        );
        $this->setArray = $resultado;
    }
    function insert() {
    }	
	function update() {
    }
	function delete($id) {
    }
	
	public function getCombo(){
		$consulta = " 	SELECT m.id_moneda, m.nom_moneda,
						m.simb_moneda
						FROM moneda m
						ORDER BY m.nom_moneda ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$moneda[$i]['id'] = $fila['id_moneda'];
				$moneda[$i]['nombre'] = $fila['nom_moneda'] . " ({$fila['simb_moneda']})";
				$i++;
			}
		}else{
			$moneda = "";
		}
		mysql_free_result($resultado);
		return $moneda;
	}
	
	public function getNameByID($idMoneda){
		$consulta = "	SELECT CONCAT(nom_moneda, '(', simb_moneda,')') AS 'nom_moneda'
                                FROM moneda
                                WHERE id_moneda = $idMoneda;
                        ";
		$resultado = mysql_query($consulta) or die(mysql_error());
		if(mysql_num_rows($resultado)>0){
			$moneda = mysql_result($resultado, 0, "nom_moneda");
		}else{
			$moneda = 0;
		}
		mysql_free_result($resultado);
		return $moneda;
	}	
}
?>