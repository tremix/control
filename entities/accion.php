<?php
class accion{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idAccion'=>$data['idAccion'],
                'nomAccion'=>$data['nomAccion']
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
		$consulta = " 	SELECT a.id_accion, a.nom_accion
						FROM accion a
						ORDER BY a.nom_accion ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$accion[$i]['id'] = $fila['id_accion'];
				$accion[$i]['nombre'] = $fila['nom_accion'];	
				$i++;
			}
		}else{
			$accion = "";
		}
		mysql_free_result($resultado);
		return $accion;
	}	
}
?>