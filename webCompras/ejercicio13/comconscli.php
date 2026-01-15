<?php
session_start();
require_once "funciones_comconscli.php";

//Comprobamos que el cliente ha iniciado sesión, esto sirve para evitar accesos directos si en un navegador ponemos la URL
if (!isset($_SESSION['nif'])) {
    die("Acceso no permitido. Debe iniciar sesión.");
}
$nif = $_SESSION['nif'];


$conn = conectarBD();

//!isset($_POST) || empty($_POST) quiere decir que 
if (!isset($_POST) || empty($_POST)) {
    formularioConsultaCompras();
} else {
    $fecha_desde = limpiar_campos($_POST['fecha_desde']);
    $fecha_hasta = limpiar_campos($_POST['fecha_hasta']);

    try {
        $compras = obtenerComprasPorClienteYFecha($conn, $nif, $fecha_desde, $fecha_hasta);

        // Volvemos a cargar listado para el formulario
        formularioConsultaCompras();

        echo "<h2>Compras del cliente logueado en el periodo indicado</h2>";

        if (empty($compras)) {
            echo "<p>No hay compras registradas para este cliente en el periodo indicado.</p>";
        } else {
            $total = 0;
            echo "<table border='1' cellpadding='5'>
                    <tr>
                        <th>Fecha Compra</th>
                        <th>ID Producto</th>
                        <th>Nombre Producto</th>
                        <th>Precio Producto</th>
                        <th>Unidades</th>
                        <th>Precio Total</th>
                    </tr>";
            foreach ($compras as $fila) {
                echo "<tr>
                        <td>{$fila['fecha_compra']}</td>
                        <td>{$fila['id_producto']}</td>
                        <td>{$fila['nombre']}</td>
                        <td>{$fila['precio']}</td>
                        <td>{$fila['unidades']}</td>
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