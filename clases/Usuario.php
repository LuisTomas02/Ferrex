<?php
require_once('Conexion.php');

class Usuario{
    private PDO $conexion;

    public function __construct(){
        $instancia = new Conexion();
        $this->conexion =$instancia->conectar();
    }

    public function validar($nombre_usuario, $clave){

        $sql = "SELECT * FROM usuario WHERE nombre_usuario = :nombre_usuario AND clave = :clave";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
        'nombre_usuario' => $nombre_usuario,
        'clave' => $clave
        ]);
        return $stmt->fetch();
    }
}

?>