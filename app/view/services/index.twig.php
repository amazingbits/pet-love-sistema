{% extends "_template.twig.php" %}
{% block content %}

<div class="title">
    <div style="background-color: #f57c00"></div>
    <h3 style="color: #f57c00">Serviços</h3>
    <div style="background-color: #f57c00"></div>
</div>

<div class="new-section">
    <a href="#" id="new-service-btn" style="background-color: #f57c00;"><i class="fas fa-plus"></i> Novo Serviço</a>
</div>

<div class="services">
    {% for i in 1..5 %}
    <div class="service">
        <h3 style="color: #f57c00;">Banho e Tosa</h3>
        <div>
            <a href="#" style="color: #f57c00;"><i class="fas fa-eye"></i></a>
        </div>
    </div>
    {% endfor %}
</div>

{% endblock %}