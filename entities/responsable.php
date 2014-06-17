<?php
class responsable {

    var $setArray;
    var $allArray;
    var $numRows;

    function set($data) {
        $resultado = array(
            'idResponsable' => $data['idResponsable'],
            'idProyecto' => $data['idProyecto'],
            'idUsuario' => $data['idUsuario']
        );
        $this->setArray = $resultado;
    }

    function insert() {
        $data = $this->setArray;
        $consulta = "	INSERT INTO responsable VALUES(
                        NULL, {$data['idProyecto']}, '{$data['idUsuario']}'
                        ); ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        $id = mysql_insert_id();
        return $id;
    }

    function update() {
        $data = $this->setArray;
        $consulta = "	UPDATE responsable SET
                        id_proyecto={$data['idProyecto']}, 
                        id_usuario='{$data['idUsuario']}'
                        WHERE id_responsable= {$data['idResponsable']}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    function delete($id) {
        $consulta = "	DELETE FROM responsable WHERE id_responsable = {$id}; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        return $resultado;
    }

    public function get($id) {
        $consulta = "	SELECT id_responsable, id_proyecto, id_usuario
                        FROM responsable
                        WHERE id_responsable = {$id};
					";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            $responsable = array(
                "idResponsable" => mysql_result($resultado, 0, "id_responsable"),
                "idProyecto" => mysql_result($resultado, 0, "id_proyecto"),
                "idUsuario" => mysql_result($resultado, 0, "id_usuario")
            );
        } else {
            $responsable = "";
        }
        mysql_free_result($resultado);
        $this->setArray = $responsable;
    }

    public function show($idProyecto) {
        
        $consulta = " 	SELECT r.id_responsable AS 'ID', CONCAT(u.nom_usuario, ' ', u.ape_usuario) AS  'Responsable'
                        FROM responsable r
                        INNER JOIN usuario u ON r.id_usuario = u.id_usuario
                        WHERE r.id_proyecto = {$idProyecto}
                        ; ";
        $resultado = mysql_query($consulta) or die(mysql_error());
        if (mysql_num_rows($resultado) > 0) {
            require_once(resources . 'general.php');
            $general = new general();
            $responsable = $general->consulta($resultado);
        } else {
            $responsable = "";
        }
        mysql_free_result($resultado);
        return $responsable;
    }
}
?>