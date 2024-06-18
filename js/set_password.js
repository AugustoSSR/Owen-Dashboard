function validatePasswords() {
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirm_password").value;
    if (password !== confirmPassword) {
        alert("As senhas não coincidem. Por favor, tente novamente.");
        return false;
    }
    return true;
}

// Para abrir e fechar o modal
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("passwordModal");
    const closeBtn = modal.querySelector(".close");

    function openModal() {
        modal.style.display = "block";
    }

    function closeModal() {
        modal.style.display = "none";
    }

    // Adicionar evento de clique para o botão de fechar
    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            closeModal();
            setTimeout(openModal, 100); // Reabre o modal após uma pequena pausa
        });
    }

    // Fechar o modal quando o usuário clicar fora dele
    window.addEventListener("click", function (event) {
        if (event.target == modal) {
            closeModal();
            setTimeout(openModal, 100); // Reabre o modal após uma pequena pausa
        }
    });

    openModal(); // Abrir o modal automaticamente ao carregar a página
});
