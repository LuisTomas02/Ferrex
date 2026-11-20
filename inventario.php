
<?php
// Datos de ejemplo. Más adelante puedes reemplazarlos por datos de una base de datos.
$productos = [
    ["id" => 1, "nombre" => "Pintura 4 L", "categoria" => "Pinturas", "stock" => 2, "minimo" => 5, "precio" => 320.00],
    ["id" => 2, "nombre" => "Disco de corte", "categoria" => "Herramientas", "stock" => 4, "minimo" => 10, "precio" => 45.00],
    ["id" => 3, "nombre" => "Cemento 50 kg", "categoria" => "Materiales", "stock" => 6, "minimo" => 15, "precio" => 180.00],
    ["id" => 4, "nombre" => "Martillo 10 oz", "categoria" => "Herramientas", "stock" => 18, "minimo" => 5, "precio" => 95.00],
    ["id" => 5, "nombre" => "Tornillos 1 pulgada", "categoria" => "Materiales", "stock" => 25, "minimo" => 20, "precio" => 2.50]
];

$busqueda = trim($_GET["buscar"] ?? "");
$categoriaSeleccionada = $_GET["categoria"] ?? "Todas";
$estadoSeleccionado = $_GET["estado"] ?? "Todos";

$productosFiltrados = array_filter($productos, function ($producto) use ($busqueda, $categoriaSeleccionada, $estadoSeleccionado) {
    $coincideTexto = $busqueda === "" ||
        stripos($producto["nombre"], $busqueda) !== false ||
        stripos($producto["categoria"], $busqueda) !== false;

    $coincideCategoria = $categoriaSeleccionada === "Todas" ||
        $producto["categoria"] === $categoriaSeleccionada;

    $estado = $producto["stock"] <= $producto["minimo"] ? "Bajo" : "En stock";
    $coincideEstado = $estadoSeleccionado === "Todos" || $estado === $estadoSeleccionado;

    return $coincideTexto && $coincideCategoria && $coincideEstado;
});

$totalProductos = count($productos);
$productosEnStock = count(array_filter($productos, fn($p) => $p["stock"] > $p["minimo"]));
$productosStockBajo = count(array_filter($productos, fn($p) => $p["stock"] <= $p["minimo"]));
$productosAgotados = count(array_filter($productos, fn($p) => $p["stock"] == 0));

function e($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}
body {
    min-height: 100vh;
    background: #cbd6e4;
    color: #111827;
}
.topbar {
    min-height: 112px;
    background: #bd6800;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 25px;
    padding: 18px 4%;
}
.logo {
    width: 145px;
    min-height: 65px;
    background: #fff;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    color: #111;
    text-decoration: none;
    font-size: 25px;
    font-weight: 900;
    font-style: italic;
    letter-spacing: -1px;
    text-shadow: 1px 2px #aaa;
}
.logo-icon {
    font-size: 27px;
}
.buscador-superior {
    width: min(42%, 430px);
    height: 42px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 13px;
    background: #17243a;
    border: 1px solid #31425d;
    border-radius: 8px;
    color: #aab6c7;
}
.buscador-superior span {
    font-size: 23px;
}
.buscador-superior input {
    width: 100%;
    border: 0;
    outline: 0;
    color: white;
    background: transparent;
    font-size: 12px;
}
.buscador-superior input::placeholder {
    color: #9aa6b7;
}
.buscador-superior button {
    border: 0;
    color: #d5dbea;
    background: #26364f;
    padding: 5px 8px;
    border-radius: 3px;
    font-size: 10px;
    cursor: pointer;
}
.acciones-top {
    display: flex;
    align-items: center;
    gap: 20px;
}
.acciones-top button {
    border: 0;
    background: transparent;
    color: #080808;
    font-size: 31px;
    cursor: pointer;
}
.contenedor {
    width: min(1120px, 94%);
    margin: 0 auto;
    padding: 38px 15px 55px;
}
h1 {
    font-size: 27px;
    margin: 0 0 18px;
    font-weight: 800;
}
.resumen {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
    margin: 0 18px 28px;
}
.resumen-card {
    min-height: 75px;
    border-radius: 7px;
    padding: 13px 16px;
    display: flex;
    align-items: center;
    gap: 13px;
}
.resumen-icono {
    width: 32px;
    height: 32px;
    display: grid;
    place-items: center;
    font-size: 25px;
    font-weight: bold;
}
.resumen-card strong {
    display: block;
    font-size: 19px;
    margin-bottom: 4px;
}
.resumen-card small {
    display: block;
    font-size: 10px;
}
.azul { background: #edf4ff; color: #20334f; }
.azul .resumen-icono { color: #3479e8; }
.verde { background: #e4fbf2; color: #155c48; }
.verde .resumen-icono { color: white; background: #16b78a; border-radius: 50%; }
.rojo { background: #fff0f0; color: #8c2929; }
.rojo .resumen-icono { color: #ef4b52; }
.morado { background: #f4efff; color: #50318c; }
.morado .resumen-icono { color: #8857e8; }
.filtros {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;
    margin: 0 auto 22px;
}
.busqueda-tabla {
    width: 31%;
    height: 36px;
    background: white;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 0 10px;
    border: 1px solid #d9dee7;
}
.busqueda-tabla span {
    color: #64748b;
    font-size: 18px;
}
.busqueda-tabla input {
    width: 100%;
    border: 0;
    outline: 0;
    font-size: 11px;
}
.filtros select {
    height: 36px;
    min-width: 135px;
    padding: 0 9px;
    border: 1px solid #d9dee7;
    background: white;
    color: #263445;
    font-size: 11px;
}
.btn-filtro {
    height: 36px;
    min-width: 105px;
    border: 0;
    color: white;
    background: #2161df;
    cursor: pointer;
    font-size: 11px;
}
.btn-limpiar {
    color: #2459bd;
    font-size: 11px;
    text-decoration: none;
    padding: 8px 4px;
}
.tabla-contenedor {
    background: white;
    border: 1px solid #333;
    border-radius: 7px;
    padding: 22px 28px;
    min-height: 260px;
}
.tabla-scroll {
    overflow-x: auto;
}
table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
    font-size: 11px;
    text-align: center;
}
thead {
    background: #f7f9fc;
}
th {
    padding: 13px 8px;
    color: #263445;
    font-size: 10px;
    font-weight: 700;
}
td {
    padding: 17px 8px;
    border-bottom: 1px solid #edf0f4;
}
.nombre-producto {
    text-align: left;
    font-weight: 500;
}
.producto-imagen {
    width: 38px;
    height: 38px;
    margin: auto;
    display: grid;
    place-items: center;
    background: #eef2f7;
    color: #94a3b8;
    font-size: 23px;
}
.categoria {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 15px;
    background: #e0ebff;
    color: #3266b7;
    font-size: 9px;
}
.estado {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 15px;
    white-space: nowrap;
    font-size: 9px;
    font-weight: bold;
}
.bajo {
    color: #c83d42;
    background: #ffe4e4;
}
.correcto {
    color: #16844f;
    background: #dcf8e9;
}
.texto-rojo {
    color: #d43c43;
    font-weight: bold;
}
.texto-verde {
    color: #15945a;
    font-weight: bold;
}
.acciones-fila {
    white-space: nowrap;
}
.acciones-fila button {
    width: 29px;
    height: 29px;
    border: 0;
    border-radius: 5px;
    color: white;
    font-size: 16px;
    cursor: pointer;
    margin: 0 2px;
}
.editar { background: #2868e8; }
.eliminar { background: #ed454b; }
.sin-resultados {
    padding: 35px;
    color: #64748b;
}
.botones-inferiores {
    display: flex;
    gap: 10px;
    margin: 17px 30px;
}
.botones-inferiores button {
    min-height: 36px;
    padding: 0 14px;
    border-radius: 5px;
    font-size: 11px;
    cursor: pointer;
}
.btn-agregar {
    color: white;
    background: #0758d5;
    border: 1px solid #0758d5;
}
.btn-secundario {
    color: #2459a7;
    background: white;
    border: 1px solid #477ac4;
}
footer {
    height: 66px;
    background: #f49a08;
    width: 100%;
}
@media (max-width: 800px) {
    .topbar {
        flex-wrap: wrap;
    }

    .buscador-superior {
        order: 3;
        width: 100%;
    }

    .resumen {
        grid-template-columns: repeat(2, 1fr);
        margin-left: 0;
        margin-right: 0;
    }

    .filtros {
        flex-wrap: wrap;
    }

    .busqueda-tabla {
        width: 100%;
    }

    .filtros select {
        flex: 1;
    }

    .tabla-contenedor {
        padding: 15px;
    }
}
@media (max-width: 480px) {
    .contenedor {
        padding: 25px 5px 35px;
    }

    h1 {
        font-size: 23px;
    }

    .resumen {
        gap: 10px;
    }

    .resumen-card {
        padding: 10px;
        gap: 8px;
    }

    .resumen-card strong {
        font-size: 17px;
    }

    .botones-inferiores {
        margin: 15px 0;
        flex-wrap: wrap;
    }
}
    </style>
    <header class="topbar">
        <a class="logo" href="index.php" aria-label="Inicio FERREX">
            <img src="img/5a9908e5-2df3-405b-8a8a-36cd29a986eb.png" style="width: 200px; height: 100px;">
        </a>

        <form class="buscador-superior" method="get" action="index.php">
            <span>⌕</span>
            <input type="search" name="buscar" placeholder="Buscar en el sistema..." value="<?= e($busqueda) ?>">
            <button type="submit">Buscar</button>
        </form>

        <div class="acciones-top">
            <button type="button" aria-label="Notificaciones">🔔</button>
            <button type="button" aria-label="Configuración">⚙</button>
        </div>
    </header>

    <main class="contenedor">

        <section class="resumen">
            <article class="resumen-card azul">
                <div class="resumen-icono">◆</div>
                <div><strong><?= $totalProductos ?></strong><small>Productos en total</small></div>
            </article>
            <article class="resumen-card verde">
                <div class="resumen-icono">✓</div>
                <div><strong><?= $productosEnStock ?></strong><small>Productos en stock</small></div>
            </article>
            <article class="resumen-card rojo">
                <div class="resumen-icono">!</div>
                <div><strong><?= $productosStockBajo ?></strong><small>Productos con stock bajo</small></div>
            </article>
            <article class="resumen-card morado">
                <div class="resumen-icono">▮</div>
                <div><strong><?= $productosAgotados ?></strong><small>Productos agotados</small></div>
            </article>
        </section>

        <form class="filtros" method="get" action="index.php">
            <label class="busqueda-tabla">
                <span>⌕</span>
                <input type="search" name="buscar" placeholder="Buscar producto por nombre, SKU..." value="<?= e($busqueda) ?>">
            </label>

            <select name="categoria" aria-label="Filtrar por categoría">
                <?php foreach (["Todas", "Pinturas", "Herramientas", "Materiales"] as $categoria): ?>
                    <option value="<?= e($categoria) ?>" <?= $categoriaSeleccionada === $categoria ? "selected" : "" ?>>
                        <?= e($categoria === "Todas" ? "Todas las categorías" : $categoria) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="estado" aria-label="Filtrar por estado">
                <?php foreach (["Todos", "Bajo", "En stock"] as $estado): ?>
                    <option value="<?= e($estado) ?>" <?= $estadoSeleccionado === $estado ? "selected" : "" ?>>
                        <?= e($estado === "Todos" ? "Todos los estados" : ($estado === "Bajo" ? "Stock bajo" : $estado)) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button class="btn-filtro" type="submit">⚑ Filtros</button>
            <a class="btn-limpiar" href="index.php">Limpiar</a>
        </form>

        <section class="tabla-contenedor">
            <div class="tabla-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Stock<br>actual</th>
                            <th>Stock<br>mínimo</th>
                            <th>Estado</th>
                            <th>Precio venta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (count($productosFiltrados) > 0): ?>
                        <?php foreach ($productosFiltrados as $producto): ?>
                            <?php $stockBajo = $producto["stock"] <= $producto["minimo"]; ?>
                            <tr>
                                <td><?= e($producto["id"]) ?></td>
                                <td><div class="producto-imagen">◉</div></td>
                                <td class="nombre-producto"><?= e($producto["nombre"]) ?></td>
                                <td><span class="categoria"><?= e($producto["categoria"]) ?></span></td>
                                <td class="<?= $stockBajo ? "texto-rojo" : "texto-verde" ?>"><?= e($producto["stock"]) ?></td>
                                <td><?= e($producto["minimo"]) ?></td>
                                <td>
                                    <?php if ($stockBajo): ?>
                                        <span class="estado bajo">▲ Stock bajo</span>
                                    <?php else: ?>
                                        <span class="estado correcto">● En stock</span>
                                    <?php endif; ?>
                                </td>
                                <td>$<?= number_format($producto["precio"], 2) ?></td>
                                <td class="acciones-fila">
                                    <button type="button" class="editar" title="Editar (demostración)">✎</button>
                                    <button type="button" class="eliminar" title="Eliminar (demostración)">▣</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="9" class="sin-resultados">No se encontraron productos con esos filtros.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <div class="botones-inferiores">
            <button type="button" class="btn-agregar" onclick="alert('Aquí puedes conectar el formulario para agregar productos.')">＋ Agregar producto</button>
            <button type="button" class="btn-secundario" onclick="alert('La función de importar se puede conectar después.')">⇧ Importar</button>
            <button type="button" class="btn-secundario" onclick="window.print()">▤ Exportar / Imprimir</button>
        </div>
    </main>

    <footer></footer>
</body>
</html>
