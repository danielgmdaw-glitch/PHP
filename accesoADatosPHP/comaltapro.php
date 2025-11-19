<?php

/*Alta de Productos (comaltapro.php): dar de alta productos. Para seleccionar la categoría del 
producto, se utilizará una lista de valores con los nombres de las categorías. El id_producto 
será un campo con el formato Pxxxx donde xxxx será un número secuencial que comienza en 
1 completándose con 0 hasta completar el formato (este campo será calculado desde PHP). */
$servername = "localhost";
$username = "root";
$password = "rootroot";     
$dbname = "comprasweb";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if (!isset($_POST) || empty($_POST)) // Si no se han enviado datos, mostrar el formulario
{
    mostrarFormulario($conn);
} else {

    $nombre = trim($_POST['nombre']);
    $precio = floatval($_POST['precio']);
    $categoria = $_POST['categoria'];

    try {
        $nuevo_id = generarNuevoIDP($conn);

        $stmt = $conn->prepare("INSERT INTO producto (id_producto, nombre, precio, id_categoria)
                                VALUES (:id_producto, :nombre, :precio, :id_categoria)");

        //bindParam vincula un parámetro de la consulta SQL con una variable de PHP
        $stmt->bindParam(':id_producto', $nuevo_id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':id_categoria', $categoria);

        $stmt->execute();

        echo "<p>Producto dado de alta correctamente con ID: <strong>$nuevo_id</strong></p>";

    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    // Vuelve a mostrar el formulario después de insertar
    mostrarFormulario($conn);
}

function generarNuevoIDP($conn) 
{
    $sql = "SELECT MAX(id_producto) FROM producto";
    $stmt = $conn->query($sql);
    $max_id = $stmt->fetchColumn();//fetchColumn obtiene el valor de la primera columna de la primera fila del conjunto de resultados

    if ($max_id) {
        $num = intval(substr($max_id, 1)) + 1; // Extraer la parte numérica y sumar 1
    } else {
        $num = 1; // Si no hay productos, empezar desde 1
    }
    return 'P' . str_pad($num, 4, '0', STR_PAD_LEFT); // Formatear con ceros a la izquierda
}

function mostrarFormulario($conn) 
{
    echo '<h1>Alta de Productos</h1>';
    echo '<form method="post" action="">';
    echo    '<label for="nombre">Nombre:</label><br>';
    echo    '<input type="text" id="nombre" name="nombre" required><br><br>';

    echo    '<label for="precio">Precio:</label><br>';
    echo    '<input type="number" step="0.01" id="precio" name="precio" required><br><br>';

    echo    '<label for="categoria">Categoría:</label><br>';
    echo    '<select id="categoria" name="categoria" required>';

    // Obtener categorías
    $sql = "SELECT id_categoria, nombre FROM categoria";
    $stmt = $conn->query($sql);

    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) ////fila = $stmt->fetch() devuelve la siguiente fila del conjunto de resultados
    {
        echo '<option value="' . $fila['id_categoria'] . '">' . htmlspecialchars($fila['nombre']) . '</option>';
    }

    echo    '</select><br><br>';
    echo    '<input type="submit" value="Dar de alta">';
    echo '</form>';
}


?>