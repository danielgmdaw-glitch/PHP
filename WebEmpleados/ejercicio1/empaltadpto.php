<?php
/*
Programar un formulario empaltadpto.html/empaltadpto.php que permita dar de alta 
departamentos. El código del departamento tendrá el formato DxxxN (‘D001’, ‘D002’ …) y se 
obtendrá automáticamente.
*/
$servername = "localhost";
$username = "root";
$password = "rootroot";     
$dbname = "empleados";

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

    $nombre_dpto = trim($_POST['nombre_dpto']);

    try {
        //iniciar transacción
        $conn->beginTransaction();

        $nuevo_cod = generarNuevoCodDpto($conn);

        $stmt = $conn->prepare("INSERT INTO departamento (cod_dpto, nombre_dpto)
                                VALUES (:cod_dpto, :nombre_dpto)");

        $stmt->bindParam(':cod_dpto', $nuevo_cod);
        $stmt->bindParam(':nombre_dpto', $nombre_dpto);

        $stmt->execute();

        //confirmar la transacción
        $conn->commit();

        echo "<p>Departamento dado de alta correctamente con Código: <strong>$nuevo_cod</strong></p>";

    } catch (PDOException $e) {
        //si hay error, deshacer la transacción
        $conn->rollBack();

        echo "<p>Error: " . $e->getMessage() . "</p>";
    
        echo "<p>Código de error: " . $e->getCode() . "</p>";
    }

    // Vuelve a mostrar el formulario después de insertar
    mostrarFormulario($conn);
}

function generarNuevoCodDpto($conn) 
{
    $sql = "SELECT MAX(cod_dpto) FROM departamento";
    $stmt = $conn->query($sql);
    $max_cod = $stmt->fetchColumn();//fetchColumn obtiene el valor de la primera columna de la primera fila del conjunto de resultados

    if ($max_cod) {
        $num = intval(substr($max_cod, 1)) + 1; // Extraer la parte numérica y sumar 1
    } else {
        $num = 1; // Si no hay departamentos, empezar desde 1
    }
    return 'D' . str_pad($num, 3, '0', STR_PAD_LEFT); // Formatear con ceros a la izquierda
}

function mostrarFormulario($conn) 
{
    echo '<h1>Alta de Departamentos</h1>';
    echo '<form method="post" action="">';
    echo '<label for="nombre_dpto">Nombre del Departamento:</label><br>';
    echo '<input type="text" id="nombre_dpto" name="nombre_dpto" required><br><br>';
    echo '<input type="submit" value="Dar de Alta">';
    echo '</form>';
}




?>