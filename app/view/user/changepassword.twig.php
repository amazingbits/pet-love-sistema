<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{BASE_PATH}}/assets/img/favicon.png" type="image/x-icon">
    <title>Pet Love - Nova Senha</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap');

        * {
            padding: 0;
            margin: 0;
            border: none;
            box-sizing: border-box;
            outline: none;
            text-decoration: none;
            list-style: none;
            font-family: 'Poppins', sans-serif;
        }

        .form-btn {
            font-weight: 700;
            color: #456DB0;
            font-size: 11px;
        }

        form {
            margin: 10px 0;
        }

        form label {
            font-size: 12px;
            line-height: 22px;
            font-weight: 300;
            color: #456DB0;
        }

        form input[type="text"],
        form input[type="password"],
        form input[type="date"],
        form input[type="email"],
        form input[type="file"],
        form input[type="time"],
        form select,
        form textarea {
            width: 100%;
            margin: 8px 0 16px;
            padding: 6px;
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #424242;
            font-size: 15px;
            line-height: 25px;
            border-bottom: 4px solid #fff;
            transition: all .3s linear;
        }

        form input[type="text"]:focus,
        form input[type="password"]:focus,
        form input[type="date"]:focus,
        form input[type="email"]:focus,
        form input[type="file"]:focus,
        form input[type="time"]:focus,
        form select:focus,
        form textarea:focus {
            border-bottom: 4px solid #456DB0;
        }

        form input[type="submit"] {
            width: 100%;
            padding: 8px;
            background-color: #456DB0;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
        }

        .login-box {
            width: 98%;
            max-width: 400px;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate3d(-50%, -50%, 0);
            padding: 20px;
            box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-box img {
            max-width: 120px;
        }

        .options {
            text-align: left;
            margin: 35px 0 15px;
        }

        .options a {
            padding: 8px;
            border: 2px solid #456DB0;
            color: #456DB0;
            background-color: #fff;
            font-size: 12px;
            line-height: 22px;
        }

        .infobox {
            background-color: rgba(237, 237, 237, 0.4);
            margin: 15px 0 25px;
            padding: 6px 12px;
            text-align: left;
        }

        .infobox span {
            color: #636363;
            font-weight: 300;
            font-size: 12px;
        }

        .result {
            padding: 12px;
            box-shadow: 0 0 4px 0 rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            display: none;
        }

        .r-green {
            background-color: #388e3c;
        }

        .r-red {
            background-color: #EF5350;
        }

        .load {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 10;
            display: none;
        }
    </style>
</head>
<body>
<div class="login-box">
    <div class="result r-red">
        <p>E-mail enviado com sucesso!</p>
    </div>
    <img src="{{BASE_PATH}}/assets/img/logo.png" alt="Pet Love">
    <div class="options">
        <a href="{{BASE_PATH}}">Voltar</a>
    </div>

    <form action="" method="POST" id="changePassword">
        <input type="hidden" name="idUser" id="idUser" value="{{idUser}}">
        <div>
            <input type="text" name="codigo" id="codigo" placeholder="Código" autocomplete="no" autofocus required>
        </div>
        <div>
            <input type="password" name="senha" id="senha" placeholder="Nova senha" autocomplete="no" autofocus required>
        </div>
        <div>
            <input type="submit" value="Mudar senha">
        </div>
    </form>
</div>
<div class="load"></div>
<script src="{{BASE_PATH}}/assets/js/vendor/jquery.3.6.0.js"></script>
<script src="{{BASE_PATH}}/assets/js/vendor/jquery.ui.js"></script>
<script src="{{BASE_PATH}}/assets/js/scripts.js"></script>
</body>
</html>