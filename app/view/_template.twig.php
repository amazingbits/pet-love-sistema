<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{BASE_PATH}}/assets/css/style.css">
    <link rel="stylesheet" href="{{BASE_PATH}}/assets/css/vendor/jquery.ui.css">
    <link rel="shortcut icon" href="{{BASE_PATH}}/assets/img/favicon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/2b3f85b228.js" crossorigin="anonymous"></script>
    <title>{% if title %} {{title}} {% else %} Pet Love - Sistema {% endif %}</title>
</head>
<body>

<!--Loader-->
<div class="loader">
    <img src="{{BASE_PATH}}/assets/img/dog-walking.gif" alt="Carregando...">
</div>

<!--Modal-->
<div class="modal">
    <div class="modal-content">
        <div class="modal-title">
            <h3></h3>
            <a href="#" id="modal-close"><i class="fas fa-times"></i></a>
        </div>
        <div class="modal-body">
            <!--conteúdo do modal-->
        </div>
    </div>
</div>

<!--Alert-->
<div class="alert-default">
    <div class="alert-content">
        <div class="alert-title">
            <h3>Título do alerta</h3>
            <a href="#" class="alert-close"><i class="fas fa-times"></i></a>
        </div>
        <div class="alert-body">
            <p>Mensagem do alert</p>
        </div>
        <div class="alert-footer">
            <a href="" class="alert-btn">Ok</a>
        </div>
    </div>
</div>

<!--Toolbar-->
<div class="toolbar">
    <div class="tb-logo">
        <a href="{{BASE_PATH}}"><img src="{{BASE_PATH}}/assets/img/logo.png" alt="Pet Love"></a>
    </div>
    <div class="tb-options">
        <a href="#" class="tb-btn">Minha Conta</a>
        <a href="#" class="tb-logout" id="btn-logout"><i class="fas fa-sign-out-alt"></i></a>
    </div>
</div>

<div class="container">
{% block content %} {% endblock %}
</div>

<!--Footer-->
<div class="footer">
    <p>Desenvolvido com muito ❤ - Pet Love</p>
</div>

<script src="{{BASE_PATH}}/assets/js/vendor/jquery.3.6.0.js"></script>
<script src="{{BASE_PATH}}/assets/js/vendor/jquery.ui.js"></script>
{% block js %} {% endblock %}
<script src="{{BASE_PATH}}/assets/js/scripts.js"></script>
</body>
</html>