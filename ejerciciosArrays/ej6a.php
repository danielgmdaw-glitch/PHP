<HTML>
<HEAD><TITLE> EJ5-Arrays</TITLE></HEAD>
<BODY>
<?php
    /*
    Mostrar el array resultante del ejercicio anterior en orden inverso. Previamente, se
    deberá borrar el módulo mecanizado que no se imparte en el ciclo DAW.
    */

    $array1 = array("Bases de Datos", "Entornos de Desarrollo" , "Programacion");
    $array2 = array("Sistemas Informaticos", "FOL" , "Mecanizado");
    $array3 = array("Desarrollo Web ES", "Desarrollo Web EC" , "Despliegue", "Desarrollo Interfaces", "Ingles");

    $arrayTodos = array();

    for ($i=0; $i < count($array1); $i++) 
    {
        $arrayTodos[] = $array1[$i];
    }
    for ($i=0; $i < count($array2); $i++) 
    {
        $arrayTodos[] = $array2[$i];
    }
    for ($i=0; $i < count($array3); $i++) 
    {
        $arrayTodos[] = $array3[$i];
    }

    echo "<h2><b>Array Ordenado</b></h2>";
    for ($i = 0; $i < count($arrayTodos); $i++)
    {
        echo $arrayTodos[$i] , "<br>";
    }   

    $index = array_search("Mecanizado", $arrayTodos);
    if ($index != false) 
    {
        unset($arrayTodos[$index]);
        //unset sirve para eliminar un valor del array, al haber buscado con la variable index Mecanizado,
        //ponemos unset($arrayTodos[$index]); para eliminar Mecanizado
        //usamos array_values para mantener el orden numérico consecutivo del array
        $arrayTodos = array_values($arrayTodos);
    }

    print("<h2><b>Array inverso</b></h2>");

    for ($i = count($arrayTodos) - 1; $i >= 0; $i--) 
    {
        echo $arrayTodos[$i] . "<br>";
    }

?>
</BODY>
</HTML>