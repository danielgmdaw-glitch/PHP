<?php
require_once "funciones_comaltacli.php";

$conn = conectarBD();

if (!isset($_POST) || empty($_POST)) {
    mostrarFormularioClientes();
} else {
    $nif = limpiar_campos($_POST['nif']);
    $nombre = limpiar_campos($_POST['nombre']);
    $apellido = limpiar_campos($_POST['apellido']);
    $cp = limpiar_campos($_POST['cp']);
    $direccion = limpiar_campos($_POST['direccion']);
    $ciudad = limpiar_campos($_POST['ciudad']);

    if (empty($nif) || !preg_match('/^[0-9]{8}[A-Za-z]$/', $nif)) 
    {
        if (empty($nif)) {
            echo "<p style='color:red;'>ERROR: El NIF no puede estar vacío.</p>";
        } else {
            echo "<p style='color:red;'>ERROR: El NIF debe tener 8 números y una letra al final.</p>";
        }
        mostrarFormularioClientes();
        exit();
    }

    try {
        altaCliente($conn, $nif, $nombre, $apellido, $cp, $direccion, $ciudad);
        echo "<p>Cliente dado de alta correctamente con NIF: <strong>$nif</strong></p>";
    } catch (PDOException $e) {
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }

    mostrarFormularioClientes();
}
?>
