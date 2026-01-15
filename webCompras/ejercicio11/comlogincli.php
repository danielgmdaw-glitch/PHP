<?php
session_start();
require_once "funciones_comlogincli.php";

$conn = conectarBD();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    loginClientes();
} else {
    $nif = limpiar_campos($_POST['nif']);
    $clave  = limpiar_campos($_POST['clave']);

    try {
        verificarCredenciales($conn, $nif, $clave);
    } catch (PDOException $e) {
        echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
    }
}

?>