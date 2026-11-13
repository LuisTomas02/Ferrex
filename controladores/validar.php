<?php

$nombre_usuario = $_POST['nombre_usuario'];
$clave = $_POST['clave'];

include('../clases/Usuario.php');

$class = new Usuario();
 
$datos = $class->validar($nombre_usuario, $clave);

if($datos){
    session_start();
    $_SESSION['idusuario'] = $datos['idusuario'];
    $_SESSION['nombre_completo'] = $datos['nombre_completo'];
    $_SESSION['tipo'] = $datos['tipo'];
    header('location: ../index.php');
}else{
    echo "Usuario NO encontrado";
}

?>