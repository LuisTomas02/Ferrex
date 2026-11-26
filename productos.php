<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header('location: login.php');
    exit();
}

require_once('clases/Conexion.php');

$instancia = new Conexion();
$conexion = $instancia->conectar();

$mensaje = "";

if(isset($_POST['guardar'])){

    $nombre = trim($_POST['nombre']);
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $minimo = $_POST['stock_minimo'];

    if($nombre != "" && is_numeric($precio) && $precio >= 0
        && filter_var($minimo, FILTER_VALIDATE_INT) !== false
        && $minimo >= 0){

        $sql = "INSERT INTO productos
                (nombre, descripcion, precio, stock, stock_minimo)
                VALUES (?, ?, ?, 0, ?)";

        $consulta = $conexion->prepare($sql);
        $consulta->execute([$nombre, $descripcion, $precio, $minimo]);

        $mensaje = "Producto registrado correctamente";

    }else{
        $mensaje = "Revisa los datos del producto";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos - Ferrex</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">

    <style>
        .formulario {
            width: 450px;
            max-width: 90%;
            margin: 30px auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
            color: black;
        }

        .formulario input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }

        .guardar {
            background: #b86b00;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="formulario">

        <h2 style="color: black;">Registrar producto</h2>

        <form method="POST">

            <label>Nombre</label>
            <input type="text" name="nombre" maxlength="100" required>

            <label>Descripción</label>
            <input type="text" name="descripcion" maxlength="150">

            <label>Precio</label>
            <input type="number" name="precio" step="0.01" min="0" required>

            <label>Stock mínimo</label>
            <input type="number" name="stock_minimo" min="0" required>

            <button class="guardar" name="guardar">
                Guardar producto
            </button>

        </form>

        <p><?= $mensaje ?></p>

        <a href="index.php">Regresar al menú</a>

    </div>

</body>
</html>