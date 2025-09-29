<HTML>
<HEAD><TITLE> EJ5-Arrays</TITLE></HEAD>
<BODY>
<?php
    /*
    Definir tres arrays con los siguientes valores relativos a módulos que se imparten en el ciclo DAW
    a. Unir los 3 arrays en uno único sin utilizar funciones de arrays
    b. Unir los 3 arrays en uno único usando la función array_merge()
    c. Unir los 3 arrays en uno único usando la función array_push()
    */

    $array1 = array("Bases de Datos", "Entornos de Desarrollo" , "Programacion");
    $array2 = array("Sistemas Informaticos", "FOL" , "Mecanizado");
    $array3 = array("Desarrollo Web ES", "Desarrollo Web EC" , "Despliegue", "Desarrollo Interfaces", "Ingles");

    $arrayTodos = array($array1, $array2, $array3);

    echo "<h1>Apartado A</h1>";

    for ($i=0; $i < count($arrayTodos); $i++)
    {
        for ($j=0; $j < count($arrayTodos[$i]); $j++) 
        {
            echo $arrayTodos[$i][$j];
            echo "<br>";
        }
    }

    echo "<br>";
    echo "<h1>Apartado B</h1>";
    //La función array_merge() fusiona una o más matrices en una sola matriz.
    //print_r visualiza de una manera más legible para leer para los humanos
    print_r(array_merge($array1,$array2,$array3));

    echo "<br>";
    echo "<h1>Apartado C</h1>";

    $arrayTodosC = array();

    //Añadimos elementos de $array1 a $arrayTodosC
    foreach ($array1 as $asignatura)
    {
        array_push($arrayTodosC, $asignatura);
    }

    foreach ($array2 as $asignatura) 
    {
        array_push($arrayTodosC, $asignatura);
    }

    foreach ($array3 as $asignatura) 
    {
        array_push($arrayTodosC, $asignatura);
    }

    foreach ($arrayTodosC as $asignatura) 
    {
        echo $asignatura . "<br>";
    }
?>
</BODY>
</HTML>