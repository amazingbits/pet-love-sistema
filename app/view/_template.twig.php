<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{BASE_PATH}}/assets/css/style.css">
    <link rel="shortcut icon" href="{{BASE_PATH}}/assets/img/favicon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/2b3f85b228.js" crossorigin="anonymous"></script>
    <title>{% if title %} {{title}} {% else %} Pet Love - Sistema {% endif %}</title>
</head>
<body>

<div class="container">
{% block content %} {% endblock %}
</div>

<script src="{{BASE_PATH}}/assets/js/vendor/jquery.3.6.0.js"></script>
<script src="{{BASE_PATH}}/assets/js/scripts.js"></script>
</body>
</html>