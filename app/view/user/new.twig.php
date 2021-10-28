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
    <!--Map Box-->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
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

            <!--Map-->
            <div id="map" style="width: 100%; height: 200px; border-radius: 15px; margin: 25px 0;"></div>

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

            <input type="hidden" name="latitude" id="latitude" value="0" autocomplete="off">
            <input type="hidden" name="longitude" id="longitude" value="0" autocomplete="off">
            
            <div>
                <input type="submit" value="Cadastrar">
            </div>
        </div>
    </form>
</div>

<script src="{{BASE_PATH}}/assets/js/vendor/jquery.3.6.0.js"></script>
<script src="{{BASE_PATH}}/assets/js/vendor/jquery.ui.js"></script>
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

    mapboxgl.accessToken = "pk.eyJ1Ijoic3VwZXJtcm1vbmtzIiwiYSI6ImNrdjlsenBwajBieXEyeG5vanZ0NzBsN28ifQ.urh3DZFf-3fn1utGRSSv2w";
    map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/dark-v10",
        center: [-48.5444781, -27.5951631],
        zoom: 15
    });

    $("input[name='cep'], input[name='rua'], input[name='numero'], input[name='cidade'], input[name='estado']").focusout(async function(e) {
        setTimeout(async function() {
            const rua = $("input[name='rua']").val().trim();
            const numero = $("input[name='numero']").val().trim();
            const cidade = $("input[name='cidade']").val().trim();
            const estado = $("input[name='estado']").val().trim();
            let query = "";
            if(rua.length > 0) query += ` ${rua} `;
            if(numero.length > 0) query += ` ${numero} `;
            if(cidade.length > 0) query += ` ${cidade} `;
            if(estado.length > 0) query += ` ${estado} `;
            query = query.trim();
            query = query.replaceAll("  ", " ");

            const accessToken = "pk.eyJ1Ijoic3VwZXJtcm1vbmtzIiwiYSI6ImNrdjlsenBwajBieXEyeG5vanZ0NzBsN28ifQ.urh3DZFf-3fn1utGRSSv2w";
            const apiPath = `https://api.mapbox.com/geocoding/v5/mapbox.places/${query}.json?access_token=${accessToken}`;

            if(query.trim().length > 0) {
                const localMap = await fetch(apiPath, {method: "GET"})
                    .then(function (response) {
                        return response.json();
                    })
                    .catch(function (error) {
                        return error.json();
                    });

                if(localMap.features.length > 0) {
                    const point = localMap.features[0];
                    const latitude = parseFloat(point.center[0]);
                    const longitude = parseFloat(point.center[1]);
                    $("input[name='latitude']").val(latitude);
                    $("input[name='longitude']").val(longitude);
                    const coords = [latitude, longitude];
                    map.flyTo({center: coords});

                    map.getStyle().layers.forEach(function (layer) {
                        if(layer.id.match(/source/g)) {
                            map.removeLayer(layer.id);
                            map.removeSource(layer.id);
                        }
                    });

                    const source = Math.ceil((Math.random() * 1000000 - 1 + 1) + 1);
                    const sId = "source" + source;

                    map.addSource(sId, {
                        type: "geojson",
                        data: {
                            type: "FeatureCollection",
                            features: [
                                {
                                    type: "Feature",
                                    geometry: {
                                        type: "Point",
                                        coordinates: coords
                                    },
                                    properties: {}
                                }
                            ]
                        }
                    });

                    map.addLayer({
                        id: sId,
                        source: sId,
                        type: "circle",
                        paint: {
                            "circle-radius": 10,
                            "circle-color": "#007cbf"
                        }
                    });
                }
            }
        }, 500);
    });
</script>
</body>
</html>