<?php
class pais{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idPais'=>$data['idPais'],
                'nomPais'=>$data['nomPais']
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
		$consulta = " 	SELECT p.id_pais, p.nom_pais
						FROM pais p
						ORDER BY p.nom_pais ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$pais[$i]['id'] = $fila['id_pais'];
				$pais[$i]['nombre'] = $fila['nom_pais'];	
				$i++;
			}
		}else{
			$pais = "";
		}
		mysql_free_result($resultado);
		return $pais;
	}	
}
?>