<?php
require_once "funciones_comaltaalm.php";

$conn = conectarBD();

if (!isset($_POST) || empty($_POST)) {
    formularioAltaAlmacen();
} else {
    $localidad = limpiar_campos($_POST['localidad']);

    try {
        $nuevo_id = altaAlmacen($conn, $localidad);
        echo "<p>Almacén dado de alta correctamente con ID: <strong>$nuevo_id</strong></p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    formularioAltaAlmacen();
}
?>
