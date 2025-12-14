<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user'])) {
    echo "Debes iniciar sesión";
    exit;
}

// Obtener ID del juego correctamente
$gameID = $_POST['gameID'] ?? null;

if (!$gameID) {
    echo "ID inválido";
    exit;
}

$user = $_SESSION['user'];

// CORRECTO: tabla favoritos
$sql = "DELETE FROM favoritos WHERE user = '$user' AND gameID = '$gameID'";

if ($conn->query($sql)) {
    echo "Juego eliminado de favoritos";
} else {
    echo "Error: " . $conn->error;
}
