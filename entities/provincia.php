<?php
class provincia{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idProvincia'=>$data['idProvincia'],
                'idDepartamento'=>$data['idDepartamento'],
                'nomProvincia'=>$data['nomProvincia']
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
		$condicion = " WHERE p.id_departamento = $id ";
				
		$consulta = " 	SELECT p.id_provincia, p.nom_provincia
						FROM provincia p
						$condicion
						ORDER BY p.nom_provincia ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$provincia[$i]['id'] = $fila['id_provincia'];
				$provincia[$i]['nombre'] = $fila['nom_provincia'];	
				$i++;
			}
		}else{
			$provincia = "";
		}
		mysql_free_result($resultado);
		return $provincia;
	}	
}
?>