<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EJ4-Ficheros</title>
</head>
<body>
    <h1>Alumnos2 Registrados</h1>

    <?php
    $archivo = "../ej2Ficheros/alumnos2.txt";

    if (file_exists($archivo))
    {
        $fichero = fopen($archivo, "r");
        echo "<table border='1'>";
        echo "<tr><th>Datos de los Alumnos</th></tr>";

        $contador = 0;
        while (!feof($fichero)) //feof sirve para saber si se ha llegado al final del fichero
        {
            $linea = fgets($fichero);//fgets lee una línea del fichero
            $linea = trim($linea);
            
            if ($linea != "") 
            {
                echo "<tr><td>" . $linea . "</td></tr>";
                $contador++;
            }
        }

        fclose($fichero);
        echo "</table>";
        echo "<p>Número de alumnos registrados: $contador</p>";
    } else {
        echo "<p>No hay alumnos registrados.</p>";
    }
    ?>
</body>
</html>
