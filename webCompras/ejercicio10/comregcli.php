<?php
require_once "funciones_comregcli.php";
session_start();
$conn = conectarBD();

if (!isset($_POST) || empty($_POST)) {
    formularioRegistro();
} else {
    $nif       = limpiar_campos($_POST['nif']);
    $nombre    = limpiar_campos($_POST['nombre']);
    $apellido  = limpiar_campos($_POST['apellido']);
    $cp        = limpiar_campos($_POST['cp']);
    $direccion = limpiar_campos($_POST['direccion']);
    $ciudad    = limpiar_campos($_POST['ciudad']);

    try {
        // Comprobar si el NIF ya existe
        if (nifExiste($conn, $nif)) 
        {
            echo "<h3 style='color:red'>Error: El NIF $nif ya está registrado. No se puede repetir.</h3>";
            formularioRegistro();
            exit;
        }
        //para comprbar que el nif esté bien introducido
        if (empty($nif) || !preg_match('/^[0-9]{8}[A-Za-z]$/', $nif)) 
        {
            if (empty($nif)) {
                echo "<p style='color:red;'>ERROR: El NIF no puede estar vacío.</p>";
            } else {
                echo "<p style='color:red;'>ERROR: El NIF debe tener 8 números y una letra al final.</p>";
            }
            formularioRegistro();
            exit();
        }

        // Para casos como "Da Silva", la clave será "alivsad"
        $ultimo_apellido = str_replace(' ', '', $apellido);  // quita todos los espacios
        $clave = strrev(strtolower($ultimo_apellido));//strrev invierte la cadena

        registrarCliente($conn, $nif, $nombre, $apellido, $cp, $direccion, $ciudad, $clave);

        // Guardar en sesión y cookie (30 días)
        $_SESSION['usuario'] = strtolower($nombre);
        $_SESSION['clave']   = $clave;
        setcookie('usuario', strtolower($nombre), time() + (86400 * 30), "/");
        setcookie('clave', $clave, time() + (86400 * 30), "/");

        echo "<h2>Se ha registrado correctamente. Su usuario es {$nombre} y su contraseña es {$clave}</h2>";

        formularioRegistro(); 

    } catch (PDOException $e) {
        echo "<p style='color:red'>Error: " . $e->getMessage() . "</p>";
        formularioRegistro();
    }
}