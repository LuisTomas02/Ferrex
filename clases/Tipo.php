<?php
require_once('Conexion.php');
class Tipo{
    private PDO $conexion;
    public function __construct(){
        $instancia = new Conexion();
        $this->conexion =$instancia->conectar();
    }
    function guardar($nombre, $color){
        $sql  = "INSERT INTO tipo(nombre, color, estatus) VALUE(:nombre, :color, 1)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
        'nombre' => $nombre,
        'color' => $color
        ]);
        return$stmt;
    }
    function mostrarTodos(){
        $sql = "SELECT * FROM tipo";
        $stmt =$this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>