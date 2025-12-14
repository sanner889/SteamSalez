
document.addEventListener("click", function(e) {
//confirmamos donde fue el click

    if (e.target.classList.contains("delete-btn")) {

//agregamos info a la variable

        const gameID = e.target.dataset.id
        
//Enviamos la info al php
        fetch("eliminar_fav.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body:
                "gameID=" + encodeURIComponent(gameID)
        })
        .then(res => res.text())
        .then(data => {
            console.log("Respuesta:", data);
            alert(data);
            location.reload();
        });
    
    }
}
);

//busqueda de juegos

function filtrarFavoritos() {
    const texto = document.getElementById("busquedaFav").value.toLowerCase();
    const juegos = document.querySelectorAll("#favoritos .juegox");

    juegos.forEach(juego => {
        const titulo = juego.querySelector("h3").textContent.toLowerCase();

        if (titulo.includes(texto)) {
            juego.style.display = "block";
        } else{
            juego.style.display = "none";
        }
    });
}

document.getElementById("btnBuscarFav").addEventListener("click", filtrarFavoritos);
document.getElementById("busquedaFav").addEventListener("keyup", filtrarFavoritos);
