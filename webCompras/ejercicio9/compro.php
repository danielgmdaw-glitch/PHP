<?php
require_once "funciones_compro.php";

$conn = conectarBD();

if (!isset($_POST) || empty($_POST)) {
    $clientes = obtenerNIFClientes($conn);
    $productos = obtenerProductos($conn);

    formularioCompra($clientes, $productos);

} else {

    $nif = limpiar_campos($_POST['nif']);
    $id_producto = limpiar_campos($_POST['id_producto']);
    $cantidad = limpiar_campos($_POST['cantidad']);

    try {
        //Verificamos la disponibilidad total
        $disponibles = obtenerStockTotal($conn, $id_producto);

        if ($disponibles < $cantidad) {
            echo "<h3 style='color:red'>No hay stock suficiente. Disponibles: $disponibles</h3>";
            $clientes = obtenerNIFClientes($conn);
            $productos = obtenerProductos($conn);
            formularioCompra($clientes, $productos);
            exit;
        }

        registrarCompra($conn, $nif, $id_producto, $cantidad);

        descontarStock($conn, $id_producto, $cantidad);

        echo "<h2>Compra realizada con éxito</h2>";
        echo "<p>Producto: $id_producto<br>Cantidad comprada: $cantidad</p>";

        $clientes = obtenerNIFClientes($conn);
        $productos = obtenerProductos($conn);
        formularioCompra($clientes, $productos);

    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>
