<?php
include('connection.php');
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}


$id = $_SESSION['id'];

if (isset($_POST['accion']) && $_POST['accion'] == "eliminar") {

    // 1. buscar imagen actual
    $sqlOld = mysqli_query($conn, "SELECT imagen FROM users WHERE id='$id'");
    $old = mysqli_fetch_assoc($sqlOld)['imagen'];

    // 2. borrar archivo solo si no es la predeterminada
    if ($old != "usuario.png" && file_exists("../Images/" . $old)) {
        unlink("../Images/" . $old);
    }

    // 3. volver a la imagen por defecto
    mysqli_query($conn, "UPDATE users SET imagen='usuario.png' WHERE id='$id'");

    header("Location: configuracion.php?mensaje=ImagenEliminada");
    exit;
}



// Comprobamos si se subió una imagen
if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] == 0) {

    if ($_FILES['nueva_imagen']['size'] > 2000000) {
        exit("Imagen demasiado pesada. Máx 2MB.");
    }

    $nombreOriginal = $_FILES['nueva_imagen']['name'];
    $extension = pathinfo($nombreOriginal, PATHINFO_EXTENSION);

    // Crear un nombre único
    $nuevoNombre = "perfil_" . $id . "_" . time() . "." . $extension;

    // Ruta destino
    $rutaDestino = "../Images/" . $nuevoNombre;

    // Mover archivo
    if (move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], $rutaDestino)) {

        // 1. Obtener imagen vieja
        $sqlOld = mysqli_query($conn, "SELECT imagen FROM users WHERE id='$id'");
        $old = mysqli_fetch_assoc($sqlOld)['imagen'];

        // 2. Borrar imagen vieja (si no es la de por defecto)
        if ($old != "usuario.png" && file_exists("../Images/" . $old)) {
        unlink("../Images/" . $old);
        }

        // Actualizar base de datos
        $sql = "UPDATE users SET imagen='$nuevoNombre' WHERE id='$id'";
        mysqli_query($conn, $sql);

        // Redirigir con éxito
        header("Location: configuracion.php?mensaje=ImagenActualizada");
        exit;

    } else {
        echo "Error al mover la imagen";
    }

} else {
    echo "No se subió ninguna imagen.";
}
