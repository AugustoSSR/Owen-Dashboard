$(document).ready(function () {
    fetchCidades();

    function fetchCidades() {
        $.ajax({
            url: 'scripts/cidades/get_cidade.php',
            method: 'GET',
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    var cities = data.cidades;
                    var table = $('#cityTable').DataTable();
                    table.clear();
                    cities.forEach(function (city) {
                        table.row.add([
                            city.id,
                            city.nome,
                            '<button class="btn edit-btn" onclick="editCity(' + city.id + ')">Editar</button>' +
                            '<button class="btn delete-btn" onclick="deleteCity(' + city.id + ')">Excluir</button>'
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

    $('#addCityForm').on('submit', function (e) {
        e.preventDefault();
        var cityName = $('#cityName').val();
        $.ajax({
            url: 'scripts/cidades/add_cidade.php',
            method: 'POST',
            data: { nome: cityName },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#addCityModal').hide();
                    fetchCidades();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
            }
        });
    });

    $('#editCityForm').on('submit', function (e) {
        e.preventDefault();
        var cityId = $('#editCityId').val();
        var cityName = $('#editCityName').val();
        $.ajax({
            url: 'scripts/cidades/edit_cidade.php',
            method: 'POST',
            data: { id: cityId, nome: cityName },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    $('#editCityModal').hide();
                    fetchCidades();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
            }
        });
    });

    window.editCity = function (id) {
        $.ajax({
            url: 'scripts/cidades/get_cidades.php',
            method: 'GET',
            data: { id: id },
            success: function (response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    var city = data.cidade;
                    $('#editCityId').val(city.id);
                    $('#editCityName').val(city.nome);
                    $('#editCityModal').show();
                } else {
                    alert(data.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
            }
        });
    };

    window.deleteCity = function (id) {
        if (confirm('Tem certeza que deseja deletar esta cidade?')) {
            $.ajax({
                url: 'scripts/cidades/delete_cidade.php',
                method: 'POST',
                data: { id: id },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        fetchCidades();
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

    $('#addCityBtn').on('click', function () {
        $('#addCityModal').show();
    });

    // Inicializa o DataTable
    $('#cityTable').DataTable();
});
