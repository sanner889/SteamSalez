<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user'])) {
    echo "Debes iniciar sesión";
    exit;
}

$user = $_SESSION['user'];

$gameID = $_POST['gameID'];
$title = $_POST['title'];
$thumb = $_POST['thumb'];
$sale = $_POST['sale'];
$normal = $_POST['normal'];

// VALIDACIÓN
if (!$gameID) {
    echo "ID inválido";
    exit;
}

// Verificar si ya está
$check = $conn->query("SELECT * FROM favoritos WHERE user='$user' AND gameID='$gameID'");
if ($check->num_rows > 0) {
    echo "Este juego ya está en favoritos";
    exit;
}

// Insertar
$sql = "INSERT INTO favoritos (user, gameID, title, thumb, salePrice, normalPrice)
        VALUES ('$user', '$gameID', '$title', '$thumb', '$sale', '$normal')";

if ($conn->query($sql)) {
    echo "Agregado a favoritos 💛";
} else {
    echo "Error: " . $conn->error;
}
