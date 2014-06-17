<?php
class control {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idControl' => $data['idControl'],
            'idProyecto' => $data['idProyecto'],
            'idActividad' => $data['idActividad'],
            'idUsuario' => $data['idUsuario'],
            'horasImputadasControl' => $data['horasImputadasControl'],
            'situacionControl' => $data['situacionControl'],
            'observacionesControl' => $data['observacionesControl'],
            'esReprocesoControl' => $data['esReprocesoControl'],
            'porClienteControl' => $data['porClienteControl'],
            'fechaControl' => $data['fechaControl'],
            'actualCostoHoraConsultorControl' => $data['actualCostoHoraConsultorControl'],
            'fechaCreacion' => $data['fechaCreacion']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO control VALUES(
                        NULL, {$data['idProyecto']}, {$data['idActividad']}, 
                        {$data['idUsuario']}, '{$data['horasImputadasControl']}', 
                        '{$data['situacionControl']}', '{$data['observacionesControl']}',
                        {$data['esReprocesoControl']}, {$data['porClienteControl']},
                        '{$data['fechaControl']}', '{$data['actualCostoHoraConsultorControl']}',
                        NOW()
                        ); ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
    }

    function delete($id) {
    }

    public function get($id) {
        $consulta = "	SELECT id_control, id_proyecto, id_actividad,
                        id_usuario, horas_imputadas_control, situacion_control,
                        observaciones_control, es_reproceso_control, por_cliente_control,
                        fecha_control, actual_costo_hora_consultor_control
                        FROM control
                        WHERE id_control = {$id};
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $control = array(
                "idControl" => mysql_result($resultado, 0, "id_control"),
                "idProyecto" => mysql_result($resultado, 0, "id_proyecto"),
                "idActividad" => mysql_result($resultado, 0, "id_actividad"),
                "idUsuario" => mysql_result($resultado, 0, "id_usuario"),
                "horasImputadasControl" => mysql_result($resultado, 0, "horas_imputadas_control"),
                "situacionControl" => mysql_result($resultado, 0, "situacion_control"),
                "observacionesControl" => mysql_result($resultado, 0, "observaciones_control"),
                "esReprocesoControl" => mysql_result($resultado, 0, "es_reproceso_control"),
                "porClienteControl" => mysql_result($resultado, 0, "por_cliente_control"),
                "fechaControl" => mysql_result($resultado, 0, "fecha_control"),
                "actualCostoHoraConsultorControl" => mysql_result($resultado, 0, "actual_costo_hora_consultor_control")
            );
        } else {
            $control = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $control;
    }

    public function show($buscar = "", $pag = "", $idUsuario='') {

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

        $condicion = ($idUsuario<>'')? " AND c.id_usuario = {$_SESSION['usuario']['id']}" : "";
        
        if ($buscar <> "") {
            $condicion .= "	AND (a.nombre_actividad LIKE '%$buscar%' OR e.nombre_etapa LIKE '%$buscar%'
                                OR cl.nomcom_cliente LIKE '%$buscar%' OR cl.razsoc_cliente LIKE '%$buscar%' 
                                OR ts.nom_tipo_servicio LIKE '%$buscar%' OR pr.cod_propuesta LIKE '$buscar')";
        }

        $consulta = " 	SELECT c.id_control AS 'ID', ts.nom_tipo_servicio AS 'Servicio', pr.cod_propuesta AS 'C&oacute;digo',
                        IF(cl.nomcom_cliente='', cl.razsoc_cliente, cl.nomcom_cliente) AS 'Cliente', e.nombre_etapa AS 'Etapa',
                        a.nombre_actividad AS 'Actividad', c.horas_imputadas_control AS 'Horas',
                        c.fecha_control AS 'Fecha',
                        CASE WHEN c.situacion_control = 'P' THEN 'Pendiente'
                        WHEN c.situacion_control = 'T' THEN 'Terminado' END AS 'Situaci&oacute;n'
                        FROM control c
                        INNER JOIN actividad a ON c.id_actividad = a.id_actividad
                        INNER JOIN etapa e ON a.id_etapa = e.id_etapa
                        INNER JOIN proyecto p ON c.id_proyecto = p.id_proyecto
                        INNER JOIN propuesta pr ON p.id_propuesta = pr.id_propuesta
                        INNER JOIN tipo_servicio ts ON pr.id_tipo_servicio = ts.id_tipo_servicio
                        INNER JOIN cliente cl ON pr.id_cliente = cl.id_cliente
                        WHERE TRUE
                        $condicion
                        $orden
                        $limite
                        ; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $control = $general->consulta($resultado);
        } else {
            $control = "";
        }
        mysql_free_result($resultado);
        return $control;
    }

    public function numRows($buscar = '', $idUsuario='') {
        $condicion = ($idUsuario<>'')? " AND c.id_usuario = {$_SESSION['usuario']['id']}" : "";
        
        if ($buscar <> "") {
            $condicion .= "	AND (a.nombre_actividad LIKE '%$buscar%' OR e.nombre_etapa LIKE '%$buscar%'
                                OR cl.nomcom_cliente LIKE '%$buscar%' OR cl.razsoc_cliente LIKE '%$buscar%' 
                                OR ts.nom_tipo_servicio LIKE '%$buscar%' OR pr.cod_propuesta LIKE '$buscar')";
        }
        $consulta = "	SELECT COUNT(c.id_control) AS 'total'
                        FROM control c
                        INNER JOIN actividad a ON c.id_actividad = a.id_actividad
                        INNER JOIN etapa e ON a.id_etapa = e.id_etapa
                        INNER JOIN proyecto p ON c.id_proyecto = p.id_proyecto
                        INNER JOIN propuesta pr ON p.id_propuesta = pr.id_propuesta
                        INNER JOIN tipo_servicio ts ON pr.id_tipo_servicio = ts.id_tipo_servicio
                        INNER JOIN cliente cl ON pr.id_cliente = cl.id_cliente
                        WHERE TRUE
			$condicion
                        ;";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $control = mysql_result($resultado, 0, "total");
        } else {
            $control = 0;
        }
        mysql_free_result($resultado);
        $this->numRows = $control;
    }
}
?>