<?php

class cliente {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idCliente' => $data['idCliente'],
            'idRubro' => $data['idRubro'],
            'correCliente' => $data['correCliente'],
            'codCliente' => $data['codCliente'],
            'razsocCliente' => $data['razsocCliente'],
            'nomcomCliente' => $data['nomcomCliente'],
            'rucCliente' => $data['rucCliente'],
            'nroempCliente' => $data['nroempCliente'],
            'webCliente' => $data['webCliente'],
            'estCliente' => $data['estCliente'],
            'fechCrea' => $data['fechCrea'],
            'fechEdita' => $data['fechEdita'],
            'usuCrea' => $data['usuCrea'],
            'usuEdita' => $data['usuEdita']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $data['correCliente'] = $this->getCod();
        $data['codCliente'] = 'C' . str_pad($data['correCliente'], 4, "0", STR_PAD_LEFT);
        $consulta = "	INSERT INTO cliente VALUES(
                        NULL, {$data['idRubro']}, '{$data['correCliente']}', '{$data['codCliente']}', 
                        '{$data['razsocCliente']}', '{$data['nomcomCliente']}', '{$data['rucCliente']}', 
                        '{$data['nroempCliente']}', '{$data['webCliente']}', '{$data['estCliente']}', 
                        NOW(), NULL, {$data['usuCrea']}, NULL
                        ); ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE cliente SET
                        id_rubro={$data['idRubro']}, 
                        cod_cliente='{$data['codCliente']}', 
                        corre_cliente='{$data['correCliente']}', 
                        razsoc_cliente='{$data['razsocCliente']}',
                        nomcom_cliente='{$data['nomcomCliente']}', 
                        ruc_cliente='{$data['rucCliente']}', 
                        nroemp_cliente='{$data['nroempCliente']}',
                        web_cliente='{$data['webCliente']}', 
                        est_cliente='{$data['estCliente']}', 
                        fech_edita=NOW(),
                        usu_edita={$data['usuCrea']}
                        WHERE id_cliente = {$data['idCliente']}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function updateStatus($id) {
        $consulta = "	UPDATE cliente SET
						est_cliente = 'E'
						WHERE id_cliente = $id; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        $data = $this->setArray;
        $consulta = "	DELETE FROM cliente WHERE id_cliente = $id; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    public function get($id) {
        $consulta = "	SELECT id_cliente, id_rubro, corre_cliente, cod_cliente, 
                        razsoc_cliente, nomcom_cliente, ruc_cliente,
                        nroemp_cliente, web_cliente, est_cliente						
                        FROM cliente
                        WHERE id_cliente = $id;
                ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $cliente = array(
                "idCliente" => mysql_result($resultado, 0, "id_cliente"),
                "idRubro" => mysql_result($resultado, 0, "id_rubro"),
                "correCliente" => mysql_result($resultado, 0, "corre_cliente"),
                "codCliente" => mysql_result($resultado, 0, "cod_cliente"),
                "razsocCliente" => mysql_result($resultado, 0, "razsoc_cliente"),
                "nomcomCliente" => mysql_result($resultado, 0, "nomcom_cliente"),
                "rucCliente" => mysql_result($resultado, 0, "ruc_cliente"),
                "nroempCliente" => mysql_result($resultado, 0, "nroemp_cliente"),
                "webCliente" => mysql_result($resultado, 0, "web_cliente"),
                "estCliente" => mysql_result($resultado, 0, "est_cliente")
            );
        } else {
            $cliente = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $cliente;
    }

    public function show($buscar = "", $pag = "", $adic = true) {

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
            $condicion .= "	AND (c.cod_cliente LIKE '$buscar' OR c.nomcom_cliente LIKE '%$buscar%'
							OR c.razsoc_cliente LIKE '%$buscar%' OR c.ruc_cliente LIKE '$buscar')";
        }

        $adicional = "";
        if ($adic) {
            $adicional = ", CONCAT('<img src=" . '"' . "img/icon_contact.png" . '"' . " height=" . '"' . "24" . '"' . " width=" . '"' . "24" . '"' . " id=" . '"' . "showContact" . '"' . " title=" . '"' . "Contacto Principal" . '"' . " name=" . '"' . "contactos_mant.php?opMantDif=sh&id=', c.id_cliente, '" . '"' . " />') AS 'Contacto',
						CONCAT('<img src=" . '"' . "img/icon_address.png" . '"' . " height=" . '"' . "24" . '"' . " width=" . '"' . "24" . '"' . " id=" . '"' . "showAddress" . '"' . " title=" . '"' . "Contacto Principal" . '"' . " name=" . '"' . "direcciones_mant.php?opMantDif=sh&id=', c.id_cliente, '" . '"' . " />') AS 'Direcci&oacute;n',
						CONCAT('<img src=" . '"' . "img/icon_history.png" . '"' . " height=" . '"' . "24" . '"' . " width=" . '"' . "24" . '"' . " id=" . '"' . "showHistory" . '"' . " title=" . '"' . "Haga click para ver el historial" . '"' . " name=" . '"' . "cliente_historial.php?&id=', c.id_cliente, '" . '"' . " />') AS 'Historial'
						";
        }

        $consulta = " 	SELECT c.id_cliente AS 'ID', c.cod_cliente AS 'C&oacute;digo', 
                        c.nomcom_cliente AS  'Nombre Comercial', c.ruc_cliente AS 'RUC' 
                        /*CONCAT('<a href=" . '"' . "http://',c.web_cliente,'" . '"' . " target=_blank>', c.web_cliente,'</a>') AS 'Web',*/
                        $adicional						
                        FROM cliente c
                        WHERE est_cliente <> 'E'
                        $condicion
                        $orden
                        $limite
                        ; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $cliente = $general->consulta($resultado);
        } else {
            $cliente = "";
        }
        mysql_free_result($resultado);
        return $cliente;
    }

    public function numRows($buscar = '') {
        $condicion = "";
        if ($buscar <> "") {
            $condicion .= "	AND (c.cod_cliente LIKE '$buscar' OR c.nomcom_cliente LIKE '%$buscar%'
							OR c.razsoc_cliente LIKE '%$buscar%' OR c.ruc_cliente LIKE '$buscar')";
        }
        $consulta = "	SELECT COUNT(c.id_cliente) AS 'total'
						FROM cliente c
						WHERE c.est_cliente <> 'E'
						$condicion;
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $cliente = mysql_result($resultado, 0, "total");
        } else {
            $cliente = 0;
        }
        mysql_free_result($resultado);
        $this->numRows = $cliente;
    }

    public function getCombo() {

        $consulta = " 	SELECT c.id_cliente, IFNULL(c.nomcom_cliente, c.razsoc_cliente) AS 'nom_cliente'
						FROM cliente c
						ORDER BY 2 ASC; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $i = 0;
            while ($fila = mysql_fetch_array($resultado)) {
                $cliente[$i]['id'] = $fila['id_cliente'];
                $cliente[$i]['nombre'] = $fila['nom_cliente'];
                $i++;
            }
        } else {
            $cliente = "";
        }
        mysql_free_result($resultado);
        return $cliente;
    }

    public function getCod() {
        $consulta = "	SELECT (MAX(IFNULL(c.corre_cliente, 1)) + 1) AS 'codigo'
						FROM cliente c;
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $cliente = mysql_result($resultado, 0, "codigo");
        } else {
            $cliente = 0;
        }
        mysql_free_result($resultado);
        return $cliente;
    }

    public function getCodByID($idCliente) {
        $consulta = "	SELECT corre_cliente
						FROM cliente c
						WHERE id_cliente = $idCliente;
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $cliente = mysql_result($resultado, 0, "corre_cliente");
        } else {
            $cliente = 0;
        }
        mysql_free_result($resultado);
        return $cliente;
    }

    public function getNameByID($idCliente) {
        $consulta = "	SELECT IFNULL(nomcom_cliente, razsoc_cliente) AS 'nom_cliente'
                                FROM cliente
                                WHERE id_cliente = $idCliente;
                        ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $cliente = mysql_result($resultado, 0, "nom_cliente");
        } else {
            $cliente = 0;
        }
        mysql_free_result($resultado);
        return $cliente;
    }

}

?>