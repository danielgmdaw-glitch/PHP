<?php
require_once "funciones_comconsalm.php";

$conn = conectarBD();

if (!isset($_POST) || empty($_POST)) {
    $almacen = obtenerAlmacen($conn);
    formularioConsultaProductos($almacen);

} else {
    $almacen = limpiar_campos($_POST['almacen']);

    try {
        $productos = obtenerProductosPorAlmacen($conn, $almacen);

        // Volvemos a cargar listado para el formulario
        $almacen = obtenerAlmacen($conn);
        formularioConsultaProductos($almacen);

        echo "<h2>Productos del almacen seleccionado</h2>";

        if (empty($productos)) {
            echo "<p>No hay productos registrados para este almacen.</p>";
        } else {
            echo "<table border='1' cellpadding='5'>
                    <tr>
                        <th>Almacén</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                    </tr>";
            foreach ($productos as $fila) {
                echo "<tr>
                        <td>{$fila['num_almacen']}</td>
                        <td>{$fila['nombre']}</td>
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