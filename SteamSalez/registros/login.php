<?php
include("connection.php");
session_start();

$msg = '';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    // 1. Buscar el usuario
    $select1 = "SELECT * FROM `users` WHERE user = '$name'";
    $select_user = mysqli_query($conn, $select1);

    if (mysqli_num_rows($select_user) > 0) {
        // 2. Obtener los datos del usuario
        $row1 = mysqli_fetch_assoc($select_user);

        // 3. Verificar la contraseña
        if ($row1['password'] === $password) {

            // 4. Login correcto y guardar sesión
            $_SESSION['user'] = $row1['user'];
            $_SESSION['id']   = $row1['id'];

            header("location: logined.php");
            exit;

        } else {
            // Contraseña incorrecta
            $msg = "Contraseña incorrecta";
        }

    } else {
        // Usuario no existe
        $msg = "El usuario no existe";
    }
}


?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicia Sesion</title>
        <link rel="stylesheet" href="CSS/styles.css">
    </head>
    <body>
        <div class="form">
            <form action="" method="post">
                <h2>Inicia sesión</h2>
                <p class="msg"><?= $msg ?></p>            


                <h3>usuario</h3>

                    <div class="form-group">
                        <input type="text" name = "name" placeholder = "Ingrese su usuario" class="form-control" require>
                    </div>
                <h3>contraseña</h3>
                    <div class="form-group">
                        <input type="password" name = "password" placeholder = "Ingrese su contraseña" class="form-control" require>
                    </div>
                <button class="btn-font" name="submit">Inicia sesión ahora</button>
                <p>No tienes una cuenta? <a href="Registrase.php" class="link_ir">Registrate ya!</a></p>
                <p>Click aqui para volver al <a href="..//index.html" class="link_ir">menu principal</a></p>
            </form>
        </div>
    </body>
    </html>

