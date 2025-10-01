<HEAD><TITLE> EJ7-Arrays</TITLE></HEAD>
<BODY>
<?php
    /*
    crear un array asociativo con los nombres de 5 alumnos y la edad de cada uno de
    ellos. Se pide:
    a. Mostrar el contenido del array utilizando bucles.
    b. Sitúa el puntero en la segunda posición del array y muestra su valor
    c. Avanza una posición y muestra el valor
    d. Coloca el puntero en la última posición y muestra el valor
    e. Ordena el array por orden de edad (de menor a mayor) y muestra la primera posición
    del array y la ultima
    */

    $alumnos = array("Daniel" => 20, "Mario" => 20, "Cesar" => 19, "Carlos" => 32, "Javi" => 20);

    echo "<h2>Apartado A</h2>";

    foreach($alumnos as $nombre => $edad) { 
        echo "Nombre: " . $nombre . " tiene " . $edad . " años<br>";
    }

    echo "<h2>Apartado B</h2>";

    $claves = array_keys($alumnos);
    $valores = array_values($alumnos);
    $nombre = $claves[1];
    $edad = $valores[1];
    echo "La segunda posición del array es: " . $nombre . " tiene " . $edad . " años.";

    echo "<h2>Apartado C</h2>";
    $nombre = $claves[2];
    $edad   = $valores[2];
    echo "La tercera posición del array es: " . $nombre . " tiene " . $edad . " años.<br>";
    
    echo "<h2>Apartado D</h2>";
    $ultimaClave  = end($claves);   
    $ultimaEdad   = end($valores);  
    echo "La última posición del array es: " . $ultimaClave . " tiene " . $ultimaEdad . " años.<br>";

    echo "<h2>Apartado E</h2>";
    asort($alumnos); // ordena por valor manteniendo las claves de menor a mayor

    $primeroNombre = array_key_first($alumnos); //Devuelve la primera clave de un array.
    $primeroEdad   = reset($alumnos); // mueve el puntero al primer elemento

    $ultimoNombre  = array_key_last($alumnos);//Devuelve la última clave de un array.
    $ultimoEdad    = end($alumnos);

    echo "El más joven es: " . $primeroNombre . " con " . $primeroEdad . " años.<br>";
    echo "El mayor es: " . $ultimoNombre . " con " . $ultimoEdad . " años.<br>";


?>
</BODY>
</HTML>
