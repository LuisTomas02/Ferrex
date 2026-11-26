
<?php

session_start();

$nombre_usuario = $_POST['nombre_usuario'];
$clave = $_POST['clave'];

include('../clases/Usuario.php');

$class = new Usuario();

$datos = $class->validar($nombre_usuario, $clave);

if($datos){
    $_SESSION['id_usuario'] = $datos['id_usuario'];
    $_SESSION['nombre_usuario'] = $datos['nombre_usuario'];

    header('location: ../index.php');
    exit();
}else{
    echo "Usuario o contraseña incorrectos";
}

?>
