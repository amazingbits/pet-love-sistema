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