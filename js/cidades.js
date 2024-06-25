$(document).ready(function () {
    fetchCidades();

    function fetchCidades() {
        $.ajax({
            url: 'scripts/cidades/get_cidades.php',
            method: 'GET',
            success: function (response) {
                try {
                    console.log(response);  // Log para ver a resposta bruta
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        var cities = data.cidades;
                        console.log(cities);  // Log para ver a estrutura de 'cities'
                        if (Array.isArray(cities)) {
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
                            console.error('Erro: "cidades" não é uma matriz.');
                        }
                    } else {
                        alert(data.message);
                    }
                } catch (e) {
                    console.error('Erro ao analisar JSON: ' + e);
                    console.log('Resposta recebida: ' + response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
                console.log(xhr.responseText);  // Adiciona log para ver o texto da resposta
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
                try {
                    var data = JSON.parse(response);
                    console.log(data);
                    if (data.status === 'success') {
                        $('#addCityModal').hide();
                        fetchCidades();
                    } else {
                        alert(data.message);
                    }
                } catch (e) {
                    console.error('Erro ao analisar JSON: ' + e);
                    console.log('Resposta recebida: ' + response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
                console.log(xhr.responseText);
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
                try {
                    var data = JSON.parse(response);
                    console.log(data);
                    if (data.status === 'success') {
                        $('#editCityModal').hide();
                        fetchCidades();
                    } else {
                        alert(data.message);
                    }
                } catch (e) {
                    console.error('Erro ao analisar JSON: ' + e);
                    console.log('Resposta recebida: ' + response);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
                console.log(xhr.responseText);
            }
        });
    });

    window.editCity = function (id) {
        $.ajax({
            url: 'scripts/cidades/get_cidade.php',
            method: 'GET',
            data: { id: id },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status === 'success') {
                    var city = response.cidade;
                    $('#editCityId').val(city.id);
                    $('#editCityName').val(city.nome);
                    $('#editCityModal').show();
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erro na requisição AJAX: ' + error);
                console.log(xhr.responseText);
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
                    try {
                        var data = JSON.parse(response);
                        console.log(data);
                        if (data.status === 'success') {
                            fetchCidades();
                        } else {
                            alert(data.message);
                        }
                    } catch (e) {
                        console.error('Erro ao analisar JSON: ' + e);
                        console.log('Resposta recebida: ' + response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Erro na requisição AJAX: ' + error);
                    console.log(xhr.responseText);
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
});
