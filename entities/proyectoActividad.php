<?php
class proyectoActividad {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idProyectoActividad' => $data['idProyectoActividad'],
            'idProyecto' => $data['idProyecto'],
            'idActividad' => $data['idActividad'],
            'fechaInicioProyectoActividad' => $data['fechaInicioProyectoActividad'],
            'fechaFinalProyectoActividad' => $data['fechaFinalProyectoActividad'],
            'horasAsignadasProyectoActividad' => $data['horasAsignadasProyectoActividad']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO proyecto_actividad VALUES(
                        NULL, {$data['idProyecto']}, {$data['idActividad']},
                        '{$data['fechaInicioProyectoActividad']}', '{$data['fechaFinalProyectoActividad']}',
                        '{$data['horasAsignadasProyectoActividad']}'
                        ); ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE proyecto_actividad SET
                        id_proyecto={$data['idProyecto']},
                        id_actividad={$data['idActividad']},
                        fecha_inicio_proyecto_actividad='{$data['fechaInicioProyectoActividad']}',
                        fecha_final_proyecto_actividad='{$data['fechaFinalProyectoActividad']}',
                        horas_asignadas_proyecto_actividad='{$data['horasAsignadasProyectoActividad']}'
                        WHERE id_proyecto_actividad= {$data['idProyectoActividad']}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        $consulta = "	DELETE FROM proyecto_actividad WHERE id_proyecto_actividad = {$id}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    public function get($id) {
        $consulta = "	SELECT id_proyecto_actividad, id_proyecto, id_actividad,
                        fecha_inicio_proyecto_actividad, fecha_final_proyecto_actividad,
                        horas_asignadas_proyecto_actividad
                        FROM proyecto_actividad
                        WHERE id_proyecto_actividad = {$id};
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $proyectoActividad = array(
                "idProyectoActividad" => mysql_result($resultado, 0, "id_proyecto_actividad"),
                "idProyecto" => mysql_result($resultado, 0, "id_proyecto"),
                "idActividad" => mysql_result($resultado, 0, "id_actividad"),
                "fechaInicioProyectoActividad" => mysql_result($resultado, 0, "fecha_inicio_proyecto_actividad"),
                "fechaFinalProyectoActividad" => mysql_result($resultado, 0, "fecha_final_proyecto_actividad"),
                "horasAsignadasProyectoActividad" => mysql_result($resultado, 0, "horas_asignadas_proyecto_actividad")
            );
        } else {
            $proyectoActividad = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $proyectoActividad;
    }

    public function show($idProyecto) {
        $consulta = " 	SELECT pa.id_proyecto_actividad AS 'ID', e.nombre_etapa AS  'Etapa',
                        a.nombre_actividad AS 'Actividad', pa.fecha_inicio_proyecto_actividad AS 'Inicio',
                        pa.fecha_final_proyecto_actividad AS 'Final', pa.horas_asignadas_proyecto_actividad AS 'Horas asignadas'
                        FROM proyecto_actividad pa
                        INNER JOIN actividad a ON pa.id_actividad = a.id_actividad
                        INNER JOIN etapa e ON a.id_etapa = e.id_etapa
                        WHERE pa.id_proyecto = {$idProyecto}
                        ; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $proyectoActividad = $general->consulta($resultado);
        } else {
            $proyectoActividad = "";
        }
        mysql_free_result($resultado);
        return $proyectoActividad;
    }
}
?>