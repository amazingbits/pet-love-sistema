{% extends "_template.twig.php" %}
{% block content %}

<div class="title">
    <div style="background-color: #f57c00"></div>
    <h3 style="color: #f57c00">Serviços</h3>
    <div style="background-color: #f57c00"></div>
</div>

<div class="new-section">
    <a href="#" id="new-service-btn" style="background-color: #f57c00;"><i class="fas fa-plus"></i> Novo Serviço</a>
    <a href="{{BASE_PATH}}/blocks" style="background-color: #f57c00;"><i class="fas fa-plus"></i> Bloqueio</a>
</div>

<div class="services">
    {% for agenda in agendas %}
    <div class="service" style="background-color: {% if agenda.ativo == 1 %} rgba(56, 142, 60, 0.2) {% else %} rgba(239, 83, 80, 0.2) {% endif %};">
        <h3 style="color: #f57c00;">{{agenda.descricao}}</h3>
        <div>
            <a href="#" style="color: #f57c00;" title="Abrir" data-id="{{agenda.id}}" class="abrirAgenda"><i
                        class="fas fa-eye"></i></a>
        </div>
    </div>
    {% endfor %}
    {% if agendas == false %}
    <p>Nenhuma agenda cadastrada...</p>
    {% endif %}
</div>

{% endblock %}

{% block js %}
<script>
    $("#new-service-btn").click(function (e) {
        e.preventDefault();
        let html = `
        <form action="" method="POST" id="newService">
            <div>
                <label for="descricao">Serviço:</label>
                <input type="text" name="descricao" id="descricao" required>
            </div>
            <div>
                <label for="dia_semana">Dia da semana:</label>
                <select name="dia_semana" id="dia_semana" required>
                    <option value="0">Domingo</option>
                    <option value="1">Segunda</option>
                    <option value="2">Terça</option>
                    <option value="3">Quarta</option>
                    <option value="4">Quinta</option>
                    <option value="5">Sexta</option>
                    <option value="6">Sábado</option>
                </select>
            </div>
            <div>
                <label for="hora_inicio">Hora início:</label>
                <input type="time" name="hora_inicio" id="hora_inicio" required>
            </div>
            <div>
                <label for="hora_fim">Hora fim:</label>
                <input type="time" name="hora_fim" id="hora_fim" required>
            </div>
            <div>
                <label for="intervalo">Intervalo:</label>
                <select name="intervalo" id="intervalo" required>
                    <option value="10">10 minutos</option>
                    <option value="20">20 minutos</option>
                    <option value="30">30 minutos</option>
                </select>
            </div>
            <div>
                <input type="submit" style="background-color: #f57c00;" value="Inserir">
            </div>
        </form>
    `;
        $(".modal .modal-body").html(html);
        $(".modal").addClass("modal-show");
    });

    $("body").on("submit", "#newService", function(e) {
        e.preventDefault();
        e.preventDefault();
        const descricao = $("input[name='descricao']").val().trim();
        const dia_semana = Number($("select[name='dia_semana']").val());
        const hora_inicio = $("input[name='hora_inicio']").val().trim();
        const hora_fim = $("input[name='hora_fim']").val().trim();
        const intervalo_atendimento = Number($("select[name='intervalo']").val());
        const usuario = Number({{USER_ID}});

        const data = JSON.stringify({descricao, dia_semana, hora_inicio, hora_fim, intervalo_atendimento, usuario});

        $.ajax({
            url: `{{API_URL}}/agenda/save`,
            method: "POST",
            dataType: "json",
            processData: false,
            contentType: "application/json; charset=utf-8",
            data: data,
            error: function(error) {
                alert(error.responseJSON.message);
                return false;
            },
            success: function(response, responseText, xhr) {
                alert(response.message);
                if(xhr.status === 201 || xhr.status === 200) {
                    window.location.href = `{{BASE_PATH}}/services`;
                }
                return false;
            }
        });
    });

    $(".abrirAgenda").click(async function (e) {
        e.preventDefault();
        const diasSemana = ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"];
        const horarios = [10,20,30];
        const id = Number($(this).attr("data-id"));
        const agenda = await fetch(`{{API_URL}}/agenda/${id}`, {method: "GET"})
                       .then(function (response) {
                           return response.json();
                       })
                        .catch(function (error) {
                            return error.json();
                        });

        let btnVisibility = `<a href="#" id="disable" class="visibility" data-page="/services" data-endpoint="/agenda/changeVisibility/${agenda.id}/0">Desativar</a>`;
        if(Number(agenda.ativo) === 0) {
            btnVisibility = `<a href="#" id="enable" class="visibility" data-page="/services" data-endpoint="/agenda/changeVisibility/${agenda.id}/1">Ativar</a>`;
        }

        let html = `
            <form action="" method="POST" id="editService">
                <div class="formbtns">
                    ${btnVisibility}
                </div>
                <input type="hidden" name="id" id="id" value="${agenda.id}" >
                <input type="hidden" name="usuario" id="usuario" value="${agenda.usuario}" >
                <div>
                    <label for="descricao">Serviço:</label>
                    <input type="text" name="descricao" id="descricao" value="${agenda.descricao}">
                </div>
                <div>
                    <label for="dia_semana">Dia da semana:</label>
                    <select name="dia_semana" id="dia_semana">`;

        $.each(diasSemana, function(key, value) {
            if(key === Number(agenda.dia_semana)) {
                html += `<option value="${key}" selected>${value}</option>`;
            } else {
                html += `<option value="${key}">${value}</option>`;
            }
        });

        html +=      `</select>
                </div>
                <div>
                    <label for="hora_inicio">Hora início:</label>
                    <input type="time" name="hora_inicio" id="hora_inicio" value="${agenda.hora_inicio}">
                </div>
                <div>
                    <label for="hora_fim">Hora fim:</label>
                    <input type="time" name="hora_fim" id="hora_fim" value="${agenda.hora_fim}">
                </div>
                <div>
                    <label for="intervalo">Intervalo:</label>
                    <select name="intervalo" id="intervalo">`;

        $.each(horarios, function(key, value) {
            if(value === Number(agenda.intervalo_atendimento)) {
                html += `<option value="${value}" selected>${value} minutos</option>`;
            } else {
                html += `<option value="${value}">${value} minutos</option>`;
            }
        });

        html +=    `</select>
                </div>
                <div>
                    <input type="submit" style="background-color: #f57c00;" value="Salvar">
                </div>
            </form>
        `;
        $(".modal .modal-body").html(html);
        $(".modal").addClass("modal-show");
    });

    $("body").on("submit", "#editService", function(e) {
        e.preventDefault();
        const descricao = $("input[name='descricao']").val().trim();
        const dia_semana = Number($("select[name='dia_semana']").val());
        const hora_inicio = $("input[name='hora_inicio']").val().trim();
        const hora_fim = $("input[name='hora_fim']").val().trim();
        const intervalo_atendimento = Number($("select[name='intervalo']").val());
        const usuario = Number($("input[name='usuario']").val());
        const idAgenda = Number($("input[name='id']").val());

        const data = JSON.stringify({descricao, dia_semana, hora_inicio, hora_fim, intervalo_atendimento, usuario});

        $.ajax({
            url: `{{API_URL}}/agenda/update/${idAgenda}`,
            method: "PUT",
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            processData: false,
            data: data,
            error: function(error) {

                alert(error.responseJSON.message);
                return false;
            },
            success: function(response, responseText, xhr) {
                alert(response.message);
                if(xhr.status === 201 || xhr.status === 200) {
                    window.location.href = `{{BASE_PATH}}/services`;
                }
                return false;
            }
        });
    });
</script>
{% endblock %}