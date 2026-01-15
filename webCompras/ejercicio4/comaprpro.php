<?php
require_once "funciones_comaprpro.php";

$conn = conectarBD();

if (!isset($_POST) || empty($_POST)) {
    $producto = obtenerProductos($conn);
    $almacen = obtenerNumAlmacen($conn);
    formularioAprovProductos($producto, $almacen);
} else {
    $producto = $_POST['producto'];
    $almacen = $_POST['almacen'];
    $cantidad = limpiar_campos($_POST['cantidad']);

    try {
        aprovisionarProducto($conn, $producto, $almacen, $cantidad);
        echo "<p>Producto con la cantidad <strong>$cantidad</strong> aprovisionado correctamente en el almacén.</p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    $producto = obtenerProductos($conn);
    $almacen = obtenerNumAlmacen($conn);
    formularioAprovProductos($producto, $almacen);
}
?>
