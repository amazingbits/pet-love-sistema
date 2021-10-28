{% extends "_template.twig.php" %}
{% block content %}

<div class="title">
    <div></div>
    <h3>Minha Conta</h3>
    <div></div>
</div>

<div class="form-img">
    <img src="{{BASE_PATH}}/assets/media/user_img/{{usuario.path_url}}" id="imgPreview" alt="Imagem">
</div>

<form action="" method="POST" id="editarEmpresa" enctype="multipart/form-data">
    <input type="hidden" name="userId" id="userId" value="{{usuario.id}}">
    <div>
        <div class="form-img-btn">
            <input type="file" name="img" id="img">
            <label for="img"><i class="fas fa-file"></i> Imagem</label>
        </div>

        <div class="form-2">
            <div>
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" value="{{usuario.email}}" autocomplete="off" autofocus>
            </div>
            <div>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" value="{{usuario.nome}}" autocomplete="off">
            </div>
        </div>

        <div class="form-2">
            <div>
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" value="{{usuario.telefone}}" autocomplete="off">
            </div>
            <div>
                <label for="senha">Nova Senha:</label>
                <input type="password" name="senha" id="senha" autocomplete="off">
            </div>
        </div>

        <!--Map-->
        <div id="map" style="width: 100%; height: 200px; border-radius: 15px; margin: 25px 0;"></div>

        <div class="form-2">
            <div>
                <label for="cep">CEP:</label>
                <input type="text" name="cep" id="cep" value="{{endereco.cep}}" autocomplete="off">
            </div>
            <div>
                <label for="rua">Rua:</label>
                <input type="text" name="rua" id="rua" value="{{endereco.rua}}" autocomplete="off">
            </div>
        </div>

        <div class="form-2">
            <div>
                <label for="numero">Número:</label>
                <input type="text" name="numero" id="numero" value="{{endereco.numero}}" autocomplete="off">
            </div>
            <div>
                <label for="complemento">Complemento:</label>
                <input type="text" name="complemento" id="complemento" value="{{endereco.complemento}}" autocomplete="off">
            </div>
        </div>

        <div class="form-2">
            <div>
                <label for="cidade">Cidade:</label>
                <input type="text" name="cidade" id="cidade" value="{{endereco.cidade}}" autocomplete="off">
            </div>
            <div>
                <label for="estado">Estado:</label>
                <input type="text" name="estado" id="estado" value="{{endereco.estado}}" autocomplete="off">
            </div>
        </div>

        <input type="hidden" name="idEndereco" id="idEndereco" value="{{endereco.id}}">
        <input type="hidden" name="latitude" id="latitude" value="{{endereco.latitude}}" autocomplete="off">
        <input type="hidden" name="longitude" id="longitude" value="{{endereco.longitude}}" autocomplete="off">

        <div>
            <input type="submit" value="Salvar">
        </div>
    </div>
</form>

{% endblock %}

{% block css %}
<script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
{% endblock %}

{% block js %}
<script src="{{BASE_PATH}}/assets/js/vendor/jquery.mask.js"></script>
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

    const actualLat = parseFloat($("input[name='latitude']").val());
    const actualLong = parseFloat($("input[name='longitude']").val());
    const actualCoords = [actualLat, actualLong];
    mapboxgl.accessToken = "pk.eyJ1Ijoic3VwZXJtcm1vbmtzIiwiYSI6ImNrdjlsenBwajBieXEyeG5vanZ0NzBsN28ifQ.urh3DZFf-3fn1utGRSSv2w";
    map = new mapboxgl.Map({
        container: "map",
        style: "mapbox://styles/mapbox/dark-v10",
        center: actualCoords,
        zoom: 15
    });

    map.on("load", function() {
        map.addSource("source", {
            type: "geojson",
            data: {
                type: "FeatureCollection",
                features: [
                    {
                        type: "Feature",
                        geometry: {
                            type: "Point",
                            coordinates: actualCoords
                        },
                        properties: {}
                    }
                ]
            }
        });

        map.addLayer({
            id: "source",
            source: "source",
            type: "circle",
            paint: {
                "circle-radius": 10,
                "circle-color": "#007cbf"
            }
        });
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

    $("#editarEmpresa").submit(async function(e) {
        e.preventDefault();

        const img = $("input[name='img']")[0].files[0];

        // verificar se há imagem
        if (img !== undefined) {

            //inserção de imagem
            // verificar extensão
            const imgName = img.name;
            const imgNameSplit = imgName.split(".");
            const imgFormat = imgNameSplit[imgNameSplit.length - 1].toLowerCase();
            if (imgFormat !== "jpeg" && imgFormat !== "jpg" && imgFormat !== "png" && imgFormat !== "gif") {
                alert("Só são aceitas imagens nos seguintes formatos: JPEG, JPG e PNG");
                return false;
            }

            // verificar tamanho
            const tamanhoPermitido = 2000000; //2mb
            if (img.size > tamanhoPermitido) {
                alert("Só são permitidas imagens de até 2mb!");
                return false;
            }

            const actualImgName = `{{usuario.path_url}}`;
            const data = new FormData();
            data.append("file", img);

            $.ajax({
                url: `{{BASE_PATH}}/user/changeimage/${actualImgName}`,
                method: "POST",
                dataType: "json",
                data: data,
                async: true,
                processData: false,
                contentType: false,
                error: function(error) {
                    alert(error.responseJSON.message);
                    return false;
                },
                success: function(response) {
                    console.log(response);
                }
            });
        }

        // objeto usuário
        const email = $("input[name='email']").val().trim();
        const nome = $("input[name='nome']").val().trim();
        let telefone = $("input[name='telefone']").val().trim();
        const senha = $("input[name='senha']").val().trim();
        const userId = Number($("input[name='userId']").val().trim());
        if(telefone.length > 0) {
            telefone = telefone.replaceAll(/[^0-9]+/g, "");
        }

        const objUser = JSON.stringify({nome, email, telefone, path_url: `{{usuario.path_url}}`, tipo_usuario: 2});

        const updateUser = await fetch(`{{API_URL}}/usuario/update/${userId}`, {
            method: "PUT",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: objUser
        }).then(function(response) {
            return response;
        });

        if(updateUser.status !== 201) {
            alert("Houve um problema ao alterar as informações do usuário. Tente novamente mais tarde!");
            return false;
        }

        // Objeto endereço
        const rua = $("input[name='rua']").val().trim();
        let cep = $("input[name='cep']").val().trim();
        const numero = $("input[name='numero']").val().trim();
        const complemento = $("input[name='complemento']").val().trim();
        const cidade = $("input[name='cidade']").val().trim();
        const estado = $("input[name='estado']").val().trim();
        const latitude = $("input[name='latitude']").val().trim();
        const longitude = $("input[name='longitude']").val().trim();
        const idEndereco = Number($("input[name='idEndereco']").val().trim());
        const objEndereco = JSON.stringify({cep, rua, numero, complemento, cidade, estado, latitude, longitude, usuario: userId});

        const updateEndereco = await fetch(`{{API_URL}}/endereco/update/${userId}`, {
            method: "PUT",
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: objEndereco
        }).then(function(response) {
            return response;
        });

        if(updateUser.status !== 201) {
            alert("Houve um problema ao atualizar as informações do usuário. Tente novamente mais tarde.");
            return false;
        }

        if(updateEndereco.status !== 201) {
            alert("Houve um problema ao atualizar as informações do endereço do usuário. Tente novamente mais tarde.");
            return false;
        }

        if(senha.length > 0) {
            const objSenha = JSON.stringify({senha});
            const updatePassword = fetch(`{{API_URL}}/usuario/updatepassword/${userId}`, {
                method: "PUT",
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: objSenha
            }).then(function(response) {
                return response;
            });

            if(updatePassword.status !== 200) {
                alert("Houve um problema ao atualizar a nova senha do usuário. Tente novamente mais tarde.");
                return false;
            }
        }

    });
</script>
{% endblock %}