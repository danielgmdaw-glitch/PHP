<?php
/*
    Alta de Almacenes (comaltaalm.php): dar de alta almacenes en diferentes localidades. 
    El número de almacén será un número secuencial.
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

function generarNuevoIDA($conn)
{
    $sql = "SELECT MAX(num_almacen) FROM almacen";
    $stmt = $conn->query($sql);
    $max_id = $stmt->fetchColumn();

    return ($max_id) ? $max_id + 1 : 1;
}

function altaAlmacen($conn, $localidad)
{
    $nuevo_id = generarNuevoIDA($conn);

    $stmt = $conn->prepare("INSERT INTO almacen (num_almacen, localidad)
                            VALUES (:id, :loc)");
    $stmt->bindParam(':id', $nuevo_id);
    $stmt->bindParam(':loc', $localidad);
    $stmt->execute();

    return $nuevo_id;
}

function formularioAltaAlmacen()
{
    echo '<h1>Alta de Almacenes</h1>
          <form method="POST" action="">
                <label>Localidad:</label><br>
                <input type="text" name="localidad" required><br><br>
                <input type="submit" value="Dar de alta">
          </form>';
}
?>
