<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EJ1-Ficheros</title>
</head>
<body>
    <h1>Registro de Alumnos</h1>

    <?php
    function limpiar_campos($data) 
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        // Recoger datos del formulario
        $nombre = limpiar_campos($_POST['nombre']);
        $apellido1 = limpiar_campos($_POST['apellido1']);
        $apellido2 = limpiar_campos($_POST['apellido2']);
        $fecha = limpiar_campos($_POST['fecha']);
        $localidad = limpiar_campos($_POST['localidad']);

        // Aseguramos la longitud de cada campo con str_pad()
        // str_pad(cadena, longitud_total, caracter_relleno, tipo_relleno)
        $nombre = str_pad(substr($nombre, 0, 40), 40, " ");
        $apellido1 = str_pad(substr($apellido1, 0, 41), 41, " ");
        $apellido2 = str_pad(substr($apellido2, 0, 42), 42, " ");
        $fecha = str_pad(substr($fecha, 0, 10), 10, " ");
        $localidad = str_pad(substr($localidad, 0, 27), 27, " ");

        $linea = $nombre . $apellido1 . $apellido2 . $fecha . $localidad . "\n";

        $fichero = fopen("alumnos1.txt", "a");//con "a" añadimos al final del fichero sin borrar lo que ya haya dentro.
        fwrite($fichero, $linea);
        fclose($fichero);

        echo "<p style='color:green;'>Alumno registrado correctamente.</p>";
    }
    ?>

    <form method="post">
        <label>Nombre: </label>
        <input type="text" name="nombre" required><br><br>

        <label>Apellido1 : </label>
        <input type="text" name="apellido1" required><br><br>

        <label>Apellido2: </label>
        <input type="text" name="apellido2" required><br><br>

        <label>Fecha de Nacimiento: </label>
        <input type="date" name="fecha" required><br><br>

        <label>Localidad:</label>
        <input type="text" name="localidad" required><br><br>

        <input type="submit" value="Guardar Alumno">
        <input type="reset" value="Borrar">
    </form>
</body>
</html>
