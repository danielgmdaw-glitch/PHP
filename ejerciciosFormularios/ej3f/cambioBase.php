<?php

    function limpiar_campos($data) 
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    //a Binario
    function conversorBinario($numero)
    {
        if ($numero == 0)
        {
            return "0";
        }

        $binario = "";
        
        while ($numero > 0)
        {
            $resto = $numero % 2;
            $binario = $resto . $binario;
            //intdiv() sirve para hacer división y coger la parte entera
            $numero = intdiv($numero, 2);
        }
        // Rellenar con ceros a la izquierda hasta 8 bits
        $binario = str_pad($binario, 8, "0", STR_PAD_LEFT);
        return $binario;
    }
    //a Octal
    function conversorOctal($numero)
    {
        if ($numero == 0)
        {
            return "0";
        }

        $octal = "";
        
        while ($numero > 0)
        {
            $resto = $numero % 8;
            $octal = $resto . $octal;
            //intdiv() sirve para hacer división y coger la parte entera
            $numero = intdiv($numero, 8);
        }
        return $octal;
    }

    // Convertir a hexadecimal
    function conversorHexadecimal($numero) 
    {
        if ($numero == 0)
        {
            return "0";
        } 
        else
        {
            return strtoupper(dechex($numero));//dechex convierte de decimal a hexadecimal //strtoupper convierte una cadena a mayusuculas                        
        }
        
    }

    // Procesar el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $num = limpiar_campos($_POST['num']);
        $cambio = $_POST['cambio'];

        echo "<h1>Conversor Numerico</h1>";
        echo "<label>Numero Decimal: </label>";
        echo "<input value='" . $num . "' readonly><br><br>";

        // Mostrar resultados según opción
        if ($cambio == "binario") 
        {
            echo "<table border='1'>";
            echo "<tr><td>Binario</td><td>" . conversorBinario($num) . "</td></tr>";
            echo "</table>";
        } 
        elseif ($cambio == "octal") 
        {
            echo "<table border='1'>";
            echo "<tr><td>Octal</td><td>" . conversorOctal($num) . "</td></tr>";
            echo "</table>";
        } 
        elseif ($cambio == "hexadecimal") 
        {
            echo "<table border='1'>";
            echo "<tr><td>Hexadecimal</td><td>" . conversorHexadecimal($num) . "</td></tr>";
            echo "</table>";
        } 
        elseif ($cambio == "todos")
        {
            echo "<table border='1'>";
            echo "<tr><td>Binario</td><td>" . conversorBinario($num) . "</td></tr>";
            echo "<tr><td>Octal</td><td>" . conversorOctal($num) . "</td></tr>";
            echo "<tr><td>Hexadecimal</td><td>" . conversorHexadecimal($num) . "</td></tr>";
            echo "</table>";
        }
    }
?>