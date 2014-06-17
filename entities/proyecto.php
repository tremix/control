<?php
class proyecto {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idProyecto' => $data['idProyecto'],
            'idPropuesta' => $data['idPropuesta'],
            'costoHoraProyecto' => $data['costoHoraProyecto'],
            'esFacturableProyecto' => $data['esFacturableProyecto'],
            'estadoProyecto' => $data['estadoProyecto'],
            'fechaCreacion' => $data['fechaCreacion'],
            'fechaEdicion' => $data['fechaEdicion'],
            'usuarioCreacion' => $data['usuarioCreacion'],
            'usuarioEdicion' => $data['usuarioEdicion']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO proyecto VALUES(
                        NULL, {$data['idPropuesta']}, NULL, NULL, 1,
                        NOW(), NULL, {$data['usuarioCreacion']}, NULL
                        ); ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE proyecto SET
                        id_propuesta={$data['idPropuesta']}, 
                        costo_hora_proyecto='{$data['costoHoraProyecto']}', 
                        es_facturable_proyecto='{$data['esFacturableProyecto']}',
                        fecha_edicion=NOW(),
                        usuario_edicion={$data['usuarioCreacion']}
                        WHERE id_proyecto= {$data['idProyecto']}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function updateStatus($id) {
        $consulta = "	UPDATE proyecto SET
                        estado_proyecto = 'E'
                        WHERE id_proyecto = {$id}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        $data = $this->setArray;
        $consulta = "	DELETE FROM proyecto WHERE id_proyecto = {$id}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    public function get($id) {
        $consulta = "	SELECT id_proyecto, id_propuesta, costo_hora_proyecto,
                        es_facturable_proyecto, estado_proyecto
                        FROM proyecto
                        WHERE id_proyecto = {$id};
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $proyecto = array(
                "idProyecto" => mysql_result($resultado, 0, "id_proyecto"),
                "idPropuesta" => mysql_result($resultado, 0, "id_propuesta"),
                "costoHoraProyecto" => mysql_result($resultado, 0, "costo_hora_proyecto"),
                "esFacturableProyecto" => mysql_result($resultado, 0, "es_facturable_proyecto"),
                "estadoProyecto" => mysql_result($resultado, 0, "estado_proyecto")
            );
        } else {
            $proyecto = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $proyecto;
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
            $condicion .= "	AND (r.cod_propuesta LIKE '$buscar' OR c.nomcom_cliente LIKE '%$buscar%'
                                OR c.razsoc_cliente LIKE '%$buscar%')";
        }

        $consulta = " 	SELECT p.id_proyecto AS 'ID', r.cod_propuesta AS 'C&oacute;digo', 
                        c.nomcom_cliente AS  'Cliente'
                        FROM proyecto p
                        INNER JOIN propuesta r ON p.id_propuesta = r.id_propuesta
                        INNER JOIN cliente c ON r.id_cliente = c.id_cliente
                        WHERE p.estado_proyecto <> 'E'
                        $condicion
                        $orden
                        $limite
                        ; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $proyecto = $general->consulta($resultado);
        } else {
            $proyecto = "";
        }
        mysql_free_result($resultado);
        return $proyecto;
    }

    public function numRows($buscar = '') {
        $condicion = "";
        if ($buscar <> "") {
            $condicion .= "	AND (r.cod_propuesta LIKE '$buscar' OR c.nomcom_cliente LIKE '%$buscar%'
                                OR c.razsoc_cliente LIKE '%$buscar%')";
        }
        $consulta = "	SELECT COUNT(c.id_cliente) AS 'total'
			FROM proyecto p
                        INNER JOIN propuesta r ON p.id_propuesta = r.id_propuesta
                        INNER JOIN cliente c ON r.id_cliente = c.id_cliente
                        WHERE p.estado_proyecto <> 'E'
			$condicion
                        ;";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $proyecto = mysql_result($resultado, 0, "total");
        } else {
            $proyecto = 0;
        }
        mysql_free_result($resultado);
        $this->numRows = $proyecto;
    }

    public function getCombo() {

        $consulta = " 	SELECT p.id_proyecto, r.cod_propuesta
                        FROM proyecto p
                        INNER JOIN propuesta r ON p.id_propuesta = r.id_propuesta
                        ORDER BY 2 ASC; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $i = 0;
            while ($fila = mysql_fetch_array($resultado)) {
                $proyecto[$i]['id'] = $fila['id_proyecto'];
                $proyecto[$i]['nombre'] = $fila['cod_propuesta'];
                $i++;
            }
        } else {
            $proyecto = "";
        }
        mysql_free_result($resultado);
        return $proyecto;
    }

    public function getComboComplete($idCliente) {

        $consulta = " 	SELECT p.id_proyecto, r.cod_propuesta, ts.cod_tipo_servicio
                        FROM proyecto p
                        INNER JOIN propuesta r ON p.id_propuesta = r.id_propuesta
                        INNER JOIN tipo_servicio ts ON r.id_tipo_servicio = ts.id_tipo_servicio
                        WHERE r.id_cliente = {$idCliente}
                        ORDER BY 2 ASC; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $i = 0;
            while ($fila = mysql_fetch_array($resultado)) {
                $proyecto[$i]['id'] = $fila['id_proyecto'];
                $proyecto[$i]['nombre'] = $fila['cod_propuesta'].' - '.$fila['cod_tipo_servicio'];
                $i++;
            }
        } else {
            $proyecto = "";
        }
        mysql_free_result($resultado);
        return $proyecto;
    }

    public function getIdByProposalID($idPropuesta) {

        $consulta = " 	SELECT p.id_proyecto
                        FROM proyecto p
                        WHERE p.id_propuesta = {$idPropuesta}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
           $proyecto = mysql_result($resultado, 0, 'id_proyecto');
        } else {
            $proyecto = 0;
        }
        mysql_free_result($resultado);
        return $proyecto;
    }

    public function getCodProposalByID($idProyecto) {

        $consulta = " 	SELECT pr.cod_propuesta
                        FROM proyecto p
                        INNER JOIN propuesta pr ON p.id_propuesta = pr.id_propuesta
                        WHERE p.id_proyecto = {$idProyecto}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
           $proyecto = mysql_result($resultado, 0, 'cod_propuesta');
        } else {
            $proyecto = 0;
        }
        mysql_free_result($resultado);
        return $proyecto;
    }
}
?>