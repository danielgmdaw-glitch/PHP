<?php
/*Realizar un programa en php empaltaemp.php que permita dar de alta un empleado en la 
empresa. Para seleccionar el departamento, al que se asignará al empleado inicialmente, se 
utilizará una lista de valores con los nombres de los departamentos de la empresa.*/

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
    $dni = trim($_POST['dni']);
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $fecha_nac = $_POST['fecha_nac'];
    $salario = floatval($_POST['salario']);
    $departamento = $_POST['departamento'];

    // DNI con 8 numero y 1 letra al final
    if (!preg_match('/^[0-9]{8}[A-Za-z]$/', $dni)) //preg_match sirve para comprobar si una cadena cumple un patrón usando expresiones regulares (regex)
    {
        echo "<p style='color:red;'>ERROR: El DNI debe tener 8 números y una letra al final.</p>";
        mostrarFormulario($conn);
        exit();
    }

    try {
        // Iniciar transacción
        $conn->beginTransaction();

        $stmt = $conn->prepare("INSERT INTO empleado (dni, nombre, apellidos, fecha_nac, salario)
                                VALUES (:dni, :nombre, :apellidos, :fecha_nac, :salario)");

        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':fecha_nac', $fecha_nac);
        $stmt->bindParam(':salario', $salario);

        $stmt->execute();

        // PAra que la fecha de inicio del empleado sea el dia de hoy
        $fecha_hoy = date("Y-m-d");
        
        $stmt2 = $conn->prepare("INSERT INTO emple_depart (dni, cod_dpto, fecha_ini, fecha_fin)
                                 VALUES (:dni, :cod_dpto, :fecha_ini, NULL)");

        $stmt2->bindParam(':dni', $dni);
        $stmt2->bindParam(':cod_dpto', $departamento);
        $stmt2->bindParam(':fecha_ini', $fecha_hoy);

        $stmt2->execute();

        // Confirmar transacción
        $conn->commit();

        echo "<p>Empleado con DNI: <strong>$dni</strong> dado de alta correctamente.</p>";

    } catch (PDOException $e) {
        // Deshacer transacción si hay error
        $conn->rollBack();

        echo "<p>Error: " . $e->getMessage() . "</p>";
        echo "<p>Código de error: " . $e->getCode() . "</p>";
    }

    // Volver a mostrar formulario
    mostrarFormulario($conn);
}

function mostrarFormulario($conn) 
{
    echo '<h1>Alta de Empleados</h1>';
    echo '<form method="post" action="">';

    echo '<label>DNI:</label><br>';
    echo '<input type="text" name="dni" maxlength="9" required><br><br>';

    echo '<label>Nombre:</label><br>';
    echo '<input type="text" name="nombre" required><br><br>';

    echo '<label>Apellidos:</label><br>';
    echo '<input type="text" name="apellidos" required><br><br>';

    echo '<label>Fecha de nacimiento:</label><br>';
    echo '<input type="date" name="fecha_nac" required><br><br>';

    echo '<label>Salario:</label><br>';
    echo '<input type="number" name="salario" required><br><br>';

    echo '<label>Departamento inicial:</label><br>';
    echo '<select name="departamento" required>';

    // Obtener departamentos
    $sql = "SELECT cod_dpto, nombre_dpto FROM departamento";
    $stmt = $conn->query($sql);

    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) ////fila = $stmt->fetch() devuelve la siguiente fila del conjunto de resultados
    {
        echo '<option value="' . $fila['cod_dpto'] . '">' . htmlspecialchars($fila['nombre_dpto']) . '</option>';
    }

    echo '</select><br><br>';
    echo '<input type="submit" value="Dar de alta">';
    echo '</form>';
}

?>