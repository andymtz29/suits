<?php

require_once '../config/conexion.php';

class Usuarios extends Conexion {

    public function consultar() {
        $consulta = $this->obtener_conexion()->prepare("SELECT * FROM t_usuario");
        $consulta->execute();
        $datos = $consulta->fetchAll(PDO::FETCH_ASSOC);
        $this->cerrar_conexion();
        echo json_encode($datos);
    }

    public function insertar_datos() {
        if (isset($_POST['usuario']) && !empty($_POST['usuario']) &&
            isset($_POST['password']) && !empty($_POST['password'])) {

            $nombreUsuario = $_POST['usuario'];
            $passwordUsuario = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash de la contraseña

            $insercion = $this->obtener_conexion()->prepare(
                "INSERT INTO t_usuario (usuario, password) VALUES(:usuario, :password)"
            );
            $insercion->bindParam(':usuario', $nombreUsuario);
            $insercion->bindParam(':password', $passwordUsuario);

            $insercion->execute();

            if ($insercion) {
                echo json_encode([1, "Usuario registrado"]);
            } else {
                echo json_encode([0, "Usuario NO registrado"]);
            }
        } else {
            echo json_encode([0, "No puedes dejar campos vacíos"]);
        }
    }

    public function actualizar_datos() {
        if (!empty($_POST['usuario']) && !empty($_POST['password'])) {

            $id_usuario = $_POST['idInput'];
            $nombreUsuario = $_POST['usuario'];
            $passwordUsuario = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash de la nueva contraseña

            $actualizacion = $this->obtener_conexion()->prepare(
                "UPDATE t_usuario SET usuario = :usuario, password = :password WHERE id_usuario = :id_usuario"
            );

            $actualizacion->bindParam(':usuario', $nombreUsuario);
            $actualizacion->bindParam(':password', $passwordUsuario);
            $actualizacion->bindParam(':id_usuario', $id_usuario);

            $actualizacion->execute();

            if ($actualizacion) {
                echo json_encode([1, "Usuario actualizado correctamente"]);
            } else {
                echo json_encode([0, "Usuario NO actualizado correctamente"]);
            }
        } else {
            echo json_encode([0, "Datos incompletos"]);
        }
    }

    public function eliminar_datos() {
        $id_usuario = $_POST['idInput'];
        $eliminar = $this->obtener_conexion()->prepare("DELETE FROM t_usuario WHERE id_usuario = :id_usuario");
        $eliminar->bindParam(':id_usuario', $id_usuario);
        $eliminar->execute();

        if ($eliminar) {
            echo json_encode([1, 'Usuario eliminado correctamente']);
        } else {
            echo json_encode([0, 'Usuario NO eliminado correctamente']);
        }
    }
}

$consulta = new Usuarios();
$metodo = $_POST['metodo'];
$consulta->$metodo();

?>
