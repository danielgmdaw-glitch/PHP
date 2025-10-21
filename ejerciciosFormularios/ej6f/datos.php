<?php
function limpiar_campos($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validarCampos($nombre, $correo, $sexo) 
{
    return !empty($nombre) && !empty($correo) && !empty($sexo);//empty comprueba si la variable está vacía
}

function mostrarTabla($nombre, $apellido1, $apellido2, $correo, $sexo) 
{
    echo "<h2>Datos del alumno</h2>";
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>Nombre</th><th>Apellido 1</th><th>Apellido 2</th><th>Email</th><th>Sexo</th></tr>";
    echo "<tr>";
    echo "<td>$nombre</td>";
    echo "<td>$apellido1</td>";
    echo "<td>$apellido2</td>";
    echo "<td>$correo</td>";
    echo "<td>$sexo</td>";
    echo "</tr>";
    echo "</table>";
}

// Guardar datos en el archivo datos.txt
function guardarDatos($nombre, $apellido1, $apellido2, $correo, $sexo) 
{
    $linea = "$nombre | $apellido1 | $apellido2 | $correo | $sexo\n";
    file_put_contents("datos.txt", $linea, FILE_APPEND);//file_put_contents(nombre_del_archivo, contenido, opciones);
    //file_put_contents escribe texto en un archivo       FILE_APPEND: Escribe al final del archivo sin borrar lo que ya hay dentro
}

// --- Programa principal ---
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $nombre = trim($_POST["nombre"]);
    $apellido1 = trim($_POST["apellido1"]);
    $apellido2 = trim($_POST["apellido2"]);
    $correo = trim($_POST["correo"]);
    $sexo = trim($_POST["sexo"]);

    if (validarCampos($nombre, $correo, $sexo)) 
    {
        mostrarTabla($nombre, $apellido1, $apellido2, $correo, $sexo);
        guardarDatos($nombre, $apellido1, $apellido2, $correo, $sexo);
    } else {
        echo "<p><a href='datos.html'>Volver al formulario</a></p>";
    }
}
?>
