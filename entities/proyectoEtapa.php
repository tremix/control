<?php
class proyectoEtapa {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idProyectoEtapa' => $data['idProyectoEtapa'],
            'idProyecto' => $data['idProyecto'],
            'idEtapa' => $data['idEtapa']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO proyecto_etapa VALUES(
                        NULL, {$data['idProyecto']}, {$data['idEtapa']}
                        ); ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE proyecto_etapa SET
                        id_proyecto={$data['idProyecto']}, 
                        id_etapa='{$data['idEtapa']}'
                        WHERE id_proyecto_etapa= {$data['idProyectoEtapa']}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        $consulta = "	DELETE FROM proyecto_etapa WHERE id_proyecto_etapa = {$id}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    public function get($id) {
        $consulta = "	SELECT id_proyecto_etapa, id_proyecto, id_etapa
                        FROM proyecto_etapa
                        WHERE id_proyecto_etapa = {$id};
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $proyectoEtapa = array(
                "idProyectoEtapa" => mysql_result($resultado, 0, "id_proyecto_etapa"),
                "idProyecto" => mysql_result($resultado, 0, "id_proyecto"),
                "idEtapa" => mysql_result($resultado, 0, "id_etapa")
            );
        } else {
            $proyectoEtapa = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $proyectoEtapa;
    }

    public function show($idProyecto) {
        $consulta = " 	SELECT pe.id_proyecto_etapa AS 'ID', e.nombre_etapa AS  'Etapa'
                        FROM proyecto_etapa pe
                        INNER JOIN etapa e ON pe.id_etapa = e.id_etapa
                        WHERE pe.id_proyecto = {$idProyecto}
                        ; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $proyectoEtapa = $general->consulta($resultado);
        } else {
            $proyectoEtapa = "";
        }
        mysql_free_result($resultado);
        return $proyectoEtapa;
    }

    public function getCombo($idProyecto) {

        $consulta = " 	SELECT e.id_etapa, e.nombre_etapa
                        FROM proyecto_etapa pe
                        INNER JOIN etapa e ON pe.id_etapa = e.id_etapa
                        WHERE pe.id_proyecto = {$idProyecto}
                        ORDER BY 2 ASC; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $i = 0;
            while ($fila = mysql_fetch_array($resultado)) {
                $proyectoEtapa[$i]['id'] = $fila['id_etapa'];
                $proyectoEtapa[$i]['nombre'] = $fila['nombre_etapa'];
                $i++;
            }
        } else {
            $proyectoEtapa = "";
        }
        mysql_free_result($resultado);
        return $proyectoEtapa;
    }
}
?>