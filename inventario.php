<?php
session_start();

if(!isset($_SESSION['id_usuario'])){
    header('location: login.php');
    exit();
}

require_once('clases/Conexion.php');

$instancia = new Conexion();
$conexion = $instancia->conectar();

$sql = "SELECT * FROM productos";
$productos = $conexion->query($sql)->fetchAll();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Ferrex</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
    .container {
        width: 90%;
        margin: 30px auto;
    }

    .table th {
        background-color: #b86b00 !important;
        color: white !important;
        padding: 12px;
    }

    .table td {
        background-color: white !important;
        color: black !important;
        padding: 12px;
    }
</style>
</head>
<body>

    <div class="container mt-4">

        <h1 style="color: black;">Inventario de Ferrex</h1>

        <a href="index.php" class="btn btn-dark">
            Regresar al menú
        </a>

        <table class="table table-bordered table-light mt-4">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Stock mínimo</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach($productos as $p){ ?>

                    <tr>
                        <td><?= $p['id_producto'] ?></td>
                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                        <td><?= htmlspecialchars($p['descripcion'] ?? '') ?></td>
                        <td>$<?= $p['precio'] ?></td>
                        <td><?= $p['stock'] ?></td>
                        <td><?= $p['stock_minimo'] ?></td>
                    </tr>

                <?php } ?>

            </tbody>

        </table>

    </div>

</body>
</html>