<?php
//1 incluir clases
include('../clases/Tipo.php');
//2 HASER INSTANCIAS U OBJETOS
$clase_tipo = new Tipo();
//3recibir  datos por POST 
$nombre = $_POST['nombre'];
$color = $_POST['color'];

$resultado = $clase_tipo->guardar($nombre, $color);

if($resultado){
    echo "<script>
        alert('Guardado');
        window.location.href = '../lista_tipos.php';
    </script>";
}else{
    echo "error";
}
?>