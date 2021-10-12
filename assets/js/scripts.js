const path = "http://localhost/petlove/sistema";
const apiPath = "http://localhost/petlove/api-new";

$(window).on("load", function(e) {
    $(".loader").fadeOut();
});

$("#modal-close").click(function(e) {
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

$("#authForm").submit(function(e) {
    e.preventDefault();
    const login = $("input[name='login']").val();
    const senha = $("input[name='senha']").val();
    const data = {login, senha};

    $.ajax({
        url: apiPath + "/auth/login",
        method: "POST",
        dataType: "json",
        data: JSON.stringify(data),
        contentType: "application/json; charset=utf-8",
        error: function(error) {
            alert("Erro ao enviar requisição! Tente novamente mais tarde");
            console.log(error.responseText);
        },
        success: function(response, textStatus, xhr) {
            alert(response.message);
            if(xhr.status === 200) {
                let hash = response.hash;
                setCookie("hash", hash, 10);
                window.location.href = path;
            }
        }
    });
});

$("#btn-logout").click(function(e) {
    e.preventDefault();
    let opt = confirm("Tem certeza que deseja sair?");
    if(opt) {
        eraseCookie("hash");
        window.location.href = path;
    } else {
        return false;
    }
});

function setCookie(name,value,days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for(let i=0;i < ca.length;i++) {
        let c = ca[i];
        while (c.charAt(0)===' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}