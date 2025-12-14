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
