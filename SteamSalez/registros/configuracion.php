<?php
include('connection.php');
session_start();

//verificacion

if (!isset($_SESSION['user'])) {
    header("Location: login.php?");
    exit;
}

//Imagen usuario

$id = $_SESSION['id'];

$sql = mysqli_query($conn, "SELECT imagen FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($sql);

$imagen = "../Images/" . $row['imagen'];


//cambio de nombre

$user = $_SESSION['user'];

$msg='';


if (isset($_POST['submit'])) {
    $nuevoNombre = trim($_POST['name2']);

    // Validaciones
    if (empty($nuevoNombre)) {
        $msg = "Debes llenar el campo";
    } elseif ($nuevoNombre == $user) {
        $msg = "Es el mismo nombre de usuario";
    } else {
        // Verificar si ya existe otro usuario con ese nombre
        $stmtCheck = $conn->prepare("SELECT id FROM users WHERE user = ?");
        $stmtCheck->bind_param("s", $nuevoNombre);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            $msg = "El usuario ya existe";
        } else {
            // 1. Actualizar tabla users
            $stmt = $conn->prepare("UPDATE users SET user = ? WHERE id = ?");
            $stmt->bind_param("si", $nuevoNombre, $id);
            $stmt->execute();
            $stmt->close();

            // 2. Actualizar tabla favoritos
            $stmtFav = $conn->prepare("UPDATE favoritos SET user = ? WHERE user = ?");
            $stmtFav->bind_param("ss", $nuevoNombre, $user);
            $stmtFav->execute();
            $stmtFav->close();

            // 3. Actualizar sesión
            $_SESSION['user'] = $nuevoNombre;

            // Redirigir para que se refresque la página y se vea el cambio
            header("Location: configuracion.php");
            exit;
        }

        $stmtCheck->close();
    }
}

//Cambio de contraseña

$msg2 = '';
$msg3 = '';
$user = $_SESSION['user'];


if (isset($_POST['submit2'])) {
    $Contra1 = $_POST['contra1'];
    $Contra2 = $_POST['contra2'];

    // Traemos la contraseña actual de la BD
    $result = mysqli_query($conn, "SELECT password FROM users WHERE user='$user'");
    $row = mysqli_fetch_assoc($result);
    $contraseñaOG = $row['password'];

    // 1. Verificar que la contraseña actual coincida
    if ($Contra1 !== $contraseñaOG) {
        $msg2 = "Contraseña actual incorrecta";
    }
    // 2. Verificar que la nueva sea diferente
    elseif ($Contra2 === $contraseñaOG) {
        $msg2 = "La nueva contraseña es igual a la actual";
    }
    else {
        // Actualizar la contraseña
        mysqli_query($conn, "UPDATE users SET password='$Contra2' WHERE user='$user'");
        $msg3= "Contraseña actualizada correctamente";
    }
}
//eliminar cuenta


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de usuario</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>
<body>
    <header>
    <span>

        
        <a href="https://store.steampowered.com/" class="Link">Pagina oficial de steam</a>
        <img src="../Images/Steam_icon_logo.svg.png" alt="steam" class="steam-lg">

        <p class="espaciado"></p>

        <p class="usuario-saludo2">Hola! <span><?php echo $_SESSION['user'] ?></span></p>

        <div class="perfil-container">
            <img src="<?php echo $imagen; ?>" alt="Perfil" class="perfil-btn" id="perfilBtn">

            <div class="perfil-menu" id="perfilMenu">
                <a href="logined.php">Menu principal</a>
                <a href="perfil.php">Mi Perfil</a>
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </div>
    </span>
    </header>

    <h1>Configuración de Usuario</h1>

    <div class="Texto">
        <p><br>
            Hola <span><?php echo $_SESSION['user'] ?>! Este es tu Configuración de usuario, aqui podras cambiar tu nombre de usuario, siempre y<br>
            cuando sea por uno que no este en uso y que este disponible en la plataforma, tambien aca podras cambiar <br>
            tu contraseña por una nueva, la que desees, siempre y cuando tengas la contraseña original por motivos de seguridad 
            demas de tambien poder agregar una foto de perfil para tu cuenta y modificar demas caracteristicas! <br>

        </p> 
    </div>
    <h2>Cambiar Foto de Perfil</h2>
    <form id="formImagen" action="actualizar.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="nueva_imagen" id="nueva_imagen" required>
        <button type="submit" name="accion" value="actualizar">Actualizar imagen</button>
        <button type="submit" name="accion" value="eliminar" id="btnEliminar" class="NoImg">Eliminar imagen</button>
    </form>

    <script>
        document.getElementById("btnEliminar").addEventListener("click", function() {
        // Deshabilitar required temporalmente
        document.getElementById("nueva_imagen").required = false;
    });
    </script>

    <h2>Cambiar Nombre de usuario</h2>
    <div class="Cambiar-nombre">
        <p class="msg"><?= $msg ?></p>  
        <form action="" method="POST" class="CambioN">
            <input type="text" name = "name2" placeholder = "Pon un nombre de usuario" class="form-control" require>
            <button class="btn-font" name="submit">Cambia tu nombre!</button>
        </form>
    </div>

    
    <h2>Cambiar contraseña</h2>
    <div>

        <form action="" method="POST" class="CambioN">
            <br>
            <p class="msg"><?= $msg2 ?></p> 
            <p class="msg2"><?= $msg3 ?></p> 
            <h3>Introduce tu contraseña actual</h3>
            <input type="password" name = "contra1" placeholder = "Introduce tu contraseña" class="form-control" require>
            <h3>Introduce tu nueva contraseña</h3>
            <input type="password" name = "contra2" placeholder = "Introduce la nueva contraseña" class="form-control" require>

            <button class="btn-font" name="submit2">Cambia tu contraseña!</button>
        </form>
    </div>
    <p></p>
    <p></p>
    <div class="eliminado">
        <a href="eliminar.php" onclick ="return confirm('Estas seguro de Eliminar tu Usuario?')"><button class="NoImg">Eliminar usuario</button></a>
    </div>
<p></p>
    <script src="already.js"></script>
    <script src="perfil.js"></script>
    <script src="perfilUsuario.js"></script>
    
</body>
</html>
