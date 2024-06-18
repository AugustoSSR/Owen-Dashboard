$(document).ready(function () {
    fetchConcessionarias();

    function fetchConcessionarias() {
        $.ajax({
            url: 'scripts/concessionarias/get_concessionarias.php',
            method: 'GET',
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    var concessionarias = data.concessionarias;
                    var table = $('#concessionariaTable').DataTable();
                    table.clear();
                    concessionarias.forEach(function (concessionaria) {
                        table.row.add([
                            concessionaria.id,
                            concessionaria.nome,
                            '<button class="btn edit-btn" onclick="editConcessionaria(' + concessionaria.id + ')">Editar</button>' +
                            '<button class="btn delete-btn" onclick="deleteConcessionaria(' + concessionaria.id + ')">Excluir</button>'
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

    $('#addConcessionariaForm').on('submit', function (e) {
        e.preventDefault();
        var concessionariaName = $('#concessionariaName').val();
        $.ajax({
            url: 'scripts/concessionarias/add_concessionaria.php',
            method: 'POST',
            data: { nome: concessionariaName },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#addConcessionariaModal').hide();
                    fetchConcessionarias();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
            }
        });
    });

    $('#editConcessionariaForm').on('submit', function (e) {
        e.preventDefault();
        var concessionariaId = $('#editConcessionariaId').val();
        var concessionariaName = $('#editConcessionariaName').val();
        $.ajax({
            url: 'scripts/concessionarias/edit_concessionaria.php',
            method: 'POST',
            data: { id: concessionariaId, nome: concessionariaName },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#editConcessionariaModal').hide();
                    fetchConcessionarias();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
            }
        });
    });

    window.editConcessionaria = function (id) {
        $.ajax({
            url: 'scripts/concessionarias/get_concessionaria.php',
            method: 'GET',
            data: { id: id },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    var concessionaria = data.concessionaria;
                    $('#editConcessionariaId').val(concessionaria.id);
                    $('#editConcessionariaName').val(concessionaria.nome);
                    $('#editConcessionariaModal').show();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
            }
        });
    };

    window.deleteConcessionaria = function (id) {
        if (confirm('Tem certeza que deseja deletar esta concessionária?')) {
            $.ajax({
                url: 'scripts/concessionarias/delete_concessionaria.php',
                method: 'POST',
                data: { id: id },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        fetchConcessionarias();
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

    $('#addConcessionariaBtn').on('click', function () {
        $('#addConcessionariaModal').show();
    });
});
