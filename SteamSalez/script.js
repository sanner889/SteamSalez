async function CargarOfertas() {
    //Atrapamos la info de la API y la transformamos a JSON para ser leible por el js


    const respuesta = await fetch("http://localhost/steamSalez/backend.php");
 
    const datos = await respuesta.json();
    
    //Le damos al id juegos un vacio


    const contenedor = document.getElementById("juegos");
    contenedor.innerHTML = "";

    //Lo de datos solo tomaremos los 10 primeros les creamos un div para cada uno con una clase
    //Title y eso, la api nos lo marca en su pagina (adjuntada en el documento word) creamos un div, y contenedor tendra el mini div juego div


datos.slice(0, 10).forEach(Juego => {
    const juegoDiv = document.createElement("div");
    juegoDiv.classList.add("juegox");
    juegoDiv.innerHTML = `
        <h3>${Juego.title}</h3>
        <img src="${Juego.thumb}" alt="${Juego.title}" class="imj"> 
        <p>El precio actual es: $${Juego.salePrice}</p>
        <p>El precio original es: $${Juego.normalPrice}</p>
        <p>Porcentaje de buenas críticas en STEAM: ${Juego.steamRatingPercent}%</p>
        
        <button class="fav-btn" data-id="${Juego.steamAppID}" data-title="${Juego.title}" data-thumb="${Juego.thumb}" data-sale="${Juego.salePrice}" data-normal="${Juego.normalPrice}">⭐Añadir a favoritos</button>
    `;
    contenedor.appendChild(juegoDiv);
});

}


//Busqueda//



//Funcion lenta, donde obtiene lo del id busqueda y obtiene su valor sin espacios al comienzo ni final

async function BuscarJuego() {
    const input = document.getElementById("busqueda");
    const busqueda = input.value.trim();

    if (busqueda === "") return;

    //Volvemos el div juegos un buscando... mientras se conecta con la API


    const contenedor = document.getElementById("juegos");
    contenedor.innerHTML = "Buscando...";


//Conectamos con la API y segun su sitio web para facilidad modificamos la URL, para que solo vea el titulo de busqueda (se explica mejor en WORD)


    try {
        const respuesta = await fetch(`http://localhost/steamSalez/backend.php?title=${encodeURIComponent(busqueda)}`);

        const datos = await respuesta.json();


        //Si no hay un juego en STEAM marcara el error


        if (datos.length === 0) {
            contenedor.innerHTML = `<p>No se encontraron resultados para "${busqueda}"</p>`;
            return;
        }

//Dependiendo del juego mostrara y creara ciertos divs


        contenedor.innerHTML = "";
        datos.forEach(Juego => {
            const juegoDiv = document.createElement("div");
            juegoDiv.classList.add("juegox");
            juegoDiv.innerHTML = `
            <h3>${Juego.title}</h3>
            <img src="${Juego.thumb}" alt="${Juego.title}" class="imj"> 
            <p>El precio actual es: $${Juego.salePrice}</p>
            <p>El precio original es: $${Juego.normalPrice}</p>
            <p>Porcentaje de buenas críticas en STEAM: ${Juego.steamRatingPercent}%</p>
            <button class="fav-btn" data-id="${Juego.steamAppID}" data-title="${Juego.title}" data-thumb="${Juego.thumb}" data-sale="${Juego.salePrice}" data-normal="${Juego.normalPrice}">⭐Añadir a favoritos</button>
            `;
            contenedor.appendChild(juegoDiv);
        });

    } catch (error) {
        contenedor.innerHTML = "<p>Ha ocurrido un error</p>";
    }
}

document.getElementById("btnBuscar").addEventListener("click", BuscarJuego);
document.getElementById("busqueda").addEventListener("keypress", function (e) {
    if (e.key === "Enter") BuscarJuego();
});

CargarOfertas();


//usuario boton

//identifica si el usuario hace click en la imagen

document.getElementById("perfilBtn").onclick = function() {
    const menu = document.getElementById("perfilMenu");

    //si el menu esta abierto lo cierra (oculta) y si esta cerrado lo abre(lo muestra)
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
};

        // Cerrar si toca fuera
document.addEventListener("click", function(e) {
    const btn = document.getElementById("perfilBtn");
    const menu = document.getElementById("perfilMenu");
    
    if (!btn.contains(e.target) && !menu.contains(e.target)) {
        menu.style.display = "none";
    }
});

