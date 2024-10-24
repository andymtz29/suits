<?php
class Registro extends Conexion {
    public function iniciar_registro() {
        if (!$datos) {
            $insercion = $this->obtener_conexion()->prepare();
            $insercion->bindParam(':nombre',$nombre);
            $insercion->bindParam(':apellido',$apellido);
            $insercion->bindParam(':usuario',$usuario);
            $pass = password_hash($password,PASSWORD_BCRYPT);
            $insercion->bindPAram(':password',$pass);
            
            if ($insercion->execute()){
                echo json_encode([1,"Usuario registrado con exito"]);
            } else {
                echo json_encode([0,"Error en credenciales de acceso"]);
            }
            
            
        } else {
            echo json_encode([0,"Error usuario registrado"]);
        }
        
        
    }
}

?>
11:50 a. m.


