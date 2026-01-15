<?php
/*
    Aprovisionar Productos (comaprpro.php): asignar una cantidad de un determinado producto 
    a un almacén. Se seleccionarán los nombres de los productos y los números de los almacenes 
    desde listas desplegables. El usuario introducirá la cantidad del producto a aprovisionar. 
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

function obtenerProductos($conn)
{
    $sql = "SELECT id_producto, nombre FROM producto";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerNumAlmacen($conn)
{
    $sql = "SELECT num_almacen FROM almacen";
    $stmt = $conn->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function aprovisionarProducto($conn, $producto, $almacen, $cantidad)
{
    $stmt = $conn->prepare("INSERT INTO almacena (id_producto, num_almacen, cantidad)
                                VALUES (:producto, :almacen, :cantidad)");
    $stmt->bindParam(':producto', $producto);
    $stmt->bindParam(':almacen', $almacen);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->execute();
}

function formularioAprovProductos($producto, $almacen)
{
    echo '<h1>Aprovisionar Productos</h1>
          <form method="POST" action="">
              <label for="producto">Producto:</label>
              <select name="producto" id="producto">';
    foreach ($producto as $pro) 
    {
        echo '<option value="' . $pro['id_producto'] . '">' .
             htmlspecialchars($pro['nombre']) .
             '</option>';
    }
    echo '    </select><br><br>
              <label for="almacen">Almacén:</label>
              <select name="almacen" id="almacen">';
    foreach ($almacen as $alm) 
    {
        echo '<option value="' . $alm['num_almacen'] . '">' .
             htmlspecialchars($alm['num_almacen']) .
             '</option>';
    }
    echo '    </select><br><br>
              <label for="cantidad">Cantidad:</label>
              <input type="number" name="cantidad" id="cantidad" min="1" required><br><br>
              <input type="submit" value="Aprovisionar">
          </form>';
}


?>