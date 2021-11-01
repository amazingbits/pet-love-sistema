{% extends "_template.twig.php" %}
{% block content %}

<div class="hotlinks">
    <div class="hl-links">
        <a href="{{BASE_PATH}}/schedule" class="hl-btn" style="background-color: #1e88e5;"><i class="fas fa-calendar-day"></i> Agenda</a>
        <a href="{{BASE_PATH}}/services" class="hl-btn" style="background-color: #f57c00;"><i class="fab fa-codepen"></i> Serviços</a>
    </div>
    <div class="hl-today">
        <p>{{now}}</p>
    </div>
</div>

<div class="title">
    <div></div>
    <h3>Próximos Dias</h3>
    <div></div>
</div>

<div class="my_agendas">
    <table>
        <thead>
            <tr>
                <th>Agenda</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Dia</th>
                <th>Hora</th>
            </tr>
        </thead>
        <tbody>
            {% for agenda in agendas %}
            <tr>
                <td>{{agenda.descAgenda}} - {{agenda.diaSemana}}</td>
                <td>{{agenda.descricao}}</td>
                <td>{{agenda.status}}</td>
                <td>{{agenda.data}}</td>
                <td>{{agenda.hora}}</td>
            </tr>
            {% endfor %}

            {% if agendas == null %}
            <tr>
                <td colspan="5">Nenhuma atividade encontrada...</td>
            </tr>
            {% endif %}
        </tbody>
    </table>
</div>

{% endblock %}