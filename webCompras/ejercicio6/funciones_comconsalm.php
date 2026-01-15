<?php
/*
    Consulta de Almacenes (comconsalm.php): se mostrarán los almacenes en un desplegable 
    y se mostrará la información de los productos disponibles en el almacén seleccionado. 
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

function obtenerAlmacen($conn)
{
    $sql = "SELECT num_almacen FROM almacen";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerProductosPorAlmacen($conn, $almacen)
{
    $sql = "SELECT a.num_almacen, p.nombre, al.cantidad 
            FROM almacen a, almacena al, producto p
            WHERE al.num_almacen = a.num_almacen 
              AND al.id_producto = p.id_producto 
              AND a.num_almacen = :almacen";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':almacen', $almacen);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function formularioConsultaProductos($almacen)
{
    echo '<h1>Consulta de Productos por Almacen</h1>
            <form method="POST" action="">
                <label for="almacen">Almacén:</label>
                <select name="almacen" id="almacen">';
    foreach ($almacen as $alm) {
        echo '<option value="' . $alm['num_almacen'] . '">' . $alm['num_almacen'] . '</option>';
    }
    echo '</select>
              <input type="submit" value="Consultar Productos">
          </form>';
}


?>