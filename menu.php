<?php
session_start();
if(!isset($_SESSION['nombre_completo'])){
    header('location: login.php');
}

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Notas</title>
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
        </div>

    </header>


    <!-- CONTENIDO PRINCIPAL -->
    <main>

        <h2>¿Qué vas a hacer hoy?</h2>

        <!-- OPCIONES DEL SISTEMA -->
        <section class="opciones">

            <a href="#" class="tarjeta inventario">
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

            <a href="#" class="tarjeta productos">
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
                        <tr>
                            <td>26/04/2026</td>
                            <td><span class="etiqueta entrada-t">Entrada</span></td>
                            <td>Tornillos 1"</td>
                            <td class="positivo">+100</td>
                        </tr>

                        <tr>
                            <td>26/04/2026</td>
                            <td><span class="etiqueta salida-t">Salida</span></td>
                            <td>Martillo 10 oz</td>
                            <td class="negativo">-3</td>
                        </tr>

                        <tr>
                            <td>26/04/2026</td>
                            <td><span class="etiqueta entrada-t">Entrada</span></td>
                            <td>Cemento 50 kg</td>
                            <td class="positivo">+20</td>
                        </tr>

                        <tr>
                            <td>26/04/2026</td>
                            <td><span class="etiqueta salida-t">Salida</span></td>
                            <td>Pintura 4 L</td>
                            <td class="negativo">-5</td>
                        </tr>

                        <tr>
                            <td>26/04/2026</td>
                            <td><span class="etiqueta entrada-t">Entrada</span></td>
                            <td>Clavos 2"</td>
                            <td class="positivo">+200</td>
                        </tr>
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
                        <tr>
                            <td>◈ &nbsp; Pintura 4 L</td>
                            <td class="negativo">2</td>
                            <td>5</td>
                        </tr>

                        <tr>
                            <td>◈ &nbsp; Disco de corte</td>
                            <td class="negativo">4</td>
                            <td>10</td>
                        </tr>

                        <tr>
                            <td>◈ &nbsp; Cemento 50 kg</td>
                            <td class="negativo">6</td>
                            <td>15</td>
                        </tr>

                        <tr>
                            <td>◈ &nbsp; Tornillos 1"</td>
                            <td class="negativo">5</td>
                            <td>20</td>
                        </tr>

                        <tr>
                            <td>◈ &nbsp; Taladro 3/8"</td>
                            <td class="negativo">1</td>
                            <td>5</td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </section>

    </main>

    <footer></footer>
