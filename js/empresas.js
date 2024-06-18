$(document).ready(function () {
    fetchEmpresas();

    function fetchEmpresas() {
        $.ajax({
            url: 'scripts/empresas/get_empresas.php',
            method: 'GET',
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    var empresas = data.empresas;
                    var table = $('#empresaTable').DataTable();
                    table.clear();
                    empresas.forEach(function (empresa) {
                        table.row.add([
                            empresa.id,
                            empresa.nome,
                            '<button class="btn edit-btn" onclick="editEmpresa(' + empresa.id + ')">Editar</button>' +
                            '<button class="btn delete-btn" onclick="deleteEmpresa(' + empresa.id + ')">Excluir</button>'
                        ]).draw();
                    });
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro ao buscar empresas: ' + error);
            }
        });
    }

    $('#addEmpresaForm').on('submit', function (e) {
        e.preventDefault();
        var empresaName = $('#empresaName').val();
        $.ajax({
            url: 'scripts/empresas/add_empresa.php',
            method: 'POST',
            data: { nome: empresaName },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#addEmpresaModal').hide();
                    fetchEmpresas();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro ao adicionar empresa: ' + error);
            }
        });
    });

    $('#editEmpresaForm').on('submit', function (e) {
        e.preventDefault();
        var empresaId = $('#editEmpresaId').val();
        var empresaName = $('#editEmpresaName').val();
        $.ajax({
            url: 'scripts/empresas/edit_empresa.php',
            method: 'POST',
            data: { id: empresaId, nome: empresaName },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#editEmpresaModal').hide();
                    fetchEmpresas();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro ao editar empresa: ' + error);
            }
        });
    });

    window.editEmpresa = function (id) {
        $.ajax({
            url: 'scripts/empresas/get_empresa.php',
            method: 'GET',
            data: { id: id },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    var empresa = data.empresa;
                    $('#editEmpresaId').val(empresa.id);
                    $('#editEmpresaName').val(empresa.nome);
                    $('#editEmpresaModal').show();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro ao buscar empresa: ' + error);
            }
        });
    };

    window.deleteEmpresa = function (id) {
        if (confirm('Tem certeza que deseja deletar esta empresa?')) {
            $.ajax({
                url: 'scripts/empresas/delete_empresa.php',
                method: 'POST',
                data: { id: id },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        fetchEmpresas();
                    } else {
                        alert(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erro ao deletar empresa: ' + error);
                }
            });
        }
    };

    $('.close').on('click', function () {
        $(this).parent().parent().hide();
    });

    $('#addEmpresaBtn').on('click', function () {
        $('#addEmpresaModal').show();
    });
});
