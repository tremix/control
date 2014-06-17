<?php
class formulario{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idFormulario'=>$data['idFormulario'],
                'nomFormulario'=>$data['nomFormulario'],
                'linkFormulario'=>$data['linkFormulario']
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
		$consulta = " 	SELECT f.id_formulario, f.nom_formulario
						FROM formulario f
						ORDER BY f.nom_formulario ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$formulario[$i]['id'] = $fila['id_formulario'];
				$formulario[$i]['nombre'] = $fila['nom_formulario'];	
				$i++;
			}
		}else{
			$formulario = "";
		}
		mysql_free_result($resultado);
		return $formulario;
	}
	
	public function getByID($idFormulario){
		$consulta = " 	SELECT f.id_formulario, f.nom_formulario, f.link_formulario
						FROM formulario f
						WHERE f.id_formulario = $idFormulario; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$formulario['id'] = mysql_result($resultado, 0, 'id_formulario');			
			$formulario['nombre'] = mysql_result($resultado, 0, 'nom_formulario');			
			$formulario['link'] = mysql_result($resultado, 0, 'link_formulario');
		}else{
			$formulario = "";
		}
		mysql_free_result($resultado);
		return $formulario;
	}	
}
?>