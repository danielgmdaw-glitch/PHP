<HTML>
<HEAD><TITLE> EJ2- </TITLE></HEAD>
<BODY>
<?php
    $ip = "10.33.161.2";

    $ip="10.33.161.2";
    
    //strpos(string,find,start): en la primera posicion elegimos el string que queremos
    //en la segunda buscamos donde queremos separar, en nuestro caso el .
    //en este caso no hay tercera posicion ya que queremos el primero
    // Primer punto
    $pos1 = strpos($ip, ".");
    $p1 = substr($ip, 0, $pos1);

    //al ser el segundo que queremos encontrar, en la tercera posicion 
    // ponemos que empiece por la pos1+1 para que empiece a buscar desde 
    // el numero después del punto, es decir, busque hasta el segundo punto
    // Segundo punto
    $pos2 = strpos($ip, ".", $pos1 + 1);
    $p2 = substr($ip, $pos1 + 1, $pos2 - $pos1 - 1);
    //substr(string,start,length): escogemos la string, donde queremos que 
    //empice a buscar, en este caso despues de la pos1(192.),
    //lo que hace  $pos2 - $pos1 - 1 es: $pos2=6 - $pos1=3 -1(-1 para coger la posicion hasta antes del tercer punto)
    //en lineas generales substr nos dice Coge desde justo después del primer 
    //punto hasta justo antes del segundo punto

    // Tercer punto
    $pos3 = strpos($ip, ".", $pos2 + 1);
    $p3 = substr($ip, $pos2 + 1, $pos3 - $pos2 - 1);

    // Cuarto bloque (lo que queda después del tercer punto)
    $p4 = substr($ip, $pos3 + 1);

    // Convertimos cada bloque a binario manualmente y rellenamos con ceros a la izquierda
    //decbin convierte de decimal a binario
    //str_pad(string,length,pad_string,pad_type)string es la ip, en el primer caso la p1, despues la longitud,
    //especifica la cadena que se usará para rellenar. Por defecto es un espacio en blanco, nosotros ponemos 0.
    //con STR_PAD_LEFT nos aseguramos que rellene hasta que haya 8 posiciones con 0 a la izquierda sino hay valores
    $ip1 = str_pad(decbin($p1), 8, "0", STR_PAD_LEFT);
    $ip2 = str_pad(decbin($p2), 8, "0", STR_PAD_LEFT);
    $ip3 = str_pad(decbin($p3), 8, "0", STR_PAD_LEFT);
    $ip4 = str_pad(decbin($p4), 8, "0", STR_PAD_LEFT);

    // Mostramos el resultado
    echo "La IP " . $ip . " en binario es " . $ip1 . "." . $ip2 . "." . $ip3 . "." . $ip4;
?>
</BODY>
</HTML>