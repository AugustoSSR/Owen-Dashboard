document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("setPasswordModal");
    const closeBtn = modal.querySelector(".close");
    const form = document.getElementById("setPasswordForm");

    function openModal() {
        modal.style.display = "block";
    }

    function closeModal() {
        modal.style.display = "none";
    }

    closeBtn.addEventListener("click", function () {
        closeModal();
        openModal(); // Reabre o modal automaticamente
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeModal();
            openModal(); // Reabre o modal automaticamente
        }
    });

    form.addEventListener("submit", function (event) {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;

        if (password !== confirmPassword) {
            event.preventDefault();
            alert("As senhas não coincidem. Por favor, tente novamente.");
            return false;
        }
    });

    openModal(); // Abre o modal quando a página é carregada
});
