<?php
require_once "funciones_comaltcat.php";

$conn = conectarBD();

if (!isset($_POST) || empty($_POST)) {
    formularioAltaCategoria();
} else {
    $nombre = limpiar_campos($_POST['nombre']);

    try {
        $nuevo_id = altaCategoria($conn, $nombre);
        echo "<p>Categoría dada de alta correctamente con ID: <strong>$nuevo_id</strong></p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    formularioAltaCategoria();
}
?>
