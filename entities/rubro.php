<?php
class rubro{

	var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
                'idRubro'=>$data['idRubro'],
                'nomRubro'=>$data['nomRubro']
        );
        $this->setArray = $resultado;
    }
    function insert() {
		$data = $this->setArray;
		$consulta = "	INSERT INTO rubro VALUES(
						NULL, '{$data['nomRubro']}'
						);		
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		$id = mysql_insert_id();
		return $id;
    }	
	function update() {
		$data = $this->setArray;
		$consulta = "	UPDATE rubro SET
						nom_rubro = '{$data['nomRubro']}'
						WHERE id_rubro = {$data['idRubro']}
						;
					";
		$resultado = mysql_query($consulta) or die(mysql_error());
		return $resultado;
    }
	function delete($id) {
    }
	
	public function show(){		
		$consulta = " 	SELECT r.id_rubro AS 'ID', r.nom_rubro AS 'Nombre'			
						FROM rubro r
						; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			require_once(resources.'general.php');
			$general = new general();
			$rubro = $general->consulta($resultado);
		}else{
			$rubro = "";
		}
		mysql_free_result($resultado);
		return $rubro;
	}
	
	public function get($id){
		$consulta = " 	SELECT r.id_rubro, r.nom_rubro
						FROM rubro r
						WHERE r.id_rubro = $id; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$rubro['idRubro'] = mysql_result($resultado, 0, 'id_rubro');
			$rubro['nomRubro'] = mysql_result($resultado, 0, 'nom_rubro');
		}else{
			$rubro = "";
		}
		mysql_free_result($resultado);
		$this->setArray = $rubro;
	}
	
	public function getCombo(){
		$consulta = " 	SELECT r.id_rubro, r.nom_rubro
						FROM rubro r
						ORDER BY r.nom_rubro ASC; ";
		$resultado = mysql_query($consulta) or die (mysql_error());	
		if(mysql_num_rows($resultado)>0){
			$i=0;
			while($fila = mysql_fetch_array($resultado)){
				$rubro[$i]['id'] = $fila['id_rubro'];
				$rubro[$i]['nombre'] = $fila['nom_rubro'];	
				$i++;
			}
		}else{
			$rubro = "";
		}
		mysql_free_result($resultado);
		return $rubro;
	}	
}
?>