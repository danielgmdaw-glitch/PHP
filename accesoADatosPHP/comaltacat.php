<h1>Alta de Categorías</h1>
<?php
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
    mostrarFormulario();
} else {

    $nombre = trim($_POST['nombre']);

    try {
        $nuevo_id = generarNuevoIDC($conn);

        $stmt = $conn->prepare("INSERT INTO categoria (id_categoria, nombre) VALUES (:id_categoria, :nombre)");
        $stmt->bindParam(':id_categoria', $nuevo_id);
        $stmt->bindParam(':nombre', $nombre);

        $stmt->execute();

        echo "<p>Categoría dada de alta correctamente con ID: <strong>$nuevo_id</strong></p>";

    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    // Vuelve a mostrar el formulario después de insertar
    mostrarFormulario();
}

// Genera el siguiente ID_CATEGORIA en formato C-XXX
function generarNuevoIDC($conn) 
{
    $sql = "SELECT id_categoria FROM categoria";
    $stmt = $conn->query($sql);//query ejecuta directamente la consulta sin necesidad de preparar

    $max_num = 0;

    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) //fetch() obtiene una fila del resultado de la consulta SQL.
    {//PDO::FETCH_ASSOC indica que devolverá la fila como array asociativo, donde las claves son los nombres de las columnas (por ejemplo ['id_categoria' => 'C-005']).
        $num = intval(substr($fila['id_categoria'], 2));//Extrae la parte numérica del ID_CATEGORIA (después de "C-") y la convierte a entero con intval
        if ($num > $max_num) 
        {
            $max_num = $num;
        }
    }

    $nuevo_num = $max_num + 1;
    $nuevo_id = 'C-' . str_pad($nuevo_num, 3, '0', STR_PAD_LEFT);//str_pad rellena el número con ceros a la izquierda para que tenga 3 dígitos
    return $nuevo_id;
}

// Muestra el formulario
function mostrarFormulario() 
{
    echo '<form action="" method="post">
            <div>
                <label for="nombre">Nombre Categoría:</label>
                <input type="text" name="nombre" required>
            </div>
            <br>
            <div>
                <input type="submit" value="Dar de alta categoría">
            </div>
          </form>';
}
?>
