<?php
class departamento{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idDepartamento'=>$data['idDepartamento'],
                'idPais'=>$data['idPais'],
                'nomDepartamento'=>$data['nomDepartamento']
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
		$condicion = " WHERE d.id_pais = $id ";
		
		$consulta = " 	SELECT d.id_departamento, d.nom_departamento
						FROM departamento d
						$condicion
						ORDER BY d.nom_departamento ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$departamento[$i]['id'] = $fila['id_departamento'];
				$departamento[$i]['nombre'] = $fila['nom_departamento'];	
				$i++;
			}
		}else{
			$departamento = "";
		}
		mysql_free_result($resultado);
		return $departamento;
	}	
}
?>