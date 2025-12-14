<?php

session_start();


//Permite que cualquier archivo pueda obtener info del php y que su contenido esta en json

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");



//hacemos un if resumido para darle un valor a un titulo en la url segun la API, esto depende si el usuario bbusco algo o no

$title = isset($_GET['title']) ? urlencode($_GET['title']) : "";
$endpoint = "";

//En vase a si title esta vacio o no, declararemos un valor en especifico

if (empty($title)) {
    $endpoint = "https://www.cheapshark.com/api/1.0/deals?storeID=1&onSale=1&pageSize=10";
} else {
    $endpoint = "https://www.cheapshark.com/api/1.0/deals?storeID=1&title={$title}&pageSize=10";
}

// Usamos curl
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint);  //Usara la URL de endpoint
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  //Evita que la info se muestre directamente
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Nos permite acceder a la API y evitar errores
$response = curl_exec($ch); //lo ejecuta
curl_close($ch);

// Devuelve la respuesta de la API al navegador
echo $response;
?>