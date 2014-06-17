<?php
class propuesta {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idPropuesta' => $data['idPropuesta'],
            'idCliente' => $data['idCliente'],
            'idUsuarioComercial' => $data['idUsuarioComercial'],
            'idUsuarioTecnico' => $data['idUsuarioTecnico'],
            'idMoneda' => $data['idMoneda'],
            'idTipoServicio' => $data['idTipoServicio'],
            'idTipoArea' => $data['idTipoArea'],
            'idTipoPropuesta' => $data['idTipoPropuesta'],
            'idSituacion' => $data['idSituacion'],
            'correPropuesta' => $data['correPropuesta'],
            'codPropuesta' => $data['codPropuesta'],
            'varPropuesta' => $data['varPropuesta'],
            'fechPropuesta' => $data['fechPropuesta'],
            'comiPropuesta' => $data['comiPropuesta'],
            'liciPropuesta' => $data['liciPropuesta'],
            'porcPropuesta' => $data['porcPropuesta'],
            'descrPropuesta' => $data['descrPropuesta'],
            'montoPropuesta' => $data['montoPropuesta'],
            'fechestiPropuesta' => $data['fechestiPropuesta'],
            'estPropuesta' => $data['estPropuesta'],
            'fechCrea' => $data['fechCrea'],
            'fechEdita' => $data['fechEdita'],
            'usuCrea' => $data['usuCrea'],
            'usuEdita' => $data['usuEdita']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        require_once(entities . 'cliente.php');
        $cliente = new cliente();
        $data = $this->setArray;
        $data['correPropuesta'] = $this->getCod($data['idCliente']);
        $data['codPropuesta'] = 'P' . str_pad($cliente->getCodByID($data['idCliente']), 4, "0", STR_PAD_LEFT);
        $data['codPropuesta'] .= str_pad($data['correPropuesta'], 2, "0", STR_PAD_LEFT);
        $consulta = "	INSERT INTO propuesta VALUES(
                        NULL, {$data['idCliente']}, {$data['idUsuarioComercial']}, {$data['idUsuarioTecnico']}, 
                        {$data['idMoneda']}, {$data['idTipoServicio']}, {$data['idTipoArea']}, 
                        {$data['idTipoPropuesta']}, {$data['idSituacion']},
                        '{$data['correPropuesta']}', '{$data['codPropuesta']}', 	
                        '{$data['varPropuesta']}', '{$data['fechPropuesta']}',
                        '{$data['comiPropuesta']}', '{$data['liciPropuesta']}',
                        '{$data['porcPropuesta']}', '{$data['descrPropuesta']}',
                        '{$data['montoPropuesta']}', '{$data['fechestiPropuesta']}', 
                        '{$data['estPropuesta']}', 
                        NOW(), NULL, {$data['usuCrea']}, NULL
                        ); ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE propuesta SET
                        id_cliente={$data['idCliente']}, 
                        id_usuario_comercial={$data['idUsuarioComercial']}, 
                        id_usuario_tecnico={$data['idUsuarioTecnico']}, 
                        id_moneda={$data['idMoneda']}, 
                        id_tipo_servicio={$data['idTipoServicio']},
                        id_tipo_area={$data['idTipoArea']},
                        id_tipo_propuesta={$data['idTipoPropuesta']},
                        id_situacion={$data['idSituacion']},
                        corre_propuesta='{$data['codPropuesta']}', 
                        cod_propuesta='{$data['codPropuesta']}', 
                        var_propuesta='{$data['varPropuesta']}', 
                        fech_propuesta='{$data['fechPropuesta']}', 
                        comi_propuesta='{$data['comiPropuesta']}', 
                        lici_propuesta='{$data['liciPropuesta']}', 
                        porc_propuesta='{$data['porcPropuesta']}', 
                        descr_propuesta='{$data['descrPropuesta']}', 
                        monto_propuesta='{$data['montoPropuesta']}', 
                        fechesti_propuesta='{$data['fechestiPropuesta']}', 
                        est_propuesta='{$data['estPropuesta']}', 
                        fech_edita=NOW(),
                        usu_edita={$data['usuEdita']}
                        WHERE id_propuesta = {$data['idPropuesta']}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function updateStatus($id) {
        $consulta = "	UPDATE propuesta SET
                        est_propuesta = 'E'
                        WHERE id_propuesta = $id; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        $data = $this->setArray;
        $consulta = "	DELETE FROM propuesta WHERE id_propuesta = $id; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    public function get($id) {
        $consulta = "	SELECT id_propuesta, id_cliente, 
                        id_usuario_comercial, id_usuario_tecnico, 
                        id_moneda, id_tipo_servicio, 
                        id_tipo_area, id_tipo_propuesta,
                        id_situacion, corre_propuesta, 
                        cod_propuesta, var_propuesta, 
                        fech_propuesta, comi_propuesta, 
                        lici_propuesta, porc_propuesta, 
                        descr_propuesta, monto_propuesta, 
                        fechesti_propuesta, est_propuesta						
                        FROM propuesta
                        WHERE id_propuesta = $id
                        ;";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $propuesta = array(
                "idPropuesta" => mysql_result($resultado, 0, "id_propuesta"),
                "idCliente" => mysql_result($resultado, 0, "id_cliente"),
                "idUsuarioComercial" => mysql_result($resultado, 0, "id_usuario_comercial"),
                "idUsuarioTecnico" => mysql_result($resultado, 0, "id_usuario_tecnico"),
                "idMoneda" => mysql_result($resultado, 0, "id_moneda"),
                "idTipoServicio" => mysql_result($resultado, 0, "id_tipo_servicio"),
                "idTipoArea" => mysql_result($resultado, 0, "id_tipo_area"),
                "idTipoPropuesta" => mysql_result($resultado, 0, "id_tipo_propuesta"),
                "idSituacion" => mysql_result($resultado, 0, "id_situacion"),
                "correPropuesta" => mysql_result($resultado, 0, "corre_propuesta"),
                "codPropuesta" => mysql_result($resultado, 0, "cod_propuesta"),
                "varPropuesta" => mysql_result($resultado, 0, "var_propuesta"),
                "fechPropuesta" => mysql_result($resultado, 0, "fech_propuesta"),
                "comiPropuesta" => mysql_result($resultado, 0, "comi_propuesta"),
                "liciPropuesta" => mysql_result($resultado, 0, "lici_propuesta"),
                "porcPropuesta" => mysql_result($resultado, 0, "porc_propuesta"),
                "descrPropuesta" => mysql_result($resultado, 0, "descr_propuesta"),
                "montoPropuesta" => mysql_result($resultado, 0, "monto_propuesta"),
                "fechestiPropuesta" => mysql_result($resultado, 0, "fechesti_propuesta"),
                "estPropuesta" => mysql_result($resultado, 0, "est_propuesta")
            );
        } else {
            $cliente = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $propuesta;
    }

    public function show($buscar = "", $pag = "", $segui = true) {

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
            $condicion .= "	AND (p.cod_propuesta LIKE '$buscar' OR c.nomcom_cliente LIKE '%$buscar%'
                                OR c.cod_cliente LIKE '$buscar' OR tp.nom_tipo_propuesta LIKE '%$buscar%'
                                OR ta.nom_tipo_area LIKE '%$buscar%' OR ts.nom_tipo_servicio LIKE '%$buscar%'
                                OR tp.cod_tipo_propuesta LIKE '$buscar' OR ta.cod_tipo_area LIKE '$buscar'
                                OR ts.cod_tipo_servicio LIKE '$buscar' OR s.nom_situacion LIKE '$buscar'
                                OR p.var_propuesta LIKE '$buscar' OR p.porc_propuesta LIKE '$buscar'
                                )";
        }

        $seguimiento = "";
        if ($segui) {
            $seguimiento = ", CONCAT('<img src=" . '"' . "img/icon_trace.png" . '"' . " height=" . '"' . "24" . '"' . " width=" . '"' . "24" . '"' . " id=" . '"' . "showTrace" . '"' . " title=" . '"' . "&Uacute;ltimo seguimiento" . '"' . " name=" . '"' . "seguimientos_mant.php?opMantDif=sh&id=', p.id_propuesta, '" . '"' . " />') AS 'Seguimiento'";
        }

        $consulta = " 	SELECT p.id_propuesta AS 'ID', 
                        /*CONCAT('<a id=" . '"' . "editar" . '"' . " href=" . '"' . "propuestas_mant.php?opMant=li&id=', p.id_propuesta, '" . '"' . ">', c.cod_cliente, '</a>') AS 'Cod. Cliente',
                        CONCAT('<a id=" . '"' . "editar" . '"' . " href=" . '"' . "propuestas_mant.php?opMant=li&id=', p.id_propuesta, '" . '"' . ">', c.nomcom_cliente, '</a>') AS  'Cliente',  */
                        p.fech_propuesta AS 'Fecha',
                        c.cod_cliente AS 'Cod. Cliente',  c.nomcom_cliente AS 'Cliente',
                        p.cod_propuesta AS 'C&oacute;digo',
                        IFNULL(tp.cod_tipo_propuesta, 'No especificado') AS 'Tipo',
                        IFNULL(ta.cod_tipo_area, 'No especificado') AS '&Aacute;rea',
                        IFNULL(ts.cod_tipo_servicio, 'No especificado') AS 'Servicio',
                        IF(p.lici_propuesta=1, 'S&iacute;', 'No') AS 'Lic.',
                        p.descr_propuesta AS 'Descripci&oacute;n',
                        s.nom_situacion AS 'Situaci&oacute;n', p.var_propuesta AS 'Varios',
                        /*p.fechesti_propuesta AS 'Fecha Estimada', */
                        /*DATE_FORMAT(se.sigac_seguimiento, '%d/%m/%Y') AS 'Sig. Acc.',*/
                        IF(se.sigac_seguimiento='0000-00-00 00:00:00', '', se.sigac_seguimiento)  AS 'Prox. Segui.',
                        TRUNCATE(IFNULL(p.porc_propuesta, 0), 0) AS '%'
                        $seguimiento
                        FROM propuesta p
                        INNER JOIN cliente c ON p.id_cliente = c.id_cliente
                        LEFT OUTER JOIN tipo_servicio ts ON p.id_tipo_servicio = ts.id_tipo_servicio
                        LEFT OUTER JOIN tipo_area ta ON p.id_tipo_area = ta.id_tipo_area
                        LEFT OUTER JOIN tipo_propuesta tp ON p.id_tipo_propuesta = tp.id_tipo_propuesta
                        LEFT OUTER JOIN situacion s ON p.id_situacion = s.id_situacion
                        LEFT OUTER JOIN seguimiento se ON p.id_propuesta = se.id_propuesta AND se.id_seguimiento = (SELECT MAX(id_seguimiento) FROM seguimiento WHERE id_propuesta = p.id_propuesta )
                        WHERE p.est_propuesta <> 'E'
                        $condicion
                        $orden
                        $limite
                        ; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $propuesta = $general->consulta($resultado);
        } else {
            $propuesta = "";
        }
        mysql_free_result($resultado);
        return $propuesta;
    }

    public function numRows($buscar = '') {
        $condicion = "";
        if ($buscar <> "") {
            $condicion .= "	AND (p.cod_propuesta LIKE '$buscar' OR c.nomcom_cliente LIKE '%$buscar%'
                                OR c.cod_cliente LIKE '$buscar' OR tp.nom_tipo_propuesta LIKE '%$buscar%'
                                OR ta.nom_tipo_area LIKE '%$buscar%' OR ts.nom_tipo_servicio LIKE '%$buscar%'
                                OR tp.cod_tipo_propuesta LIKE '$buscar' OR ta.cod_tipo_area LIKE '$buscar'
                                OR ts.cod_tipo_servicio LIKE '$buscar' OR s.nom_situacion LIKE '$buscar'
                                OR p.var_propuesta LIKE '$buscar' OR p.porc_propuesta LIKE '$buscar'
                                )";
        }

        $consulta = "	SELECT COUNT(p.id_propuesta) AS 'total'
                        FROM propuesta p
                        INNER JOIN cliente c ON p.id_cliente = c.id_cliente
                        LEFT OUTER JOIN tipo_servicio ts ON p.id_tipo_servicio = ts.id_tipo_servicio
                        LEFT OUTER JOIN tipo_area ta ON p.id_tipo_area = ta.id_tipo_area
                        LEFT OUTER JOIN tipo_propuesta tp ON p.id_tipo_propuesta = tp.id_tipo_propuesta
                        LEFT OUTER JOIN situacion s ON p.id_situacion = s.id_situacion
                        WHERE p.est_propuesta <> 'E'
                        $condicion
                        ;";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $propuesta = mysql_result($resultado, 0, "total");
        } else {
            $propuesta = 0;
        }
        mysql_free_result($resultado);
        $this->numRows = $propuesta;
    }

    public function getCod($idCliente) {
        $consulta = "	SELECT (IFNULL(MAX(p.corre_propuesta), 0) + 1) AS 'codigo'
                        FROM propuesta p
                        WHERE p.id_cliente = $idCliente
                        ;";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $propuesta = mysql_result($resultado, 0, "codigo");
        } else {
            $propuesta = 1;
        }
        mysql_free_result($resultado);
        return $propuesta;
    }

    public function getByCliente($idCliente) {
        $consulta = "	SELECT p.id_propuesta AS 'id', 
                        IFNULL(tp.nom_tipo_propuesta, 'No especificado') AS 'tipoPropuesta',
                        IFNULL(ts.nom_tipo_servicio, 'No especificado') AS 'tipoServicio',
                        IFNULL(ta.cod_tipo_area, 'No especificado') AS 'area',
                        IF(u1.id_usuario IS NOT NULL, CONCAT(u1.nom_usuario, ' ', u1.ape_usuario), 'No especificado') AS 'comercial',
                        IF(u2.id_usuario IS NOT NULL, CONCAT(u2.nom_usuario, ' ', u2.ape_usuario), 'No especificado') AS 'tecnico',
                        CONCAT(m.nom_moneda, '(', m.simb_moneda, ')') AS 'moneda',
                        p.monto_propuesta AS 'monto', p.cod_propuesta AS 'codigo', 
                        p.descr_propuesta AS 'descripcion'
                        FROM propuesta p
                        INNER JOIN cliente c ON p.id_cliente = c.id_cliente
                        LEFT OUTER JOIN tipo_propuesta tp ON p.id_tipo_propuesta = tp.id_tipo_propuesta
                        LEFT OUTER JOIN tipo_area ta ON p.id_tipo_area = ta.id_tipo_area
                        LEFT OUTER JOIN tipo_servicio ts ON p.id_tipo_servicio = ts.id_tipo_servicio
                        LEFT OUTER JOIN usuario u1 ON p.id_usuario_comercial = u1.id_usuario
                        LEFT OUTER JOIN usuario u2 ON p.id_usuario_tecnico = u2.id_usuario
                        LEFT OUTER JOIN moneda m ON p.id_moneda = m.id_moneda
                        WHERE p.id_cliente = $idCliente
                        ;";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $i = 1;
            while ($fila = mysql_fetch_array($resultado)) {
                $propuesta[$i] = array(
                    'id' => $fila['id'],
                    'tipoPropuesta' => $fila['tipoPropuesta'],
                    'tipoServicio' => $fila['tipoServicio'],
                    'area' => $fila['area'],
                    'comercial' => $fila['comercial'],
                    'tecnico' => $fila['tecnico'],
                    'moneda' => $fila['moneda'],
                    'codigo' => $fila['codigo'],
                    'descripcion' => $fila['descripcion'],
                    'monto' => $fila['monto']
                );
                $i++;
            }
        } else {
            $propuesta = "";
        }
        mysql_free_result($resultado);
        return $propuesta;
    }
}
?>