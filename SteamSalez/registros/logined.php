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

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Steam Sales APP</title>
    <link rel="stylesheet" href="CSS/styles.css">
</head>



<body>

    <header>
    <span>
        
        <a href="https://store.steampowered.com/" class="Link">Pagina oficial de steam</a>
        <img src="../Images/Steam_icon_logo.svg.png" alt="steam" class="steam-lg">

        <p class="espaciado"></p>


        <input type="text" id="busqueda" placeholder="Escribe el juego...">

        <button id="btnBuscar">
            <img src="../Images/loupe-et-icone-de-recherche-couleur-noire.png" alt="Busqueda" class="btn-busqueda">
        </button>

        <p class="usuario-saludo">Hola! <span><?php echo $_SESSION['user'] ?></span></p>

        <div class="perfil-container">
            <img src="<?php echo $imagen; ?>" alt="Perfil" class="perfil-btn" id="perfilBtn">

            <div class="perfil-menu" id="perfilMenu">
                <a href="perfil.php">Mi perfil</a>
                <a href="configuracion.php">Configuración</a>
                <a href="logout.php">Cerrar sesión</a>
            </div>
        </div>


    </span>
    </header>

    <h1>Ofertas de juegos en STEAM</h1> 

    <div class="Texto">
        <p>
            En esta pagina encontraras la informacion de los juegos en descuento en la pagina de videojuegos STEAM <br>
            ten encuenta que los precios dados aca son en USD, pues son la moneda internacional y que algunos juegos <br>
            tienen precios regionales, es decir en Estados Unidos el juego cuesta 20 USD, pero en colombia el juego cuesta <br>
            48.000 COP (12 USD aprox.), usualmente en STEAM los descuentos son globales, si el juego que buscas no tiene <br>
            descuento mostrara el precio actual.
        </p> 
    </div>

    <h2>🔥🔥Ofertas Destacadas🔥🔥</h2>

    <div id="juegos" class="juegoz">Juegos en rebaja...</div>

    <div id="toast" class="toast"></div>

    <script src="../script.js"></script>
    <script src="already.js"></script>

    

    
</body>
</html>