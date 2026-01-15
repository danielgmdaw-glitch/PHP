<?php
/*
    Una vez que el usuario se ha registrado, podrá acceder al portal a través de un formulario de 
    Login (comlogincli.php). Si se ha logeado correctamente, podrá acceder a las opciones de 
    compra de productos, consulta de compras en caso contrario se mostrará el correspondiente 
    mensaje de error.
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

function verificarCredenciales($conn, $nif, $clave)
{
    $sql = "SELECT NIF
            FROM cliente 
            WHERE NIF = :nif AND CLAVE = :clave";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nif', $nif);
    $stmt->bindParam(':clave', $clave);
    $stmt->execute();

    if ($stmt->rowCount() == 1) //indica que se ha encontrado un usuario con esas credenciales
    {
        // Credenciales correctas
        $_SESSION['nif'] = $nif;

        // Redirigir automáticamente al portal del cliente
        header("Location: portalcli.php");
        exit;
    } else {
        // Credenciales incorrectas
        echo "<h3 style='color:red'>Error: Credenciales incorrectas</h3>";
        loginClientes();
    }
}

function loginClientes()
{
    echo '
    <h1>Login Cliente</h1>
    <form method="POST" action="">
        <label>NIF:</label>
        <input type="text" name="nif" required><br><br>
        <label>Contraseña:</label>
        <input type="password" name="clave" required><br><br>
        <input type="submit" value="Entrar">
    </form>';
}

?>