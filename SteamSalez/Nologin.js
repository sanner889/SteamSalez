    const modal = document.querySelector("#modal");
    const cerrarModal = document.querySelector("#cerrar");

    // Abrir modal al hacer clic en cualquier botón .fav-btn (delegación de eventos)
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("fav-btn")) {
            modal.showModal();
        }
    });

    // Cerrar modal
    cerrarModal.addEventListener("click", () => {
        modal.close();
    });
