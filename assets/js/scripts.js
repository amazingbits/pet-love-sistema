const path = "http://localhost/petlove/sistema";
const apiPath = "http://localhost/petlove/api-new";

$(window).on("load", function (e) {
    $(".loader").fadeOut();
});

$("#modal-close").click(function (e) {
    e.preventDefault();
    $(".modal").removeClass("modal-show");
    $(".modal .modal-body").html("");
});

$(".abrirExame").click(function (e) {
    e.preventDefault();
    let html = `
        <div class="animal-resume">
                <img src="${path}/assets/img/dog-default.png" alt="Dog">
                <h3>Rex <i class="fas fa-mars"></i></h3>
                <div class="animal-info">
                    <p>2 anos</p>
                    <p>Bravo</p>
                    <p>Vira-lata</p>
                </div>
                <div class="animal-owner">
                    <p><strong>Dono</strong>: Carlos Oliveira</p>
                </div>
            </div>

            <a href="#" class="form-btn">Excluir</a>
            <form action="" method="POST">
                <div>
                    <label for="dia">Dia:</label>
                    <input type="date" name="dia" id="dia">
                </div>
                <div>
                    <label for="hora">Hora:</label>
                    <input type="time" name="hora" id="hora">
                </div>
                <div>
                    <label for="servico">Serviço:</label>
                    <select name="servico" id="servico">
                        <option value="0">Banho e tosa</option>
                    </select>
                </div>
                <div>
                    <label for="status">Status:</label>
                    <select name="status" id="status">
                        <option value="0">Marcada</option>
                        <option value="1">Confirmada</option>
                        <option value="2">Cancelada</option>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Salvar">
                </div>
            </form>
    `;
    $(".modal .modal-body").html(html);
    $(".modal").addClass("modal-show");
});

$("#authForm").submit(function (e) {
    e.preventDefault();
    const email = $("input[name='email']").val();
    const senha = $("input[name='senha']").val();
    const data = {email, senha};

    $.ajax({
        url: apiPath + "/auth/login",
        method: "POST",
        dataType: "json",
        processData: false,
        data: JSON.stringify(data),
        contentType: "application/json; charset=utf-8",
        error: function (error) {
            console.clear();
            if (error.status === 404) {
                alert("Usuário e/ou senha não encontrados!");
                return false;
            } else {
                alert("Houve um problema com esta requisição. Tente novamente mais tarde!");
                return false;
            }
        },
        success: function (response, textStatus, xhr) {
            alert(response.message);
            if (xhr.status === 200) {
                let hash = response.hash;
                setCookie("hash", hash, 10);
                window.location.href = path;
            }
        }
    });
});

$("#btn-logout").click(function (e) {
    e.preventDefault();
    let opt = confirm("Tem certeza que deseja sair?");
    if (opt) {
        eraseCookie("hash");
        window.location.href = path;
    } else {
        return false;
    }
});

$("#novaEmpresa").submit(function (e) {
    e.preventDefault();
    const img = $("input[name='img']")[0].files[0];

    // verificar se há imagem
    if (img === undefined) {
        alert("É preciso inserir uma imagem!");
        return false;
    }

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

    const data = new FormData();
    data.append("file", img);

    const email = $("input[name='email']").val();
    const nome = $("input[name='nome']").val();
    const telefone = $("input[name='telefone']").val();
    const senha = $("input[name='senha']").val();
    const cep = $("input[name='cep']").val();
    const rua = $("input[name='rua']").val();
    const numero = $("input[name='numero']").val();
    const complemento = $("input[name='complemento']").val();
    const cidade = $("input[name='cidade']").val();
    const estado = $("input[name='estado']").val();

    $.ajax({
        url: path + "/user/save",
        type: "POST",
        dataType: "json",
        data: data,
        async: true,
        processData: false,
        contentType: false,
        error: function (error) {
            alert("Erro ao enviar requisição, tente novamente mais tarde!");
            console.log(error.responseText);
        },
        success: async function (response, textStatus, xhr) {

            if (Number(response.status) === 200) {

                // salvando o usuário
                const path_url = response.img_url;
                const userParams = {senha, nome, email, telefone, path_url, tipo_usuario: 2};
                await fetch(apiPath + "/usuario/save", {
                    headers: {"Content-type": "application/json"},
                    method: "POST",
                    body: JSON.stringify(userParams)
                }).then(async function (response) {
                    console.clear();
                    const userResponse = await response.json();
                    if (response.status === 201) {

                        //usuário criado, inserir endereco
                        const userId = Number(userResponse.id);
                        const addressParams = {
                            cep,
                            rua,
                            numero,
                            complemento,
                            cidade,
                            estado,
                            latitude: "",
                            longitude: "",
                            usuario: userId
                        };
                        await fetch(apiPath + "/endereco/save", {
                            headers: {"Content-type": "application/json"},
                            method: "POST",
                            body: JSON.stringify(addressParams)
                        }).then(async function (response) {
                            console.clear();
                            const addressResponse = await response.json();
                            alert(addressResponse.message);
                            if (response.status === 201) {
                                window.location.href = path;
                            } else {
                                await eraseImage(path_url, "user_img");
                            }
                        }).catch(function (error) {
                            console.log(error);
                        });


                    } else {
                        alert(userResponse.message);
                        await eraseImage(path_url, "user_img");
                        return false;
                    }
                }).catch(function (error) {
                    console.log(error);
                });

            }

        }
    });
});

$("input[name='img']").on("change", function (e) {
    const imgInput = $("input[name='img']")[0].files[0];
    const imgPreview = $("#imgPreview");
    // verificar extensão
    const imgName = imgInput.name;
    const imgNameSplit = imgName.split(".");
    const imgFormat = imgNameSplit[imgNameSplit.length - 1].toLowerCase();
    if (imgFormat !== "jpeg" && imgFormat !== "jpg" && imgFormat !== "png" && imgFormat !== "gif") {
        imgPreview.attr("src", "../assets/img/photo-icon.png");
    } else {
        imgPreview.attr("src", URL.createObjectURL(imgInput));
    }
});

$("#new-service-btn").click(function (e) {
    e.preventDefault();
    let html = `
        <form action="" method="POST" id="newService">
            <div>
                <label for="descricao">Serviço:</label>
                <input type="text" name="descricao" id="descricao">
            </div>
            <div>
                <label for="dia_semana">Dia da semana:</label>
                <select name="dia_semana" id="dia_semana">
                    <option value="0">Domingo</option>
                    <option value="1">Segunda</option>
                    <option value="2">Terça</option>
                    <option value="3">Quarta</option>
                    <option value="4">Quinta</option>
                    <option value="5">Sexta</option>
                    <option value="6">Sábado</option>
                </select>
            </div>
            <div>
                <label for="hora_inicio">Hora início:</label>
                <input type="time" name="hora_inicio" id="hora_inicio">
            </div>
            <div>
                <label for="hora_fim">Hora fim:</label>
                <input type="time" name="hora_fim" id="hora_fim">
            </div>
            <div>
                <label for="intervalo">Intervalo:</label>
                <select name="intervalo" id="intervalo">
                    <option value="10">10 minutos</option>
                    <option value="20">20 minutos</option>
                    <option value="30">30 minutos</option>
                </select>
            </div>
            <div>
                <input type="submit" style="background-color: #f57c00;" value="Inserir">
            </div>
        </form>
    `;
    $(".modal .modal-body").html(html);
    $(".modal").addClass("modal-show");
});

// ===== FUNÇÕES ======

function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    document.cookie = name + '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

async function eraseImage(imgName, imgFolder) {
    fetch(path + "/image/erase/" + imgName + "/" + imgFolder, {
        headers: {"Content-type": "application/json"},
        method: "GET"
    }).then(async function (response) {
        return response.status;
    });
}