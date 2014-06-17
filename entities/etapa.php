<?php
class etapa {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idEtapa' => $data['idEtapa'],
            'idTipoServicio' => $data['idTipoServicio'],
            'nombreEtapa' => $data['nombreEtapa']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO etapa VALUES(
                        NULL, {$data['idTipoServicio']}, '{$data['nombreEtapa']}'
                        ); ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE etapa SET
                        id_tipo_servicio={$data['idTipoServicio']}, 
                        nombre_etapa='{$data['nombreEtapa']}'
                        WHERE id_etapa= {$data['idEtapa']}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        $consulta = "	DELETE FROM etapa WHERE id_etapa = {$id}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    public function get($id) {
        $consulta = "	SELECT id_etapa, id_tipo_servicio, nombre_etapa
                        FROM etapa
                        WHERE id_etapa = {$id};
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $etapa = array(
                "idEtapa" => mysql_result($resultado, 0, "id_etapa"),
                "idTipoServicio" => mysql_result($resultado, 0, "id_tipo_servicio"),
                "nombreEtapa" => mysql_result($resultado, 0, "nombre_etapa")
            );
        } else {
            $etapa = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $etapa;
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
            $condicion .= "	AND (ts.nom_tipo_servicio LIKE '%$buscar%' OR e.nombre_etapa LIKE '%$buscar%')";
        }

        $consulta = " 	SELECT e.id_etapa AS 'ID', ts.nom_tipo_servicio AS 'Servicio', 
                        e.nombre_etapa AS  'Etapa'
                        FROM etapa e
                        INNER JOIN tipo_servicio ts ON e.id_tipo_servicio = ts.id_tipo_servicio
                        WHERE TRUE
                        $condicion
                        $orden
                        $limite
                        ; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $etapa = $general->consulta($resultado);
        } else {
            $etapa = "";
        }
        mysql_free_result($resultado);
        return $etapa;
    }

    public function numRows($buscar = '') {
        $condicion = "";
        if ($buscar <> "") {
            $condicion .= "	AND (ts.nom_tipo_servicio LIKE '%$buscar%' OR e.nombre_etapa LIKE '%$buscar%')";
        }
        $consulta = "	SELECT COUNT(e.id_etapa) AS 'total'
                        FROM etapa e
                        INNER JOIN tipo_servicio ts ON e.id_tipo_servicio = ts.id_tipo_servicio
                        WHERE TRUE
			$condicion
                        ;";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $etapa = mysql_result($resultado, 0, "total");
        } else {
            $etapa = 0;
        }
        mysql_free_result($resultado);
        $this->numRows = $etapa;
    }

    public function getCombo($idTipoServicio) {

        $consulta = " 	SELECT e.id_etapa, e.nombre_etapa
                        FROM etapa e
                        WHERE e.id_tipo_servicio = {$idTipoServicio}
                        ORDER BY 2 ASC; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $i = 0;
            while ($fila = mysql_fetch_array($resultado)) {
                $etapa[$i]['id'] = $fila['id_etapa'];
                $etapa[$i]['nombre'] = $fila['nombre_etapa'];
                $i++;
            }
        } else {
            $etapa = "";
        }
        mysql_free_result($resultado);
        return $etapa;
    }
}
?>