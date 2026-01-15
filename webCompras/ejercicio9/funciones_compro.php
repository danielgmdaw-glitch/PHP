<?php
/*
    Compra de Productos (compro.php): el cliente podrá realizar la compra de un solo producto 
    siempre que haya disponibilidad del mismo. 
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

function obtenerNIFClientes($conn)
{
    $sql = "SELECT nif FROM cliente";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerProductos($conn)
{
    $sql = "SELECT id_producto, nombre FROM producto";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function formularioCompra($clientes, $productos)
{
    echo '<h1>Realizar Compra</h1>
    <form method="POST" action="">
        
        <label>NIF Cliente:</label>
        <select name="nif">';
    
    foreach ($clientes as $c) {
        echo '<option value="'.$c['nif'].'">'.$c['nif'].'</option>';
    }

    echo '</select><br><br>';

    echo '<label>Producto:</label>
          <select name="id_producto">';

    foreach ($productos as $p) {
        echo '<option value="'.$p['id_producto'].'">'.$p['id_producto'].' - '.$p['nombre'].'</option>';
    }

    echo '</select><br><br>';

    echo '<label>Cantidad:</label>
          <input type="number" name="cantidad" min="1" required><br><br>';

    echo '<input type="submit" value="Comprar">
        </form>';
}

function obtenerStockTotal($conn, $id_producto) 
{
    //para obtener el stock total de un producto
    $sql = "SELECT SUM(cantidad) AS total FROM almacena WHERE id_producto = :id_producto";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->execute();

    // Obtenemos el resultado
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    // Comprobamos si existe un valor total
    if ($fila && isset($fila['total'])) 
    {
        return $fila['total'];
    } else {
        return 0; // Si no hay filas o total es NULL, devolvemos 0
    }
}

function registrarCompra($conn, $nif, $id_producto, $cantidad)
{
    // Obtener la fecha actual 
    $fecha = date('Y-m-d'); // Formato YYYY-MM-DD

    $sql = "INSERT INTO compra (fecha_compra, id_producto, nif, unidades)
            VALUES (:fecha_compra, :id_producto, :nif, :cantidad)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fecha_compra', $fecha);
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->bindParam(':nif', $nif);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->execute();
}

function descontarStock($conn, $id_producto, $cantidadNecesaria)
{
    // Cogemos almacenes ordenados por número (del menor al mayor)
    $sql = "SELECT num_almacen, cantidad 
            FROM almacena 
            WHERE id_producto = :id_producto
            ORDER BY num_almacen ASC";
            
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_producto', $id_producto);
    $stmt->execute();
    $almacenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($almacenes as $alm) 
    {
        if ($cantidadNecesaria <= 0) 
        {
            break; // Ya hemos descontado toda la cantidad necesaria
        }

        //min asegura que solo se descuente hasta lo que hay disponible en cada almacén, sino saldria negativo
        $restar = min($alm['cantidad'], $cantidadNecesaria);// min($cantidad en almacén, cantidad necesaria)
        /*
        Ejemplo:
        -En el primer almacén (1), min(10, 20) -> 10 se descuentan
        -Se actualiza el almacén 1 (cantidad = 10 - 10 = 0)
        -cantidadNecesaria se actualiza: 20 - 10 = 10
        -En el segundo almacén (2), min(15, 10) -> 10 se descuentan
        -Se actualiza el almacén 2 (cantidad = 15 - 10 = 5)
        -cantidadNecesaria ahora es 10 - 10 = 0 -> ya no hace falta descontar más
        */

        $actualizarSQL = "UPDATE almacena
                      SET cantidad = cantidad - :restar
                      WHERE num_almacen = :num_almacen AND id_producto = :id_producto";

        $update = $conn->prepare($actualizarSQL);//prepare($actualizarSQL) hace la consulta ya actualizada
        $update->bindParam(':restar', $restar);
        $update->bindParam(':num_almacen', $alm['num_almacen']);
        $update->bindParam(':id_producto', $id_producto);
        $update->execute();

        $cantidadNecesaria -= $restar;
    }
}
?>