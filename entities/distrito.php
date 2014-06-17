<?php
class distrito{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idDistrito'=>$data['idDistrito'],
                'idProvincia'=>$data['idProvincia'],
                'nomDistrito'=>$data['nomDistrito']
        );
        $this->setArray = $resultado;
    }
    function insert() {
    }	
	function update() {
    }
	function delete($id) {
    }
	
	public function getCombo($id=""){
		$condicion = " WHERE d.id_provincia = $id ";
		
		$consulta = " 	SELECT d.id_distrito, d.nom_distrito
						FROM distrito d
						$condicion
						ORDER BY d.nom_distrito ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$distrito[$i]['id'] = $fila['id_distrito'];
				$distrito[$i]['nombre'] = $fila['nom_distrito'];	
				$i++;
			}
		}else{
			$distrito = "";
		}
		mysql_free_result($resultado);
		return $distrito;
	}	
}
?>