<?php
require_once "funciones_comconstock.php";

$conn = conectarBD();

if (!isset($_POST) || empty($_POST)) {
    $producto = obtenerProductos($conn);
    formularioConsultaStock($producto);

} else {
    $producto = limpiar_campos($_POST['producto']);

    try {
        $stock = obtenerStockPorProducto($conn, $producto);

        // Volvemos a cargar listado para el formulario
        $producto = obtenerProductos($conn);
        formularioConsultaStock($producto);

        echo "<h2>Stock del producto seleccionado</h2>";

        if (empty($stock)) {
            echo "<p>No hay stock registrado para este producto.</p>";
        } else {
            echo "<table border='1' cellpadding='5'>
                    <tr>
                        <th>Almacén</th>
                        <th>Cantidad</th>
                    </tr>";
            foreach ($stock as $fila) {
                echo "<tr>
                        <td>{$fila['num_almacen']}</td>
                        <td>{$fila['cantidad']}</td>
                      </tr>";
            }
            echo "</table>";
        }

    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>