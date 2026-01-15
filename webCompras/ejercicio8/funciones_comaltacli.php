<?php
/*
    Alta de Clientes (comaltacli.php): dar de alta un cliente. Se validará que el campo NIF no está 
    vacío y que se compone de 8 dígitos más una letra. Además, se controlará mediante el 
    correspondiente mensaje de error que no se dan de alta dos clientes con el mismo NIF.
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

function altaCliente($conn, $nif, $nombre, $apellido, $cp, $direccion, $ciudad)
{

    // Comprobar si ya existe el NIF
    $existeNIF = $conn->prepare("SELECT * FROM cliente WHERE nif = :nif");
    $existeNIF->bindParam(':nif', $nif);
    $existeNIF->execute();

    if ($existeNIF->rowCount() > 0) {
        echo"<p style='color:red;'>ERROR: Ya existe un cliente con el NIF $nif</p>";
    }

    $stmt = $conn->prepare("INSERT INTO cliente (nif, nombre, apellido, cp, direccion, ciudad) 
                            VALUES (:nif, :nombre, :apellido, :cp, :direccion, :ciudad)");

    $stmt->bindParam(':nif', $nif);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':cp', $cp);
    $stmt->bindParam(':direccion', $direccion);
    $stmt->bindParam(':ciudad', $ciudad);

    $stmt->execute();
}

function mostrarFormularioClientes()
{
    echo '<h1>Alta de Cliente</h1>
            <form method="POST" action="">
                <label for="nif">NIF:</label>
                <input type="text" id="nif" name="nif" required><br><br>

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required><br><br>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" required><br><br>

                <label for="cp">Código Postal:</label>
                <input type="text" id="cp" name="cp" required><br><br>

                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" required><br><br>

                <label for="ciudad">Ciudad:</label>
                <input type="text" id="ciudad" name="ciudad" required><br><br>

                <input type="submit" value="Dar de Alta">
            </form>';
}
?>