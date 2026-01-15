<?php
/*
    Alta de Categorías (comaltacat.php): dar de alta categorías de productos. El id_categoria 
    será un campo con el formato C-xxx donde xxx será un número secuencial que comienza en 1 
    completándose con 0 hasta completar el formato (este campo será calculado desde PHP). 
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

function generarNuevoIDC($conn)
{
    $sql = "SELECT id_categoria FROM categoria";
    $stmt = $conn->query($sql);

    $max_num = 0;

    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $num = intval(substr($fila['id_categoria'], 2));
        if ($num > $max_num) $max_num = $num;
    }

    return 'C-' . str_pad($max_num + 1, 3, '0', STR_PAD_LEFT);
}

function altaCategoria($conn, $nombre)
{
    $nuevo_id = generarNuevoIDC($conn);

    $stmt = $conn->prepare("INSERT INTO categoria (id_categoria, nombre)
                            VALUES (:id, :nom)");
    $stmt->bindParam(':id', $nuevo_id);
    $stmt->bindParam(':nom', $nombre);
    $stmt->execute();

    return $nuevo_id;
}

function formularioAltaCategoria()
{
    echo '<h1>Alta de Categorías</h1>
          <form method="POST" action="">
                <label>Nombre Categoría:</label>
                <input type="text" name="nombre" required><br><br>
                <input type="submit" value="Dar de alta categoría">
          </form>';
}
?>
