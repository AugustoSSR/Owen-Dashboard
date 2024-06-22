
$(document).ready(function () {
    const apiUrl = 'scripts/services';
    const apiGet = 'scripts/';

    // Função para carregar lista de serviços
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

    // Função para carregar opções de seleção
    function loadOptions(callback) {
        const endpoints = [
            { url: 'cidades/get_cidades.php', select: '#editCidade' },
            { url: 'empresas/get_empresas.php', select: '#editEmpresa' },
            { url: 'concessionarias/get_concessionarias.php', select: '#editConcessionaria' },
            { url: 'engenheiros/get_engenheiros.php', select: '#editEngenheiro' },
            { url: 'cidades/get_cidades.php', select: '#cidadeSelect' },
            { url: 'empresas/get_empresas.php', select: '#empresaSelect' },
            { url: 'concessionarias/get_concessionarias.php', select: '#concessionariaSelect' },
            { url: 'engenheiros/get_engenheiros.php', select: '#engenheiroSelect' }
        ];

        let completedRequests = 0;
        const totalRequests = endpoints.length;

        endpoints.forEach((endpoint) => {
            $.ajax({
                url: `${apiGet}/${endpoint.url}`,
                method: 'GET',
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        const options = data[Object.keys(data)[1]];
                        $(endpoint.select).empty();
                        options.forEach(function (option) {
                            $(endpoint.select).append('<option value="' + option.id + '">' + option.nome + '</option>');
                        });
                    } else {
                        console.error('Erro ao carregar opções: ' + data.message);
                    }
                    completedRequests++;
                    if (completedRequests === totalRequests && callback) {
                        callback();
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao carregar ' + endpoint.url.split('_')[1] + ': ' + error);
                    completedRequests++;
                    if (completedRequests === totalRequests && callback) {
                        callback();
                    }
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
        const formData = $(this).serialize();
        $.ajax({
            url: `${apiUrl}/add_service.php`,
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

                    const posteList = service.postes ? service.postes.map(poste => `<li>${poste.nome_rua}</li>`).join('') : '<li>Nenhum poste registrado</li>';
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
        loadOptions(function () {
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

                        const posteList = service.postes ? service.postes.map(poste => `
                            <tr>
                                <td><input type="text" name="nome_rua[]" value="${poste.nome_rua}" required></td>
                                <td><input type="number" name="numero_postes[]" value="${poste.numero_postes}" required></td>
                                <td><button type="button" class="removePosteBtn">Remover</button></td>
                            </tr>
                        `).join('') : '<tr><td colspan="3">Nenhum poste registrado</td></tr>';
                        $('#posteTable tbody').html(posteList);

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
    });

    $('#editServiceModal .close').on('click', function () {
        $('#editServiceModal').hide();
    });

    $('#editServiceForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        $.ajax({
            url: `${apiUrl}/edit_service.php`,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) {
                if (data.status === 'success') {
                    $('#editServiceMoal').hide();
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

    // Adicionar linha de poste
    $('#addPosteBtn').on('click', function () {
        const templateSource = $("#posteRowTemplate").html();
        const template = Handlebars.compile(templateSource);
        const context = {};
        const html = template(context);
        $('#posteTable tbody').append(html);
    });

    // Remover linha de poste
    $(document).on('click', '.removePosteBtn', function () {
        $(this).closest('tr').remove();
    });
});
