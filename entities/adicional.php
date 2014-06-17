<?php

class adicional {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idAdicional' => $data['idAdicional'],
            'nombreAdicional' => $data['nombreAdicional']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO adicional VALUES(
                        NULL, '{$data['nombreAdicional']}'
                        );		
                ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE adicional SET
                        nombre_adicional = '{$data['nombreAdicional']}'
                        WHERE id_adicional = {$data['idAdicional']}
                        ;
                ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        $consulta = "	DELETE FROM adicional WHERE id_adicional = $id; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    public function get($id) {
        $consulta = " 	SELECT id_adicional, nombre_adicional
                        FROM adicional
                        WHERE id_adicional = $id; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $adicional['idAdicional'] = mysql_result($resultado, 0, 'id_adicional');
            $adicional['nombreAdicional'] = mysql_result($resultado, 0, 'nombre_adicional');
        } else {
            $adicional = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $adicional;
    }

    public function show($buscar = "", $pag = "") {

        $sentido = "";
        $orden = "";
        $limite = "";

        if (is_array($pag)) {
            if ($pag['colPag'] <> "") {
                if ($pag['ascPag']) {
                    $sentido = "ASC";
                } else {
                    $sentido = "DESC";
                }
                $orden = "ORDER BY {$pag['colPag']} $sentido";
            }

            $pag['actualPag'] *= $pag['cantPag'];

            $limite = "LIMIT {$pag['actualPag']}, {$pag['cantPag']}";
        }

        $condicion = "";
        if ($buscar <> "") {
            $condicion .= "	AND (a.nombre_adicional LIKE '%$buscar%')";
        }
        $consulta = " 	SELECT a.id_adicional AS 'ID', a.nombre_adicional AS 'Adicional'
                        FROM adicional a
                        ; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $adicional = $general->consulta($resultado);
        } else {
            $adicional = "";
        }
        mysql_free_result($resultado);
        return $adicional;
    }

    public function numRows($buscar = '') {

        $condicion = "";
        if ($buscar <> "") {
            $condicion .= "	AND (a.nombre_adicional LIKE '%$buscar%')   ";
        }
        $consulta = "	SELECT COUNT(a.id_adicional) AS 'total'
                        FROM adicional a
                        WHERE TRUE
			$condicion
                        ;";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $adicional = mysql_result($resultado, 0, "total");
        } else {
            $adicional = 0;
        }
        mysql_free_result($resultado);
        $this->numRows = $adicional;
    }

    public function getCombo() {
        $consulta = " 	SELECT a.id_adicional, a.nombre_adicional
                        FROM adicional a
                        ORDER BY a.nombre_adicional ASC; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $i = 0;
            while ($fila = mysql_fetch_array($resultado)) {
                $adicional[$i]['id'] = $fila['id_adicional'];
                $adicional[$i]['nombre'] = $fila['nombre_adicional'];
                $i++;
            }
        } else {
            $adicional = "";
        }
        mysql_free_result($resultado);
        return $adicional;
    }

}

?>