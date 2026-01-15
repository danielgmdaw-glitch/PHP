<?php
session_start();
require_once "funciones_comprocli.php";

$conn = conectarBD();


//Inicializamos el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}


if (!isset($_POST) || empty($_POST)) {

    $productos = obtenerProductos($conn);
    formularioCompra($productos);

} else {

    $accion = $_POST['accion'];//valor del botón pulsado
    $id_producto = limpiar_campos($_POST['id_producto']);

    // Inicializamos la variable $cantidad con 0 para evitar errores si no se envía el campo
    // y solo la actualizamos si $_POST['cantidad'] existe, limpiando la entrada y convirtiéndola a entero.
    $cantidad = 0;
    if (isset($_POST['cantidad'])) {
        $cantidad = (int) limpiar_campos($_POST['cantidad']);
    }

    if ($accion == "Añadir al carrito")
    {
        $disponibles = obtenerStockTotal($conn, $id_producto);

        if ($cantidad <= 0) 
        {
            echo "<h3 style='color:red'>Debe indicar una cantidad válida</h3>";
        } elseif ($disponibles < $cantidad) {
            echo "<h3 style='color:red'>No hay stock suficiente para el producto $id_producto. Disponibles: $disponibles</h3>";
        } else {
                if(isset($_SESSION['carrito'][$id_producto]))//si el producto ya está en el carrito
                {                             //$id_producto hace referencia al producto seleccionado
                    $_SESSION['carrito'][$id_producto] += $cantidad;//sumamos la cantidad
                } else {
                    $_SESSION['carrito'][$id_producto] = $cantidad;//añadimos el producto con la cantidad
                }

                echo "<h3 style='color:green'>Producto añadido al carrito</h3>";
        }
    }

    if ($accion == "Finalizar compra")
    {
        if (empty($_SESSION['carrito'])) {
            echo "<h3 style='color:red'>El carrito está vacío</h3>";
        } else {
            try {
                $conn->beginTransaction();

                foreach($_SESSION['carrito'] as $id_producto => $cantidad)//el foreach recorre el carrito 
                {                           
                    //Verificamos la disponibilidad total
                    $disponibles = obtenerStockTotal($conn, $id_producto);

                    if($disponibles < $cantidad)
                    {
                        throw new Exception("Stock insuficiente del producto $id_producto. Disponibles: $disponibles");
                    }

                    registrarCompra($conn, $nif, $id_producto, $cantidad);
                    descontarStock($conn, $id_producto, $cantidad);
                }
                
                $conn->commit();
                $_SESSION['carrito'] = [];//vaciamos el carrito
                echo "<h3 style='color:green'>Compra realizada con éxito</h3>";

            } catch (Exception $e) {
                $conn->rollBack();
                echo "<h3 style='color:red'>".$e->getMessage()."</h3>";
            }
        }
    }

    //mostrar carrito para hacer otra compra
    if(!empty($_SESSION['carrito']))//si el carrito no está vacío
    {
        echo "<h3>Carrito actual</h3>";
        foreach ($_SESSION['carrito'] as $id_producto => $cantidad) 
        {
            echo "<li>Producto $id_producto - Cantidad: $cantidad</li>";
        }
        echo "</ul>";
    }

    $productos = obtenerProductos($conn);
    formularioCompra($productos);
}
?>
