<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{BASE_PATH}}/assets/css/style.css">
    <link rel="shortcut icon" href="{{BASE_PATH}}/assets/img/favicon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/2b3f85b228.js" crossorigin="anonymous"></script>
    <title>Pet Love - Nova Empresa</title>
</head>
<body>

<div class="logo-alt">
    <a href="{{BASE_PATH}}"><img src="{{BASE_PATH}}/assets/img/logo.png" alt="Pet Love"></a>
</div>

<div class="container">
    <div class="title">
        <div></div>
        <h3>Nova Empresa</h3>
        <div></div>
    </div>

    <div class="form-img">
        <img src="{{BASE_PATH}}/assets/img/photo-icon.png" id="imgPreview" alt="Imagem">
    </div>

    <form action="" method="POST" id="novaEmpresa" enctype="multipart/form-data">
        <div>
            <div class="form-img-btn">
                <input type="file" name="img" id="img">
                <label for="img"><i class="fas fa-file"></i> Imagem</label>
            </div>
            
            <div class="form-2">
                <div>
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" autocomplete="off" autofocus>
                </div>
                <div>
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" autocomplete="off">
                </div>
            </div>
            
            <div class="form-2">
                <div>
                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" id="telefone" autocomplete="off">
                </div>
                <div>
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" autocomplete="off">
                </div>
            </div>
            
            <div class="form-2">
                <div>
                    <label for="cep">CEP:</label>
                    <input type="text" name="cep" id="cep" autocomplete="off">
                </div>
                <div>
                    <label for="rua">Rua:</label>
                    <input type="text" name="rua" id="rua" autocomplete="off">
                </div>
            </div>
            
            <div class="form-2">
                <div>
                    <label for="numero">Número:</label>
                    <input type="text" name="numero" id="numero" autocomplete="off">
                </div>
                <div>
                    <label for="complemento">Complemento:</label>
                    <input type="text" name="complemento" id="complemento" autocomplete="off">
                </div>
            </div>
            
            <div class="form-2">
                <div>
                    <label for="cidade">Cidade:</label>
                    <input type="text" name="cidade" id="cidade" autocomplete="off">
                </div>
                <div>
                    <label for="estado">Estado:</label>
                    <input type="text" name="estado" id="estado" autocomplete="off">
                </div>
            </div>
            
            <div>
                <input type="submit" value="Cadastrar">
            </div>
        </div>
    </form>
</div>

<script src="{{BASE_PATH}}/assets/js/vendor/jquery.3.6.0.js"></script>
<script src="{{BASE_PATH}}/assets/js/vendor/jquery.mask.js"></script>
<script src="{{BASE_PATH}}/assets/js/scripts.js"></script>
<script>
    $("input[name='telefone']").mask("(00)000000000");
    $("input[name='cep']").mask("00000-000");

    // Via CEP
    $(function() {

        function limpa_formulario() {
            $("input[name='rua']").val("");
            $("input[name='cidade']").val("");
            $("input[name='estado']").val("");
        }

        $("input[name='cep']").blur(function() {

            let cep = $(this).val().replace(/\D/g, '');

            if(cep.trim() !== "") {
                let regexCep = /^[0-9]{8}$/;
                if(regexCep.test(cep)) {
                    $("input[name='rua']").val("...");
                    $("input[name='cidade']").val("...");
                    $("input[name='estado']").val("...");

                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                        if(!("erro" in dados)) {
                            $("input[name='rua']").val(dados.logradouro);
                            $("input[name='cidade']").val(dados.localidade);
                            $("input[name='estado']").val(dados.uf);
                        } else {
                            limpa_formulario();
                        }
                    });
                } else {
                    limpa_formulario();
                }
            } else {
                limpa_formulario();
            }

        });
    });
</script>
</body>
</html>