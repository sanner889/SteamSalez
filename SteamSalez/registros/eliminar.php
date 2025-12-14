<?php
include('connection.php');
session_start();

//verificacion

if (!isset($_SESSION['user'])) {
    header("Location: login.php?");
    exit;
}


$id = $_SESSION['id'];

$result = mysqli_query($conn, "DELETE FROM users WHERE id='$id'");

if ($result) {
    session_destroy();
    header("Location: login.php");
    exit;
} else {
    echo "Error al eliminar usuario";
}
?>