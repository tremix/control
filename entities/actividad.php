<?php
class actividad {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idActividad' => $data['idActividad'],
            'idEtapa' => $data['idEtapa'],
            'nombreActividad' => $data['nombreActividad']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO actividad VALUES(
                        NULL, {$data['idEtapa']}, '{$data['nombreActividad']}'
                        ); ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE actividad SET
                        id_etapa={$data['idEtapa']}, 
                        nombre_actividad='{$data['nombreActividad']}'
                        WHERE id_actividad= {$data['idActividad']}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        $consulta = "	DELETE FROM actividad WHERE id_actividad = {$id}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    public function get($id) {
        $consulta = "	SELECT id_actividad, id_etapa, nombre_actividad
                        FROM actividad
                        WHERE id_actividad = {$id};
                    ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $actividad = array(
                "idActividad" => mysql_result($resultado, 0, "id_actividad"),
                "idEtapa" => mysql_result($resultado, 0, "id_etapa"),
                "nombreActividad" => mysql_result($resultado, 0, "nombre_actividad")
            );
        } else {
            $actividad = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $actividad;
    }

    
	
    public function show($id){
            $consulta = "   SELECT a.id_actividad AS 'ID', a.nombre_actividad AS 'Actividad'
                            FROM actividad a
                            WHERE a.id_etapa = $id; ";
            $resultado = mysql_query($consulta) or die (mysql_error());	
            if(mysql_num_rows($resultado)>0){
                    require_once(resources.'general.php');
                    $general = new general();
                    $actividad = $general->consulta($resultado);
            }else{
                    $actividad = "";
            }
            mysql_free_result($resultado);
            return $actividad;
    }

    public function getCombo($idEtapa) {

        $consulta = " 	SELECT a.id_actividad, a.nombre_actividad
                        FROM actividad a
                        WHERE a.id_etapa = {$idEtapa}
                        ORDER BY 2 ASC; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $i = 0;
            while ($fila = mysql_fetch_array($resultado)) {
                $actividad[$i]['id'] = $fila['id_actividad'];
                $actividad[$i]['nombre'] = $fila['nombre_actividad'];
                $i++;
            }
        } else {
            $actividad = "";
        }
        mysql_free_result($resultado);
        return $actividad;
    }
}
?>