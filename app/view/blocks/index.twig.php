{% extends "_template.twig.php" %}
{% block content %}

<div class="title">
    <div style="background-color: #f57c00"></div>
    <h3 style="color: #f57c00">Bloqueios</h3>
    <div style="background-color: #f57c00"></div>
</div>

{% if agendas == false %}
    <p>Você precisa cadastrar uma agenda para inserir um bloqueio para ela. Para cadastrar uma nova agenda,
        <a href="{{BASE_PATH}}/services">clique aqui</a>.</p>
{% else %}
    <div class="new-section">
        <a href="#" id="new-block-btn" style="background-color: #f57c00;"><i class="fas fa-plus"></i> Novo Bloqueio</a>
    </div>

    <div class="services">
        {% for bloqueio in bloqueios %}
        <div class="service">
            <h3 style="color: #f57c00;">{{bloqueio.descricao}}</h3>
            <div class="card-options">
                <a href="#" style="color: #f57c00;" title="Informações" data-id="{{bloqueio.id}}" class="infoBloqueio"><i
                            class="fas fa-eye"></i></a>
                <a href="#" style="color: #f57c00;" title="Remover" data-id="{{bloqueio.id}}" class="removerBloqueio"><i
                            class="fas fa-trash"></i></a>
            </div>
        </div>
        {% endfor %}
        {% if bloqueios == false %}
        <p>Nenhum bloqueio cadastrado...</p>
        {% endif %}
    </div>
{% endif %}

{% endblock %}

{% block js %}

<script>
    $("#new-block-btn").click(async function(e) {
        e.preventDefault();
        const agendas = await fetch(`{{API_URL}}/agenda/myappointments/{{userId}}`, {method: "GET"})
                              .then(function (response) {
                                  return response.json();
                              });
        let options = "";
        $.each(agendas, function(key, value) {
            options += `<option value="${value.id}">${value.descricao}</option>`;
        });
        let html = `
            <form method="post" id="novoBloqueio">
                <input type="hidden" name="usuario" id="usuario" value="{{userId}}" >
                <div>
                    <label for="descricao">Descrição</label>
                    <input type="text" name="descricao" id="descricao" required>
                </div>
                <div>
                    <label for="agenda">Agenda</label>
                    <select name="agenda" id="agenda">
                        ${options}
                    </select>
                </div>
                <div>
                    <label for="data_inicial">Data inicial</label>
                    <input type="date" name="data_inicial" id="data_inicial" required>
                </div>
                <div>
                    <label for="data_final">Data final</label>
                    <input type="date" name="data_final" id="data_final" required>
                </div>
                <div>
                    <input type="submit" value="Inserir">
                </div>
            </form>
        `;
        $(".modal .modal-body").html(html);
        $(".modal").addClass("modal-show");
    });

    $("body").on("submit", "#novoBloqueio", function(e) {
        e.preventDefault();
        const usuario = Number($("input[name='usuario']").val());
        const descricao = $("input[name='descricao']").val().trim();
        const agenda = Number($("select[name='agenda']").val());
        const data_inicial = $("input[name='data_inicial']").val();
        const data_final = $("input[name='data_final']").val();
        const data = JSON.stringify({descricao, agenda, usuario, data_inicial, data_final});

        $.ajax({
            url: `{{API_URL}}/bloqueio/save`,
            method: "POST",
            dataType: "json",
            processData: false,
            data: data,
            contentType: "application/json; charset=utf-8",
            error: function(error) {
                alert(error.responseJSON.message);
                return false;
            },
            success: function(response, responseText, xhr) {
                alert(response.message);
                if(xhr.status === 200 || xhr.status === 201) {
                    window.location.href = `{{BASE_PATH}}/blocks`;
                }
                return false;
            }
        });
    });

    $(".infoBloqueio").click(async function(e) {
        e.preventDefault();
        const id = Number($(this).attr("data-id"));
        const bloqueio = await fetch(`{{API_URL}}/bloqueio/${id}`, {method: "GET"})
                        .then(function(response) {
                            return response.json();
                        });
        const html = `
            <div>
                <p><b>Descrição:</b> ${bloqueio.descricao}</p>
                <p><b>Agenda:</b> ${bloqueio.descAgenda}</p>
                <p><b>Data inicial:</b> ${bloqueio.data_inicial}</p>
                <p><b>Data final:</b> ${bloqueio.data_final}</p>
            </div>
        `;
        $(".modal .modal-body").html(html);
        $(".modal").addClass("modal-show");
    });
    
    $(".removerBloqueio").click(function(e) {
        e.preventDefault();
        const id = Number($(this).attr("data-id"));
        const opt = confirm("Tem certeza que deseja remover este registro?");
        if(opt) {
            $.ajax({
                url: `{{API_URL}}/bloqueio/delete/${id}`,
                method: "DELETE",
                dataType: "json",
                processData: false,
                error: function(error) {
                    alert(error.responseJSON.message);
                    return false;
                },
                success: function(response, responseText, xhr) {
                    alert(response.message);
                    if(xhr.status === 200 || xhr.status === 201) {
                        window.location.href = `{{BASE_PATH}}/blocks`;
                    }
                    return false;
                }
            });
        } else {
            return false;
        }
    });
</script>

{% endblock %}