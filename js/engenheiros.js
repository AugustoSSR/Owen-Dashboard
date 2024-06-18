$(document).ready(function () {
    fetchEngenheiros();

    function fetchEngenheiros() {
        $.ajax({
            url: 'scripts/engenheiros/get_engenheiros.php',
            method: 'GET',
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    var engenheiros = data.engenheiros;
                    var table = $('#engenheiroTable').DataTable();
                    table.clear();
                    engenheiros.forEach(function (engenheiro) {
                        table.row.add([
                            engenheiro.id,
                            engenheiro.nome,
                            '<button class="btn edit-btn" onclick="editEngenheiro(' + engenheiro.id + ')">Editar</button>' +
                            '<button class="btn delete-btn" onclick="deleteEngenheiro(' + engenheiro.id + ')">Excluir</button>'
                        ]).draw();
                    });
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
            }
        });
    }

    $('#addEngenheiroForm').on('submit', function (e) {
        e.preventDefault();
        var engenheiroName = $('#engenheiroName').val();
        $.ajax({
            url: 'scripts/engenheiros/add_engenheiro.php',
            method: 'POST',
            data: { nome: engenheiroName },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#addEngenheiroModal').hide();
                    fetchEngenheiros();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
            }
        });
    });

    $('#editEngenheiroForm').on('submit', function (e) {
        e.preventDefault();
        var engenheiroId = $('#editEngenheiroId').val();
        var engenheiroName = $('#editEngenheiroName').val();
        $.ajax({
            url: 'scripts/engenheiros/edit_engenheiro.php',
            method: 'POST',
            data: { id: engenheiroId, nome: engenheiroName },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#editEngenheiroModal').hide();
                    fetchEngenheiros();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
            }
        });
    });

    window.editEngenheiro = function (id) {
        $.ajax({
            url: 'scripts/engenheiros/get_engenheiro.php',
            method: 'GET',
            data: { id: id },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    var engenheiro = data.engenheiro;
                    $('#editEngenheiroId').val(engenheiro.id);
                    $('#editEngenheiroName').val(engenheiro.nome);
                    $('#editEngenheiroModal').show();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
            }
        });
    };

    window.deleteEngenheiro = function (id) {
        if (confirm('Tem certeza que deseja deletar este engenheiro?')) {
            $.ajax({
                url: 'scripts/engenheiros/delete_engenheiro.php',
                method: 'POST',
                data: { id: id },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        fetchEngenheiros();
                    } else {
                        alert(data.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erro na requisição AJAX: ' + error);
                }
            });
        }
    };

    $('.close').on('click', function () {
        $(this).parent().parent().hide();
    });

    $('#addEngenheiroBtn').on('click', function () {
        $('#addEngenheiroModal').show();
    });
});
