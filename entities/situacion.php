<?php

class situacion {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idSituacion' => $data['idSituacion'],
            'nomSituacion' => $data['nomSituacion']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO situacion VALUES(
                        NULL, '{$data['nomSituacion']}'
                        );";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE situacion SET
                        nom_situacion = '{$data['nomSituacion']}'
                        WHERE id_situacion = {$data['idSituacion']}
                        ;";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        
    }

    public function show() {
        $consulta = " 	SELECT s.id_situacion AS 'ID', s.nom_situacion AS 'Nombre'			
			FROM situacion s; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $situacion = $general->consulta($resultado);
        } else {
            $situacion = "";
        }
        mysql_free_result($resultado);
        return $situacion;
    }

    public function get($id) {
        $consulta = " 	SELECT s.id_situacion, s.nom_situacion
                        FROM situacion s
                        WHERE s.id_situacion = {$id}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $situacion['idSituacion'] = mysql_result($resultado, 0, 'id_situacion');
            $situacion['nomSituacion'] = mysql_result($resultado, 0, 'nom_situacion');
        } else {
            $situacion = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $situacion;
    }

    public function getNameByID($id) {
        $consulta = " 	SELECT s.nom_situacion
                        FROM situacion s
                        WHERE s.id_situacion = {$id}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $situacion = mysql_result($resultado, 0, 'nom_situacion');
        } else {
            $situacion = "";
        }
        mysql_free_result($resultado);
        return $situacion;
    }

    public function getCombo() {
        $consulta = " 	SELECT s.id_situacion, s.nom_situacion
                        FROM situacion s
			ORDER BY s.nom_situacion ASC; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $i = 0;
            while ($fila = mysql_fetch_array($resultado)) {
                $situacion[$i]['id'] = $fila['id_situacion'];
                $situacion[$i]['nombre'] = $fila['nom_situacion'];
                $i++;
            }
        } else {
            $situacion = "";
        }
        mysql_free_result($resultado);
        return $situacion;
    }

}

?>