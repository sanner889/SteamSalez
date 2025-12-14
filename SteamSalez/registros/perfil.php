<?php
include('connection.php');
session_start();

//verificacion

if (!isset($_SESSION['user'])) {
    header("Location: login.php?");
    exit;
}

//Consulta de los juegos añadidos

$user = $_SESSION['user'];
$sql = "SELECT * FROM favoritos WHERE user='$user' ";
$result = mysqli_query($conn,$sql);
$favCount = mysqli_num_rows($result);

//Imagen usuario

$id = $_SESSION['id'];

$sql = mysqli_query($conn, "SELECT imagen FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($sql);

$imagen = "../Images/" . $row['imagen'];

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


        <input type="text" id="busquedaFav" placeholder="Escribe el juego...">

        <button id="btnBuscarFav">
            <img src="../Images/loupe-et-icone-de-recherche-couleur-noire.png" alt="Busqueda" class="btn-busqueda">
        </button>

        <p class="usuario-saludo">Hola! <span><?php echo $_SESSION['user'] ?></span></p>

        <div class="perfil-container">
            <img src="<?php echo $imagen; ?>" alt="Perfil" class="perfil-btn" id="perfilBtn">

            <div class="perfil-menu" id="perfilMenu">
                <a href="logined.php">Menu principal</a>
                <a href="configuracion.php">Configuración</a>
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </div>
    </span>
    </header>

    <h1>Perfil de Usuario</h1>

    <div class="Texto">
        <p>
            Hola <span><?php echo $_SESSION['user'] ?>! Este es tu perfil de usuario, aqui podras ver tus juegos en favoritos y eliminarlos en caso de que<br>
            desees eliminarlos,  ademas, de que podras ver su respectivo precio actual y precio original, como en las tarjetas <br>
            del menu de inicio! Recuerda, para eliminar un juego de favoritos solo tienes que darle click en eliminar, si no <br>
            tienes juegos en favoritos ¡Añadelos de una vez, ve al menu principal desde el icono de tu perfil y empieza a añadir juegos! <br>
            Te aseguramos de que no te arrepentiras.
        </p> 
    </div>

    <h2>🔥Mis juegos favoritos 🔥</h2>

    <h3>Numero de juegos en favoritos: <span><?php echo $favCount ?></span></h3>

    <div id="favoritos" class="juegoz">
        <?php
            if (mysqli_num_rows($result) == 0) {
                echo "<p>No tienes juegos en favoritos todavia! Añade algunos para poder visualizarlos</p>";
            }else {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "
                        <div class='juegox'>
                            <h3>{$row['title']}</h3>
                            <img src='{$row['thumb']}' alt='{$row['title']}' class='imj'>
                            <p>Precio actual: \${$row['salePrice']}</p>
                            <p>Precio original: \${$row['normalPrice']}</p>
                            <p>Agregado en el: {$row['created_at']}</p>
                            <button class='delete-btn' data-id='{$row['gameID']}'>❌ Quitar</button>
                        </div>
                    ";
                }
            }
        ?>
    </div>

    <script src="already.js"></script>
    <script src="perfil.js"></script>
    <script src="perfilUsuario.js"></script>
    
</body>
</html>

