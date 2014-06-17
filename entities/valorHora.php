<?php
class valorHora {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idValorHora' => $data['idValorHora'],
            'idUsuario' => $data['idUsuario'],
            'cantidadValorHora' => $data['cantidadValorHora']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO valor_hora VALUES(
                        NULL, {$data['idUsuario']}, '{$data['cantidadValorHora']}'
                        ); ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE valor_hora SET
                        id_usuario={$data['idUsuario']}, 
                        cantidad_valor_hora='{$data['cantidadValorHora']}'
                        WHERE id_valor_hora= {$data['idValorHora']}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        $consulta = "	DELETE FROM valor_hora WHERE id_valor_hora = {$id}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    public function get($id) {
        $consulta = "	SELECT id_valor_hora, id_usuario, cantidad_valor_hora
                        FROM valor_hora
                        WHERE id_valor_hora = {$id};
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $valorHora = array(
                "idValorHora" => mysql_result($resultado, 0, "id_valor_hora"),
                "idUsuario" => mysql_result($resultado, 0, "id_usuario"),
                "cantidadValorHora" => mysql_result($resultado, 0, "cantidad_valor_hora")
            );
        } else {
            $valorHora = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $valorHora;
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
            $condicion .= "	AND (n.nom_nivel LIKE '%$buscar%' OR u.nom_usuario LIKE '%$buscar%')";
        }

        $consulta = " 	SELECT vh.id_valor_hora AS 'ID', n.nom_nivel AS '&Aacute;rea', 
                        u.nom_usuario AS  'Consultor', vh.cantidad_valor_hora AS 'Valor por hora'
                        FROM valor_hora vh
                        INNER JOIN usuario u ON  vh.id_usuario = u.id_usuario
                        LEFT OUTER JOIN nivel n ON u.id_nivel = n.id_nivel
                        WHERE TRUE
                        $condicion
                        $orden
                        $limite
                        ; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $valorHora = $general->consulta($resultado);
        } else {
            $valorHora = "";
        }
        mysql_free_result($resultado);
        return $valorHora;
    }

    public function numRows($buscar = '') {
        $condicion = "";
        if ($buscar <> "") {
            $condicion .= "	AND (n.nom_nivel LIKE '%$buscar%' OR u.nom_usuario LIKE '%$buscar%')";
        }
        $consulta = "	SELECT COUNT(vh.id_valor_hora) AS 'total'
                        FROM valor_hora vh
                        INNER JOIN usuario u ON  vh.id_usuario = u.id_usuario
                        LEFT OUTER JOIN nivel n ON u.id_nivel = n.id_nivel
                        WHERE TRUE
			$condicion
                        ;";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $valorHora = mysql_result($resultado, 0, "total");
        } else {
            $valorHora = 0;
        }
        mysql_free_result($resultado);
        $this->numRows = $valorHora;
    }

    public function getIdByUserId($idUsuario) {
        $consulta = "	SELECT id_valor_hora
                        FROM valor_hora
                        WHERE id_usuario = {$idUsuario};
                    ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $valorHora = mysql_result($resultado, 0, 'id_valor_hora');
        } else {
            $valorHora = 0;
        }
        mysql_free_result($resultado);
        return $valorHora;
    }

    public function getPriceByUserId($idUsuario) {
        $consulta = "	SELECT cantidad_valor_hora
                        FROM valor_hora
                        WHERE id_usuario = {$idUsuario};
                    ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $valorHora = mysql_result($resultado, 0, 'cantidad_valor_hora');
        } else {
            $valorHora = 0;
        }
        mysql_free_result($resultado);
        return $valorHora;
    }
}
?>