
<?php
require_once(__DIR__ . '/clases/Conexion.php');

$conexion = new Conexion();
$pdo = $conexion->conectar();

$nombre_usuario = "admin";
$clave = password_hash("12345", PASSWORD_DEFAULT);

$sql = "INSERT INTO usuario (nombre_usuario, clave)
        VALUES (:nombre_usuario, :clave)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    'nombre_usuario' => $nombre_usuario,
    'clave' => $clave
]);

echo "Usuario creado correctamente";
?>
