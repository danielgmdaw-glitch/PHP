<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EJ3-Ficheros</title>
</head>
<body>
    <h1>Listado de Alumnos</h1>

    <?php
    $nombreFichero = "../ej1Ficheros/alumnos1.txt";

    if (!file_exists($nombreFichero)) 
    {
        echo "<p>El fichero $nombreFichero no existe.<p>";
    } else {
        $fichero = fopen($nombreFichero, "r");//r es solo lectura
        if (!$fichero) 
        {
            echo "<p>No se pudo abrir el fichero.</p>";
        } else {
            echo "<table border='1'>";
            echo "<tr>
                    <th>Nombre</th>
                    <th>Apellido1</th>
                    <th>Apellido2</th>
                    <th>Fecha Nacimiento</th>
                    <th>Localidad</th>
                  </tr>";

            $contador = 0;

            while (!feof($fichero))//feof sirve para saber si se ha llegado al final del fichero
            {
                $linea = fgets($fichero);//fgets lee una línea del fichero

                if (trim($linea) != "") 
                {
                    $nombre = trim(substr($linea, 0, 40));
                    $apellido1 = trim(substr($linea, 40, 41));
                    $apellido2 = trim(substr($linea, 81, 42));
                    $fecha = trim(substr($linea, 123, 10));
                    $localidad = trim(substr($linea, 133, 27));

                    echo "<tr>
                            <td>$nombre</td>
                            <td>$apellido1</td>
                            <td>$apellido2</td>
                            <td>$fecha</td>
                            <td>$localidad</td>
                          </tr>";

                    $contador++;
                }
            }

            echo "</table>";
            fclose($fichero);

            echo "<p>Se han leído $contador filas del fichero.</p>";
        }
    }
    ?>
</body>
</html>
