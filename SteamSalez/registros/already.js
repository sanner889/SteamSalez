//funcion del toast

function showToast(msg) {
    const toast = document.getElementById("toast");
    toast.textContent = msg;
    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 2500);
}



document.addEventListener("click", function(e) {
//confirmamos donde fue el click

    if (e.target.classList.contains("fav-btn")) {

//agregamos info a la variable

        const gameID = e.target.dataset.id;
        const title = e.target.dataset.title;
        const thumb = e.target.dataset.thumb;
        const sale = e.target.dataset.sale;
        const normal = e.target.dataset.normal;

//enviamos los datos al php como formulario html

        fetch("guardar_fav.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body:
                "gameID=" + encodeURIComponent(gameID) +
                "&title=" + encodeURIComponent(title) +
                "&thumb=" + encodeURIComponent(thumb) +
                "&sale=" + encodeURIComponent(sale) +
                "&normal=" + encodeURIComponent(normal)
        })
        .then(res => res.text())
        .then(data => {
            console.log("Respuesta:", data);
            showToast(data);
        });
    
    }
});
