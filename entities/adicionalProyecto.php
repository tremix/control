<?php

class adicionalProyecto {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idAdicionalProyecto' => $data['idAdicionalProyecto'],
            'idProyecto' => $data['idProyecto'],
            'idAdicional' => $data['idAdicional'],
            'idUsuario' => $data['idUsuario'],
            'costoAdicionalProyecto' => $data['costoAdicionalProyecto'],
            'comentarioAdicionalProyecto' => $data['comentarioAdicionalProyecto'],
            'fechaAdicionalProyecto' => $data['fechaAdicionalProyecto'],
            'fechaCreacion' => $data['fechaCreacion']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO adicional_proyecto VALUES(
                        NULL, {$data['idProyecto']}, {$data['idAdicional']},
                        {$data['idUsuario']}, '{$data['costoAdicionalProyecto']}',
                        '{$data['comentarioAdicionalProyecto']}', '{$data['fechaAdicionalProyecto']}',
                        NOW()
                        );		
                ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
    }

    function delete($id) {
    }

    public function get($id) {
    }

    public function show($buscar = "", $pag = "", $idUsuario = '') {

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

        $condicion = ($idUsuario<>'')? " AND ap.id_usuario = {$_SESSION['usuario']['id']}" : "";
        
        if ($buscar <> "") {
            $condicion .= "	AND (a.nombre_adicional LIKE '%$buscar%')";
        }
        $consulta = " 	SELECT ap.id_adicional_proyecto AS 'ID', pr.cod_propuesta AS 'C&oacute;digo', 
                        IF(cl.nomcom_cliente='', cl.razsoc_cliente, cl.nomcom_cliente) AS 'Cliente',
                        a.nombre_adicional AS 'Adicional', ap.costo_adicional_proyecto AS 'Costo',
                        ap.comentario_adicional_proyecto AS 'Comentario', ap.fecha_adicional_proyecto AS 'Fecha'
                        FROM adicional_proyecto ap
                        INNER JOIN adicional a ON ap.id_adicional = a.id_adicional
                        INNER JOIN proyecto p ON ap.id_proyecto = p.id_proyecto
                        INNER JOIN propuesta pr ON p.id_propuesta = pr.id_propuesta
                        INNER JOIN tipo_servicio ts ON pr.id_tipo_servicio = ts.id_tipo_servicio
                        INNER JOIN cliente cl ON pr.id_cliente = cl.id_cliente
                        WHERE TRUE
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

    public function numRows($buscar = '', $idUsuario = '') {

        $condicion = ($idUsuario<>'')? " AND ap.id_usuario = {$_SESSION['usuario']['id']}" : "";
        
        if ($buscar <> "") {
            $condicion .= "	AND (a.nombre_adicional LIKE '%$buscar%')";
        }
        $consulta = "	SELECT COUNT(ap.id_adicional_proyecto) AS 'total'
                        FROM adicional_proyecto ap
                        INNER JOIN adicional a ON ap.id_adicional = a.id_adicional
                        INNER JOIN proyecto p ON ap.id_proyecto = p.id_proyecto
                        INNER JOIN propuesta pr ON p.id_propuesta = pr.id_propuesta
                        INNER JOIN tipo_servicio ts ON pr.id_tipo_servicio = ts.id_tipo_servicio
                        INNER JOIN cliente cl ON pr.id_cliente = cl.id_cliente
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

}

?>