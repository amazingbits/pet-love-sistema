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

<div class="schedule-card sc-cancelled">
    <div class="sc-info">
        <img src="{{BASE_PATH}}/assets/img/dog-default.png" alt="Dog">
        <p>Rex <i class="fas fa-mars"></i></p>
        <p>Banho e Tosa</p>
        <p>10:00</p>
    </div>
    <div class="sc-options">
        <a href="#" class="abrirExame" title="Abrir"><i class="fas fa-eye"></i></a>
        <a href="#" title="Whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
        <a href="#" title="Telefone"><i class="fas fa-phone"></i></a>
    </div>
</div>

<div class="schedule-card sc-marked">
    <div class="sc-info">
        <img src="{{BASE_PATH}}/assets/img/dog-default.png" alt="Dog">
        <p>Lilica <i class="fas fa-venus"></i></p>
        <p>Banho e Tosa</p>
        <p>10:30</p>
    </div>
    <div class="sc-options">
        <a href="#" class="abrirExame" title="Abrir"><i class="fas fa-eye"></i></a>
        <a href="#" title="Whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
        <a href="#" title="Telefone"><i class="fas fa-phone"></i></a>
    </div>
</div>

<div class="schedule-card sc-marked">
    <div class="sc-info">
        <img src="{{BASE_PATH}}/assets/img/dog-default.png" alt="Dog">
        <p>Romeu <i class="fas fa-mars"></i></p>
        <p>Banho e Tosa</p>
        <p>11:00</p>
    </div>
    <div class="sc-options">
        <a href="#" class="abrirExame" title="Abrir"><i class="fas fa-eye"></i></a>
        <a href="#" title="Whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
        <a href="#" title="Telefone"><i class="fas fa-phone"></i></a>
    </div>
</div>

<div class="schedule-card">
    <div class="sc-info">
        <img src="{{BASE_PATH}}/assets/img/dog-default.png" alt="Dog">
        <p>Toby <i class="fas fa-mars"></i></p>
        <p>Banho e Tosa</p>
        <p>11:30</p>
    </div>
    <div class="sc-options">
        <a href="#" class="abrirExame" title="Abrir"><i class="fas fa-eye"></i></a>
        <a href="#" title="Whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a>
        <a href="#" title="Telefone"><i class="fas fa-phone"></i></a>
    </div>
</div>

{% endblock %}
