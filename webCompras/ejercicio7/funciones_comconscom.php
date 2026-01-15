<?php
/*
    Consulta de Compras (comconscom.php): se mostrarán en un desplegable los NIF de los 
    clientes, una fecha desde y una fecha hasta. Se mostrará por pantalla la información de las 
    compras realizadas por los clientes en ese periodo (producto, nombre producto, precio compra) 
    así como el montante total de todas las compras.
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

function obtenerComprasPorClienteYFecha($conn, $nif, $fecha_desde, $fecha_hasta)
{
    $sql = "SELECT c.id_producto, p.nombre, (p.precio * c.unidades) AS precio_compra
            FROM compra c, producto p
            WHERE c.id_producto = p.id_producto 
              AND c.nif = :nif 
              AND c.fecha_compra BETWEEN :fecha_desde AND :fecha_hasta";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nif', $nif);
    $stmt->bindParam(':fecha_desde', $fecha_desde);
    $stmt->bindParam(':fecha_hasta', $fecha_hasta);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function formularioConsultaCompras($nifs)
{
    echo '<h1>Consulta de Compras por Cliente y Fecha</h1>
            <form method="POST" action="">
                <label for="nif">NIF Cliente:</label>
                <select name="nif" id="nif">';
    foreach ($nifs as $nif) {
        echo '<option value="' . $nif['nif'] . '">' . $nif['nif'] . '</option>';
    }
    echo '</select><br><br>
                <label for="fecha_desde">Fecha Desde:</label>
                <input type="date" name="fecha_desde" id="fecha_desde" required><br><br>
                <label for="fecha_hasta">Fecha Hasta:</label>
                <input type="date" name="fecha_hasta" id="fecha_hasta" required><br><br>
                <input type="submit" value="Consultar">
            </form>';
}





?>