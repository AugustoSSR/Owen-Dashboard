// Funções para esconder/mostrar a sidebar
const sidebar = document.getElementById('sidebar');
const mainContent = document.querySelector('.main-content');

// Função para carregar os dados do dashboard
function loadDashboardData() {
    $.ajax({
        url: 'scripts/dashboard/dashboard_process.php',
        method: 'GET',
        success: function (response) {
            //console.log('Resposta recebida:', response);  // Log de depuração
            try {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    //console.log('Dados recebidos:', data); // Log adicional
                    document.getElementById('totalUsers').textContent = data.totalUsers;
                    document.getElementById('pendingUsers').textContent = data.pendingUsers;
                    document.getElementById('activeUsers').textContent = data.activeUsers;
                } else {
                    console.error('Erro ao carregar os dados do dashboard: ' + data.message);
                }
            } catch (e) {
                console.error('Erro ao analisar JSON:', e);
            }
        },
        error: function (xhr, status, error) {
            console.error('Erro na requisição AJAX:', error);
        }
    });
}

// Chamar a função para carregar os dados
loadDashboardData();

