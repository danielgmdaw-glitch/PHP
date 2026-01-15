<?php

/*Alta de Productos (comaltapro.php): dar de alta productos. Para seleccionar la categoría del 
producto, se utilizará una lista de valores con los nombres de las categorías. El id_producto 
será un campo con el formato Pxxxx donde xxxx será un número secuencial que comienza en 
1 completándose con 0 hasta completar el formato (este campo será calculado desde PHP). */
require_once "funciones_comaltapro.php";

$conn = conectarBD();

if (!isset($_POST) || empty($_POST)) {
    $categorias = obtenerCategorias($conn);
    formularioAltaProducto($categorias);

} else {
    $nombre = limpiar_campos($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $categoria = $_POST['categoria'];

    try {
        $nuevo_id = altaProducto($conn, $nombre, $precio, $categoria);
        echo "<p>Producto dado de alta correctamente con ID: <strong>$nuevo_id</strong></p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    $categorias = obtenerCategorias($conn);
    formularioAltaProducto($categorias);
}
?>
