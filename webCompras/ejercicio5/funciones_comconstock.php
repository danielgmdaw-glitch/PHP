<?php
/*
    Consulta de Stock (comconstock.php): se mostrarán los productos en un desplegable y se 
    mostrará la cantidad disponible del producto seleccionado en cada uno de los almacenes.
*/

function conectarBD()
{ 
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname = "comprasweb";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function limpiar_campos($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function obtenerProductos($conn)
{
    $sql = "SELECT id_producto, nombre FROM producto";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerStockPorProducto($conn, $producto)
{
    $sql = "SELECT a.num_almacen, al.cantidad 
            FROM almacen a, almacena al
            where al.num_almacen = a.num_almacen AND al.id_producto = :producto";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':producto', $producto);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function formularioConsultaStock($producto)
{
    echo '<h1>Consulta de Stock</h1>
          <form method="POST" action="">
              <label for="producto">Producto:</label>
              <select name="producto" id="producto">';

    foreach ($producto as $prod) {
        echo '<option value="' . $prod['id_producto'] . '">' . $prod['nombre'] . '</option>';
    }

    echo '</select>
              <input type="submit" value="Consultar Stock">
          </form>';
}


?>