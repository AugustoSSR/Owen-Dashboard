document.addEventListener("DOMContentLoaded", function () {
    // Função para abrir o modal de adicionar usuário
    function openAddUserModal() {
        const modal = document.getElementById("addUserModal");
        const closeBtn = modal.querySelector(".close");

        modal.style.display = "block";

        // Fechar o modal ao clicar no botão de fechar (X)
        closeBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        // Fechar o modal ao clicar fora dele
        window.addEventListener("click", (event) => {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    }

    // Função para adicionar usuário
    function addUser(event) {
        event.preventDefault();

        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;

        if (name && email && isValidEmail(email)) {
            const formData = new FormData();
            formData.append("name", name);
            formData.append("email", email);

            fetch("./scripts/add_user.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        showAlert("success", data.message);
                        // Atualize a tabela de usuários
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert("error", data.message);
                    }
                    closeModal();
                })
                .catch(error => {
                    showAlert("error", "Erro ao adicionar usuário: " + error.message);
                });
        } else {
            showAlert("error", "Por favor, insira um nome e um email válidos.");
        }
    }

    // Função para fechar o modal
    function closeModal() {
        const modal = document.getElementById("addUserModal");
        modal.style.display = "none";
    }

    // Função para mostrar alertas
    function showAlert(type, message) {
        const alertContainer = document.getElementById("alertContainer");
        const alert = document.createElement("div");
        alert.className = `alert alert-${type === "success" ? "success" : "error"}`;
        alert.innerHTML = `
            ${message}
            <span class="close" onclick="this.parentElement.style.display='none';">&times;</span>
        `;
        alertContainer.appendChild(alert);

        setTimeout(() => {
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    }

    // Função para validar email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Função para editar usuário
    function editUser(userId) {
        fetch(`./scripts/users/get_user.php?id=${userId}`, {
            method: "GET"
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    const user = data.user;
                    const modal = document.getElementById("editUserModal");
                    const nameInput = modal.querySelector("#editUserName");
                    const emailInput = modal.querySelector("#editUserEmail");

                    nameInput.value = user.name;
                    emailInput.value = user.email;

                    modal.style.display = "block";

                    const form = modal.querySelector("form");
                    form.addEventListener("submit", function (event) {
                        event.preventDefault();

                        const newName = nameInput.value;
                        const newEmail = emailInput.value;

                        fetch("./scripts/users/edit_user.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded"
                            },
                            body: `id=${userId}&name=${newName}&email=${newEmail}`
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === "success") {
                                    showAlert("success", data.message);
                                    setTimeout(() => location.reload(), 1500);
                                } else {
                                    showAlert("error", data.message);
                                }
                            })
                            .catch(error => {
                                showAlert("error", "Erro ao editar usuário: " + error.message);
                            });
                    });

                    const closeBtn = modal.querySelector(".close");
                    closeBtn.addEventListener("click", () => {
                        modal.style.display = "none";
                    });
                } else {
                    showAlert("error", data.message);
                }
            })
            .catch(error => {
                showAlert("error", "Erro ao obter dados do usuário: " + error.message);
            });
    }

    // Função para deletar usuário
    function deleteUser(userId) {
        if (confirm("Você tem certeza que deseja excluir este usuário?")) {
            fetch(`./scripts/users/delete_user.php?id=${userId}`, {
                method: "GET"
            })
                .then(response => response.text()) // Use .text() ao invés de .json() inicialmente
                .then(data => {
                    try {
                        const jsonData = JSON.parse(data); // Tente analisar como JSON
                        if (jsonData.status === "success") {
                            showAlert("success", jsonData.message);
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            console.log("Erro ao deletar usuário:", jsonData.message);
                            showAlert("error", jsonData.message);
                        }
                    } catch (error) {
                        console.error("Erro ao processar resposta JSON:", error, data);
                        showAlert("error", "Erro ao processar resposta do servidor.");
                    }
                })
                .catch(error => {
                    console.error("Erro ao deletar usuário:", error);
                    showAlert("error", "Erro ao deletar usuário: " + error.message);
                });
        }
    }

    // Função para ver o usuário
    function viewUser(userId) {
        fetch(`./scripts/users/view_user.php?id=${userId}`, {
            method: "GET"
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    const user = data.user;
                    // Preenche os campos do modal de visualização com os dados do usuário
                    document.getElementById("viewName").innerText = user.name;
                    document.getElementById("viewEmail").innerText = user.email;
                    document.getElementById("viewStatus").innerText = user.is_active ? "Ativo" : "Inativo";
                    // Abre o modal de visualização
                    const viewModal = document.getElementById("viewUserModal");
                    viewModal.style.display = "block";
                } else {
                    showAlert("error", data.message);
                }
            })
            .catch(error => {
                showAlert("error", "Erro ao buscar dados do usuário: " + error.message);
                console.log(error.message);
            });
    }

    // Adicionar evento de fechamento do modal de visualização
    document.getElementById("viewUserModalClose").addEventListener("click", () => {
        document.getElementById("viewUserModal").style.display = "none";
    });

    // Função para ativar/desativar usuário
    function toggleActivation(userId) {
        fetch(`./scripts/users/toggle_activation.php?id=${userId}`, {
            method: "GET"
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    showAlert("success", data.message);
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert("error", data.message);
                }
            })
            .catch(error => {
                showAlert("error", "Erro ao alterar status do usuário: " + error.message);
            });
    }

    // Adicionando eventos aos botões
    document.getElementById("addUserBtn").addEventListener("click", openAddUserModal);
    document.getElementById("addUserForm").addEventListener("submit", addUser);

    // Tornar as funções globais para serem acessíveis nos botões
    window.editUser = editUser;
    window.deleteUser = deleteUser;
    window.viewUser = viewUser;
    window.toggleActivation = toggleActivation;
});
