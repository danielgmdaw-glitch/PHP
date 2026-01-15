<?php
/*
    Alta de Productos (comaltapro.php): dar de alta productos. Para seleccionar la categoría del 
    producto, se utilizará una lista de valores con los nombres de las categorías. El id_producto 
    será un campo con el formato Pxxxx donde xxxx será un número secuencial que comienza en 
    1 completándose con 0 hasta completar el formato (este campo será calculado desde PHP). 
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

function generarNuevoIDP($conn)
{
    $sql = "SELECT MAX(id_producto) FROM producto";
    $stmt = $conn->query($sql);
    $max_id = $stmt->fetchColumn();

    if ($max_id) {
        $num = intval(substr($max_id, 1)) + 1;
    } else {
        $num = 1;
    }

    return 'P' . str_pad($num, 4, '0', STR_PAD_LEFT);
}

function obtenerCategorias($conn)
{
    $sql = "SELECT id_categoria, nombre FROM categoria";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function altaProducto($conn, $nombre, $precio, $categoria)
{
    $nuevo_id = generarNuevoIDP($conn);

    $stmt = $conn->prepare("INSERT INTO producto (id_producto, nombre, precio, id_categoria)
                            VALUES (:id, :nom, :pre, :cat)");

    $stmt->bindParam(':id', $nuevo_id);
    $stmt->bindParam(':nom', $nombre);
    $stmt->bindParam(':pre', $precio);
    $stmt->bindParam(':cat', $categoria);

    $stmt->execute();
    return $nuevo_id;
}

function formularioAltaProducto($categorias)
{
    echo '<h1>Alta de Productos</h1>
          <form method="POST" action="">
                <label>Nombre:</label><br>
                <input type="text" name="nombre" required><br><br>

                <label>Precio:</label><br>
                <input type="number" step="0.01" name="precio" required><br><br>

                <label>Categoría:</label><br>
                <select name="categoria" required>';

    foreach ($categorias as $cat) {
        echo '<option value="' . $cat['id_categoria'] . '">' .
             htmlspecialchars($cat['nombre']) .
             '</option>';
    }

    echo '</select><br><br>
          <input type="submit" value="Dar de alta">
          </form>';
}
?>
