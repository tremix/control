<?php
class codigoPostal{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idCodigoPostal'=>$data['idCodigoPostal'],
                'nomCodigoPostal'=>$data['nomCodigoPostal'],
                'codCodigoPostal'=>$data['codCodigoPostal']
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
		
		$consulta = " 	SELECT cp.id_codigo_postal, cp.nom_codigo_postal, cp.cod_codigo_postal
						FROM codigo_postal cp
						ORDER BY cp.nom_codigo_postal ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$codigoPostal[$i]['id'] = $fila['id_codigo_postal'];
				$codigoPostal[$i]['nombre'] = $fila['nom_codigo_postal'] . ' - ' . $fila['cod_codigo_postal'];	
				$i++;
			}
		}else{
			$codigoPostal = "";
		}
		mysql_free_result($resultado);
		return $codigoPostal;
	}	
}
?>