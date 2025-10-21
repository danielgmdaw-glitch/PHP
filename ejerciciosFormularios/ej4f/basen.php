<?php
function limpiar_campos($data) 
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function convertirBase($numero, $baseOrigen, $baseDestino)
{
    //base_convert()convierte un número de una base a otra
    //base_convert(string $numero, int $base_origen, int $base_destino)
    $resultado = base_convert($numero, $baseOrigen, $baseDestino);

    return $resultado;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $numero = $_POST["numero"];
    $baseOrigen = (int)$_POST["base_origen"];
    $baseDestino = (int)$_POST["base_destino"];

    $resultado = convertirBase($numero, $baseOrigen, $baseDestino);

    echo "<h2>Resultado</h2>";
    echo "<p>Número <strong>$numero</strong> en base $baseOrigen = <strong>$resultado</strong> en base $baseDestino.</p>";
}
?>
