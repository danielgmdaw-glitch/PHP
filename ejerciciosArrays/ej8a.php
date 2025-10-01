<HEAD><TITLE> EJ8-Arrays</TITLE></HEAD>
<BODY>
<?php
    /*
    Programa ej8a.php crear un array asociativo con los nombres de 5 alumnos y la nota de cada uno de
    ellos en Bases Datos. Se pide:
    a. Mostrar el alumno con mayor nota.
    b. Mostrar el alumno con menor nota.
    c. Media notas obtenidas por los alumnos
    */

    $alumnos = array("Daniel" => 8, "Mario" => 7, "Cesar" => 5, "Carlos" => 6, "Javi" => 10);

    echo "<h2>Apartado A</h2>";

    $notaMayor = max($alumnos);
    $mejor = array_search($notaMayor, $alumnos); // busca la clave que tiene esa nota
    echo "El alumno con mayor nota es: " . $mejor . " con un " . $notaMayor . "<br>";

    echo "<h2>Apartado B</h2>";
    $notaMenor = min($alumnos);
    $peor = array_search($notaMenor, $alumnos); // busca la clave que tiene esa nota
    echo "El alumno con menor nota es: " . $peor . " con un " . $notaMenor . "<br>";

    echo "<h2>Apartado C</h2>";
    $media = array_sum($alumnos) / count($alumnos);
    echo "La media de las notas es: " . round($media,2);//el 2 redondea para que haya 2 decimales

?>
</BODY>
</HTML>
