$(document).ready(function () {
    const apiUrl = 'scripts/services';
    const apiGet = 'scripts/';

    // Carregar lista de serviços
    function loadServices() {
        $.ajax({
            url: `${apiUrl}/get_services.php`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    const serviceList = data.services.map(service => {
                        return `
                        <tr>
                            <td>${service.nome_projeto}</td>
                            <td>${service.cidade}</td>
                            <td>${service.empresa}</td>
                            <td>${service.concessionaria}</td>
                            <td>${service.metragem_total}</td>
                            <td>${service.quantidade_postes}</td>
                            <td>${service.numero_art}</td>
                            <td>${service.engenheiro}</td>
                            <td>${service.responsavel_empresa}</td>
                            <td>${service.responsavel_comercial}</td>
                            <td>
                                <button class="view-btn" data-id="${service.id}">Ver</button>
                                <button class="edit-btn" data-id="${service.id}">Editar</button>
                                <button class="delete-btn" data-id="${service.id}">Excluir</button>
                            </td>
                        </tr>
                    `;
                    }).join('');
                    $('#serviceList').html(serviceList);
                    $('#serviceTable').DataTable();
                } else {
                    alert('Erro ao carregar serviços');
                }
            },
            error: function (error) {
                console.error('Erro ao carregar serviços:', error);
            }
        });
    }


    // Carregar opções de cidades, empresas, concessionarias e engenheiros
    function loadOptions() {
        const endpoints = ['cidades/get_cidades.php', 'empresas/get_empresas.php', 'concessionarias/get_concessionarias.php', 'engenheiros/get_engenheiros.php'];
        const selects = ['#cidadeSelect', '#empresaSelect', '#concessionariaSelect', '#engenheiroSelect', '#editCidade', '#editEmpresa', '#editConcessionaria', '#editEngenheiro', '#cidade', '#empresa', '#concessionaria', '#engenheiro'];

        endpoints.forEach((endpoint, index) => {
            $.ajax({
                url: `${apiGet}/${endpoint}`,
                method: 'GET',
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        const options = data[Object.keys(data)[1]];
                        $(selects[index]).empty();
                        options.forEach(function (option) {
                            $(selects[index]).append('<option value="' + option.id + '">' + option.nome + '</option>');
                        });
                    } else {
                        console.error('Erro ao carregar opções: ' + data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao carregar ' + endpoint.split('_')[1] + ': ' + error);
                }
            });
        });
    }

    // Inicializar DataTables
    $('#serviceTable').DataTable();

    // Carregar dados iniciais
    loadServices();
    loadOptions();

    // Adicionar serviço
    $('#addServiceBtn').on('click', function () {
        $('#addServiceModal').show();
    });

    $('#addServiceModal .close').on('click', function () {
        $('#addServiceModal').hide();
    });

    $('#addServiceForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize(); // Serializa os dados do formulário
        $.ajax({
            url: 'scripts/services/add_service.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.success) {
                    $('#addServiceModal').hide();
                    loadServices();
                    alert('Serviço adicionado com sucesso');
                } else {
                    alert('Erro ao adicionar serviço: ' + data.error);
                }
            },
            error: function (error) {
                console.error('Erro ao adicionar serviço:', error);
            }
        });
    });

    // Visualizar serviço
    $(document).on('click', '.view-btn', function () {
        const id = $(this).data('id');
        $.ajax({
            url: `${apiUrl}/get_service.php`,
            method: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    const service = data.servico;
                    $('#viewNomeProjeto').text(service.nome_projeto);
                    $('#viewCidade').text(service.cidade);
                    $('#viewEmpresa').text(service.empresa);
                    $('#viewConcessionaria').text(service.concessionaria);
                    $('#viewMetragemTotal').text(service.metragem_total);
                    $('#viewQuantidadePostes').text(service.quantidade_postes);
                    $('#viewNumeroART').text(service.numero_art);
                    $('#viewEngenheiro').text(service.engenheiro);
                    $('#viewResponsavelEmpresa').text(service.responsavel_empresa);
                    $('#viewResponsavelComercial').text(service.responsavel_comercial);
                    // Assumindo que existe um campo 'postes' na resposta que é uma lista
                    const posteList = service.postes.map(poste => `<li>${poste.nome_rua}</li>`).join('');
                    $('#viewPosteList').html(posteList);
                    $('#viewServiceModal').show();
                } else {
                    alert('Erro ao carregar serviço');
                }
            },
            error: function (error) {
                console.error('Erro ao carregar serviço:', error);
            }
        });
    });


    $('#viewServiceModal .close').on('click', function () {
        $('#viewServiceModal').hide();
    });

    // Editar serviço
    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        $.ajax({
            url: `${apiUrl}/get_service.php`,
            method: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    const service = data.servico;
                    $('#editServiceId').val(service.id);
                    $('#editNomeProjeto').val(service.nome_projeto);
                    $('#editCidade').val(service.cidade_id);
                    $('#editEmpresa').val(service.empresa_id);
                    $('#editConcessionaria').val(service.concessionaria_id);
                    $('#editMetragemTotal').val(service.metragem_total);
                    $('#editQuantidadePostes').val(service.quantidade_postes);
                    $('#editNumeroART').val(service.numero_art);
                    $('#editEngenheiro').val(service.engenheiro_id);
                    $('#editResponsavelEmpresa').val(service.responsavel_empresa);
                    $('#editResponsavelComercial').val(service.responsavel_comercial);
                    const posteList = service.postes.map(poste => `
                        <li>
                            <input type="text" name="postes[]" value="${poste.nome_rua}" required>
                        </li>
                    `).join('');
                    $('#editPosteList').html(posteList);
                    $('#editServiceModal').show();
                } else {
                    alert('Erro ao carregar serviço');
                }
            },
            error: function (error) {
                console.error('Erro ao carregar serviço:', error);
            }
        });
    });

    $('#editServiceModal .close').on('click', function () {
        $('#editServiceModal').hide();
    });

    $('#editServiceForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            url: `${apiUrl}/update_service.php`,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    $('#editServiceModal').hide();
                    loadServices();
                    alert('Serviço atualizado com sucesso');
                } else {
                    alert('Erro ao atualizar serviço');
                }
            },
            error: function (error) {
                console.error('Erro ao atualizar serviço:', error);
            }
        });
    });

    // Excluir serviço
    $(document).on('click', '.delete-btn', function () {
        if (!confirm('Tem certeza que deseja excluir este serviço?')) return;

        const id = $(this).data('id');
        $.ajax({
            url: `${apiUrl}/delete_service.php`,
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    loadServices();
                    alert('Serviço excluído com sucesso');
                } else {
                    alert('Erro ao excluir serviço');
                }
            },
            error: function (error) {
                console.error('Erro ao excluir serviço:', error);
            }
        });
    });
});
