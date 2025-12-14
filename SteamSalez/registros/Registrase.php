<?php

include("connection.php");

//creacion de las variable

$msg = '';
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $select1= "SELECT * FROM `users` WHERE user = '$name' AND password = '$password' ";
    $select_user = mysqli_query($conn,$select1);

    // 1. Usuario ya existente
    if (mysqli_num_rows($select_user) > 0 ) {
        $msg = "El usuario ya existe";
    }

    //2. Algun campo sin llenar
    elseif (empty($name) || empty($password) || empty($cpassword)) {
        $msg = "Debes llenar todos los campos";
    }

    // 3. Contraseñas que no coinciden
    elseif ($password !== $cpassword) {
         $msg = "Las contraseñas no coinciden";
    }

    //. 4. Registro a la base de datos y mandarlo al login
    else {
        $insert1 = "INSERT INTO `users`(`user`, `password`) VALUES ('$name','$password')";
        mysqli_query($conn,$insert1);
        header('location:login.php');
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <div class="form">
        <form action="" method="post">
            <h2>Registrate</h2>
            <p class="msg"><?= $msg ?></p>            

            <h3 class="b">usuario</h3>

                <div class="form-group">
                    <input type="text" name = "name" placeholder = "Pon un nombre de usuario" class="form-control" require>
                </div>
            <h3>contraseña</h3>
                <div class="form-group">
                    <input type="password" name = "password" placeholder = "Pon una contraseña" class="form-control" require>
                </div>
            <h3>Confirme su contraseña</h3>
                <div class="form-group">
                    <input type="password" name = "cpassword" placeholder = "confirma tu contraseña" class="form-control" require>
                </div>
            <button class="btn-font" name="submit">Registrate ahora</button>
            <p>Ya tienes una cuenta? <a href="login.php" class="link_ir">Inicia sesión ya!</a></p>
            <p>Click aqui para volver al <a href="..//index.html" class="link_ir">menu principal</a></p>
        </form>
    </div>

</body>
</html>


