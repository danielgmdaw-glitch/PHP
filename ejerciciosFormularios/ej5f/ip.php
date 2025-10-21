<?php
function limpiar_campos($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validarIP($ip) 
{
    return filter_var($ip, FILTER_VALIDATE_IP);
}//filter_var($ip, FILTER_VALIDATE_IP) intenta validar la cadena $ip como dirección IP

function convertirABinario($ip) 
{
    $partes = explode('.', $ip);//explode separa la cadena por los puntos y devuelve un array
    $binario = [];
    foreach ($partes as $p) //Recorremos cada octeto
    {
        $binario[] = str_pad(decbin($p), 8, "0", STR_PAD_LEFT);//decbin($p) convierte el número decimal a binario|||str_pad asegura 8 bits rellenando con ceros a la izquierda si hace falta
    }
    return implode('.', $binario);//implode('.', $binario) une los octetos binarios con puntos y devuelve la cadena
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $ip = $_POST['ip'];
    if (validarIP($ip))
    {
        echo"<h1>IPs</h1>";
        echo "<p>IP notación decimal: $ip</p>";
        echo "<p>IP binario: " . convertirABinario($ip) . "</p>";
    } else {
        echo "<h3><strong>La IP introducida no es válida.</strong></h3>";
    }
}
?>