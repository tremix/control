<?php

class cargo {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idCargo' => $data['idCargo'],
            'nomCargo' => $data['nomCargo']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO cargo VALUES(
						NULL, '{$data['nomCargo']}'
						);		
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE cargo SET
						nom_cargo = '{$data['nomCargo']}'
						WHERE id_cargo = {$data['idCargo']}
						;
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        
    }

    public function show() {
        $consulta = " 	SELECT c.id_cargo AS 'ID', c.nom_cargo AS 'Nombre'			
						FROM cargo c
						; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $cargo = $general->consulta($resultado);
        } else {
            $cargo = "";
        }
        mysql_free_result($resultado);
        return $cargo;
    }

    public function get($id) {
        $consulta = " 	SELECT c.id_cargo, c.nom_cargo
						FROM cargo c
						WHERE c.id_cargo = $id; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $cargo['idCargo'] = mysql_result($resultado, 0, 'id_cargo');
            $cargo['nomCargo'] = mysql_result($resultado, 0, 'nom_cargo');
        } else {
            $cargo = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $cargo;
    }

    public function getCombo() {
        $consulta = " 	SELECT c.id_cargo, c.nom_cargo
						FROM cargo c
						ORDER BY c.nom_cargo ASC; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $i = 0;
            while ($fila = mysql_fetch_array($resultado)) {
                $cargo[$i]['id'] = $fila['id_cargo'];
                $cargo[$i]['nombre'] = $fila['nom_cargo'];
                $i++;
            }
        } else {
            $cargo = "";
        }
        mysql_free_result($resultado);
        return $cargo;
    }

    public function getNameByID($idCargo) {
        $consulta = " 	SELECT c.nom_cargo
						FROM cargo c
						WHERE id_cargo = $idCargo; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $cargo = mysql_result($resultado, 0, 'nom_cargo');
        } else {
            $cargo = "No especificado";
        }
        mysql_free_result($resultado);
        return $cargo;
    }

}

?>