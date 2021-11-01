{% extends "_template.twig.php" %}
{% block content %}

<div class="title">
    <div></div>
    <h3>Agenda</h3>
    <div></div>
</div>

<div class="calendarSection">
    <label id="cdButton" for="cdHidden"><i class="fas fa-calendar"></i></label>
    <input type="text" class="datepicker" id="cdHidden">
    <div class="form-row">
        <label for="agenda">Selecione a agenda</label>
        <select name="agenda" id="agenda">
            {% for agenda in agendas %}
            <option value="{{agenda.id}}">{{agenda.descricao}} - {{agenda.dia_semana_ext}}</option>
            {% endfor %}
        </select>
    </div>
</div>

<div class="agDay">

</div>

<div class="legend">
    <div class="legend-single">
        <div style="background-color: #fff;"></div>
        <span>Marcada</span>
    </div>
    <div class="legend-single">
        <div style="background-color: #66BB6A;"></div>
        <span>Confirmada</span>
    </div>
    <div class="legend-single">
        <div style="background-color: #EF5350;"></div>
        <span>Cancelada</span>
    </div>
</div>

<div class="scheduleList">

    <p>Carregando lista de agendas...</p>

</div>

{% endblock %}

{% block js %}
<script>
    $("#cdHidden").datepicker({
        dateFormat: "yy-mm-dd",
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
        dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        nextText: 'Proximo',
        prevText: 'Anterior'
    });

    $(function(e) {
        setInterval(async function(e) {
            const today = new Date();
            let dt = $("#cdHidden").val().trim();
            if(dt.length === 0) {
                dt = today.getFullYear() + "-" + String(today.getMonth() + 1).padStart(2, "0") + "-" + String(today.getDate()).padStart(2, "0");
            }

            const hoje = dt.split("-");
            const dtBrl = hoje[2] + "/" + hoje[1] + "/" + hoje[0];
            $(".agDay").html(`<p>Agenda para o dia <b>${dtBrl}</b></p>`);
            const agenda = Number($("select[name='agenda']").val());
            const data = {data: dt, agenda};

            const scheduleList = await fetch(`{{API_URL}}/agendaitem/minhaagenda/${dt}/${agenda}`, {method: "GET"})
                                .then(function(response) {
                                    return response.json();
                                });

            let html = "";
            $.each(scheduleList, function(key, value) {
                if(value.id === undefined) {
                    html += `
                        <div class="schedule-card-empty" data-dt="${value.data}" data-hora="${value.hora}" data-agenda="${value.agenda}">
                            <p>${value.hora}</p>
                        </div>
                    `;
                } else {
                    let status = "";
                    if(value.status === "Confirmada") {
                        status = "sc-marked";
                    } else if (value.status === "Cancelada") {
                        status = "sc-cancelled";
                    }

                    html += `
                        <div class="schedule-card ${status}">
                            <div class="sc-info">
                                <img src="{{BASE_PATH}}/assets/img/dog-default.png" alt="Dog">
                                <p>${value.descricao}</p>
                                <p>${value.descAgenda} - ${value.diaSemanaExt}</p>
                                <p>${value.hora}</p>
                            </div>
                            <div class="sc-options">
                                <a href="#" class="abrirAgenda" title="Abrir" data-id="${value.id}"><i class="fas fa-eye"></i></a>
                                <a href="#" class="excluirAgenda" title="Excluir" data-id="${value.id}"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    `;
                }
            });

            $(".scheduleList").html(html);

        }, 4000);
    });

    $("html").on("click", ".schedule-card-empty", async function(e) {

        const dt = $(this).attr("data-dt");
        const hora = $(this).attr("data-hora");
        const agenda = Number($(this).attr("data-agenda"));
        const data = {data: dt, hora, agenda};
        const agInfo = await fetch(`{{API_URL}}/agenda/${agenda}`, {method: "GET"})
                            .then(function(response) {
                                return response.json();
                            });

        let html = `
            <form action="" method="POST" id="inserirAgenda">
                <div>
                    <label for="descricao">Descrição:</label>
                    <input type="text" name="descricao" id="descricao" autocomplete="off" required>
                </div>
                <div>
                    <label for="dia">Dia:</label>
                    <input type="date" name="dia" id="dia" value="${dt}" readonly>
                </div>
                <div>
                    <label for="hora">Hora:</label>
                    <input type="time" name="hora" id="hora" value="${hora}" readonly>
                </div>
                <div>
                    <label for="servico">Serviço:</label>
                    <select name="servico" id="servico">
                        <option value="${agInfo.id}">${agInfo.descricao} - ${agInfo.dia_semana_ext}</option>
                    </select>
                </div>
                <div>
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        <option value="Marcada">Marcada</option>
                        <option value="Confirmada">Confirmada</option>
                        <option value="Cancelada">Cancelada</option>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Inserir">
                </div>
            </form>
        `;

        $(".modal .modal-body").html(html);
        $(".modal").addClass("modal-show");
    });

    $("html").on("submit", "#inserirAgenda", function(e) {
        e.preventDefault();
        const descricao = $("input[name='descricao']").val().trim();
        const idAgenda = Number($("select[name='servico']").val());
        const dia = $("input[name='dia']").val();
        const hora = $("input[name='hora']").val();
        const status = $("select[name='status']").val();
        const data = JSON.stringify({agenda: idAgenda, descricao, data: dia, hora, status});

        $.ajax({
            url: `{{API_URL}}/agendaitem/save`,
            method: "POST",
            dataType: "json",
            processData: false,
            contentType: "application/json; charset=utf-8",
            data: data,
            error: function(error) {
                console.log(error);
                alert(error.responseJSON.message);
                return false;
            },
            success: function(response, responseText, xhr) {
                alert(response.message);
                if(xhr.status === 201) {
                    $(".modal").removeClass("modal-show");
                }
            }
        });
    });

    $("html").on("click", ".excluirAgenda", function(e) {
        e.preventDefault();
        const idAgenda = Number($(this).attr("data-id"));
        const opt = confirm("Tem certeza que deseja excluir este registro?");
        if(opt) {
            $.ajax({
                url: `{{API_URL}}/agendaitem/delete/${idAgenda}`,
                method: "DELETE",
                processData: false,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                error: function(error) {
                    alert(error.responseJSON.message);
                    return false;
                },
                success: function(response) {
                    alert(response.message);
                }
            });
        }
    });

    $("html").on("click", ".abrirAgenda", async function(e) {
        e.preventDefault();
        const idAgenda = Number($(this).attr("data-id"));
        const agenda = await fetch(`{{API_URL}}/agendaitem/${idAgenda}`, {method: "GET"})
                            .then(function(response) {
                                return response.json();
                            });

        const marcada = agenda.status === "Marcada" ? "selected" : "";
        const confirmada = agenda.status === "Confirmada" ? "selected" : "";
        const cancelada = agenda.status === "Cancelada" ? "selected" : "";

        const html = `
            <form action="" method="POST" id="alterarAgenda">
                <input type="hidden" name="id" id="id" value="${agenda.id}" >
                <div>
                    <label for="descricao">Descrição:</label>
                    <input type="text" name="descricao" id="descricao" value="${agenda.descricao}" autocomplete="off" required>
                </div>
                <div>
                    <label for="dia">Dia:</label>
                    <input type="date" name="dia" id="dia" value="${agenda.data}" readonly>
                </div>
                <div>
                    <label for="hora">Hora:</label>
                    <input type="time" name="hora" id="hora" value="${agenda.hora}" readonly>
                </div>
                <div>
                    <label for="servico">Serviço:</label>
                    <select name="servico" id="servico">
                        <option value="${agenda.agenda}">${agenda.descAgenda} - ${agenda.diaSemana}</option>
                    </select>
                </div>
                <div>
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        <option value="Marcada" ${marcada}>Marcada</option>
                        <option value="Confirmada" ${confirmada}>Confirmada</option>
                        <option value="Cancelada" ${cancelada}>Cancelada</option>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Salvar">
                </div>
            </form>
        `;
        $(".modal .modal-body").html(html);
        $(".modal").addClass("modal-show");
    });

    $("html").on("submit", "#alterarAgenda", function(e) {
        e.preventDefault();
        const descricao = $("input[name='descricao']").val().trim();
        const status = $("select[name='status']").val();
        const id = Number($("input[name='id']").val());
        const data = JSON.stringify({descricao, status});

        $.ajax({
            url: `{{API_URL}}/agendaitem/update/${id}`,
            method: "PUT",
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
                if(xhr.status === 200 || xhr.status === 201) {
                    $(".modal").removeClass("modal-show");
                }
            }
        });
    });
</script>
{% endblock %}