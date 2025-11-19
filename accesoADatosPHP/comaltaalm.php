<?php
/*Alta de Almacenes (comaltaalm.php): dar de alta almacenes en diferentes localidades. El 
número de almacén será un número secuencial. */

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
 
    $localidad = trim($_POST['localidad']);

    try {
        $nuevo_id = generarNuevoIDA($conn);

        $stmt = $conn->prepare("INSERT INTO almacen (num_almacen, localidad)
                                VALUES (:num_almacen, :localidad)");

        $stmt->bindParam(':num_almacen', $nuevo_id);
        $stmt->bindParam(':localidad', $localidad);

        $stmt->execute();

        echo "<p>Almacén dado de alta correctamente con ID: <strong>$nuevo_id</strong></p>";

    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    // Vuelve a mostrar el formulario después de insertar
    mostrarFormulario($conn);
}

function generarNuevoIDA($conn) 
{
    $sql = "SELECT MAX(num_almacen) FROM almacen";
    $stmt = $conn->query($sql);
    $max_id = $stmt->fetchColumn();

    if ($max_id) {
        $nuevo_id = $max_id + 1; // Sumar 1 al máximo ID existente
    } else {
        $nuevo_id = 1; // Si no hay almacenes, empezar en 1
    }

    return $nuevo_id;
}

function mostrarFormulario($conn) 
{
    echo '<h1>Alta de Almacenes</h1>';
    echo '<form method="POST" action="">';
    echo    '<label for="localidad">Localidad:</label><br>';
    echo    '<input type="text" id="localidad" name="localidad" required><br><br>';
    echo    '<input type="submit" value="Dar de alta">';
    echo '</form>';
}

?>