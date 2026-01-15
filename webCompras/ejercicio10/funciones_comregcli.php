<?php
/*
    Desarrollar un formulario para Registro de clientes (comregcli.php) Al darse de alta, se les 
    proporcionará como nombre de usuario su nombre y como clave el apellido escrito de manera 
    inversa. Realizar en la base de datos las modificaciones que se estimen oportunas. 
    Ejemplo: Fernando Alonso → usuario: fernando clave: osnola 
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

// Comprueba si el NIF ya existe
function nifExiste($conn, $nif)
{
    $sql = "SELECT NIF FROM cliente WHERE NIF = :nif";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nif', $nif);
    $stmt->execute();
    return $stmt->rowCount() > 0;// Devuelve true si existe, false si no
}

function registrarCliente($conn, $nif, $nombre, $apellido, $cp, $direccion, $ciudad, $clave)
{
    $sql = "INSERT INTO cliente (NIF, NOMBRE, APELLIDO, CP, DIRECCION, CIUDAD, clave)
            VALUES (:nif, :nombre, :apellido, :cp, :direccion, :ciudad, :clave)";
    $stmt = $conn->prepare($sql);
    $stmt ->bindParam(':nif', $nif);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':cp', $cp);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':ciudad', $ciudad);
    $stmt->bindParam(':clave', $clave);
    $stmt->execute();

}
function formularioRegistro()
{
    echo '<h1>Registro de Cliente</h1>
    <form method="POST" action="">
        <label>NIF:</label>
        <input type="text" name="nif" maxlength="9" required><br><br>
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br><br>
        <label>Apellido:</label>
        <input type="text" name="apellido" required><br><br>
        <label>CP:</label>
        <input type="text" name="cp" maxlength="5"><br><br>
        <label>Dirección:</label>
        <input type="text" name="direccion"><br><br>
        <label>Ciudad:</label>
        <input type="text" name="ciudad"><br><br>
        <input type="submit" value="Registrarse">
    </form>';
}
?>