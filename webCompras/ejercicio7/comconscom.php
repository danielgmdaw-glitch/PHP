<?php
require_once "funciones_comconscom.php";

$conn = conectarBD();

if (!isset($_POST) || empty($_POST)) {
    $compras = obtenerNIFClientes($conn);
    formularioConsultaCompras($compras);
} else {
    $nif = limpiar_campos($_POST['nif']);
    $fecha_desde = limpiar_campos($_POST['fecha_desde']);
    $fecha_hasta = limpiar_campos($_POST['fecha_hasta']);

    try {
        $compras = obtenerComprasPorClienteYFecha($conn, $nif, $fecha_desde, $fecha_hasta);

        // Volvemos a cargar listado para el formulario
        $nifs = obtenerNIFClientes($conn);
        formularioConsultaCompras($nifs);

        echo "<h2>Compras del cliente seleccionado en el periodo indicado</h2>";

        if (empty($compras)) {
            echo "<p>No hay compras registradas para este cliente en el periodo indicado.</p>";
        } else {
            $total = 0;
            echo "<table border='1' cellpadding='5'>
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre Producto</th>
                        <th>Precio Producto</th>
                    </tr>";
            foreach ($compras as $fila) {
                echo "<tr>
                        <td>{$fila['id_producto']}</td>
                        <td>{$fila['nombre']}</td>
                        <td>{$fila['precio_compra']}</td>
                      </tr>";
                $total += $fila['precio_compra'];
            }
            echo "</table>";
            echo "<h3>Montante total de las compras: " . number_format($total, 2) . " €</h3>";
        }

    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
}
?>