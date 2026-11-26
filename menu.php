<?php

if(!isset($_SESSION['id_usuario'])){
    header('location: login.php');
    exit();
}

require_once('clases/Conexion.php');

$instancia = new Conexion();
$conexion = $instancia->conectar();

$sql = "SELECT movimientos.fecha,
               movimientos.tipo,
               productos.nombre,
               movimientos.cantidad
        FROM movimientos
        INNER JOIN productos
        ON movimientos.id_producto = productos.id_producto
        ORDER BY movimientos.fecha DESC
        LIMIT 5";

$movimientos = $conexion->query($sql)->fetchAll();

$sql2 = "SELECT nombre, stock, stock_minimo
         FROM productos
         WHERE stock <= stock_minimo
         ORDER BY stock ASC
         LIMIT 5";

$poco_stock = $conexion->query($sql2)->fetchAll();

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ferrex</title>
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <script src="js/bootstrap.js"></script>

</head>
<!-- ENCABEZADO -->
    <header class="encabezado">

        <div class="logo">
            <img src="../img/Ferrex.png" alt="Logo Ferrex">
        </div>

        <div class="buscador">
            <input type="text" placeholder="Buscar en el sistema...">
            <span>Ctrl K</span>
        </div>

       <div class="iconos">
    <button>🔔</button>
    <button>⚙️</button>
    <a href="controladores/cerrar_sesion.php" class="btn-cerrar">
    Cerrar sesión
</a>
</div>

    </header>


    <!-- CONTENIDO PRINCIPAL -->
    <main>

        <h2>¿Qué vas a hacer hoy?</h2>

        <!-- OPCIONES DEL SISTEMA -->
        <section class="opciones">

           <a href="inventario.php" class="tarjeta inventario">
    <div class="icono">▤</div>
    <h3>Inventario</h3>
    <p>Revisar stock disponible</p>
</a>

            <a href="#" class="tarjeta entrada">
                <div class="icono">🛒</div>
                <h3>Registrar Entrada</h3>
                <p>Ingreso de mercancía</p>
            </a>

            <a href="#" class="tarjeta salida">
                <div class="icono">🛒</div>
                <h3>Registrar Salida</h3>
                <p>Salida o venta de productos</p>
            </a>

            <a href="#" class="tarjeta proveedores">
                <div class="icono">♙</div>
                <h3>Proveedores</h3>
                <p>Gestión de contactos</p>
            </a>

            <a href="productos.php" class="tarjeta productos">
                <div class="icono">⬡</div>
                <h3>Productos</h3>
                <p>Consulta y administración</p>
            </a>

            <a href="#" class="tarjeta reportes">
                <div class="icono">▥</div>
                <h3>Reportes</h3>
                <p>Consulta de ventas y stock</p>
            </a>

        </section>


        <!-- TABLAS DE INFORMACION -->
        <section class="panel">

            <!-- ULTIMOS MOVIMIENTOS -->
            <div class="movimientos">

                <h3>◷ &nbsp; Últimos movimientos</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>

                <tbody>

    <?php foreach($movimientos as $m){ ?>

        <tr>
            <td><?= date('d/m/Y', strtotime($m['fecha'])) ?></td>

            <td>
                <?php if($m['tipo'] == 'Entrada'){ ?>
                    <span class="etiqueta entrada-t">Entrada</span>
                <?php }else{ ?>
                    <span class="etiqueta salida-t">Salida</span>
                <?php } ?>
            </td>

            <td><?= htmlspecialchars($m['nombre']) ?></td>

            <?php if($m['tipo'] == 'Entrada'){ ?>
                <td class="positivo">+<?= abs($m['cantidad']) ?></td>
            <?php }else{ ?>
                <td class="negativo">-<?= abs($m['cantidad']) ?></td>
            <?php } ?>

        </tr>

    <?php } ?>

    <?php if(empty($movimientos)){ ?>
        <tr>
            <td colspan="4">No hay movimientos registrados</td>
        </tr>
    <?php } ?>

</tbody>
                </table>

            </div>


            <!-- PRODUCTOS CON POCO STOCK -->
            <div class="poco-stock">

                <h3>⚠ &nbsp; Productos con poco stock</h3>

                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Mínimo</th>
                        </tr>
                    </thead>

                    <tbody>

    <?php foreach($poco_stock as $p){ ?>

        <tr>
            <td>◈ &nbsp; <?= htmlspecialchars($p['nombre']) ?></td>
            <td class="negativo"><?= $p['stock'] ?></td>
            <td><?= $p['stock_minimo'] ?></td>
        </tr>

    <?php } ?>

    <?php if(empty($poco_stock)){ ?>

        <tr>
            <td colspan="3">No hay productos con poco stock</td>
        </tr>

    <?php } ?>

</tbody>
                </table>

            </div>

        </section>

    </main>

    <footer></footer>
