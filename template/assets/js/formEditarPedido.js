let btnEditar = $("#btn-editar")[0];

btnEditar.addEventListener("click", validar);

function teste(data) {
  console.log("yesye: ", data);
}

function validar(evt) {
  evt.preventDefault();

  let id              = $("#id").val();
  let clienteId       = $("#clienteId").val();
  let dataAbertura    = $("#dataAbertura").val();
  let dataRealizacao  = $("#dataRealizacao").val();
  let marca           = $("#marca").val();
  let modelo          = $("#modelo").val();
  let placa           = $("#placa").val();
  let servicos        = $("#servicos").val();
  let total           = $("#total").val();

  let erro = "";

  if (dataAbertura === "") {
    erro += `Informe a data de abertura.\n`;
  }

  if (dataRealizacao === "") {
    erro += `Informe a data de realização.\n`;
  }

  if (marca === "") {
    erro += `Informe a marca.\n`;
  }

  if (modelo === "") {
    erro += `Informe o modelo.\n`;
  }

  if (placa === "") {
    erro += `Informe a placa.\n`;
  }

  if(servicos.length === 0){
    erro += `Informe o serviço.\n`;
  }

  if(total === ""){
    erro += `Informe o total do pedido.\n`;
  }

  if(erro){
    swal({
      title: "Campos obrigatorios.",
      text: erro,
      icon: "error",
    });
    return;
  }else{
    let pedido = {
      id,
      clienteId,
      dataAbertura,
      dataRealizacao,
      marca,
      modelo,
      placa,
      servicos: servicos.join(", "),
      total
    };

    editar(pedido);
  }
}

function editar(data) {
  $.ajax({
    url: "/pedido/" + data.id,
    method: "PUT",
    dataType: "json",
    data,
    beforeSend: function () {
      $("#btn-editar")
        .val("")
        .toggleClass("btn btn-outline-primary spinner-border text-primary");
    },
    success: function () {
      swal({
        title: "Sucesso",
        text: "Pedido editado com sucesso.",
        icon: "success",
      });
    },
    complete: function () {
      $("#btn-editar")
        .val("Editar")
        .toggleClass("btn btn-outline-primary spinner-border text-primary");
    },
    error: function (response) {
      try {
        let { pedido } = JSON.parse(response.responseText);

        if (pedido.error) {
          swal({
            title: pedido.error,
            icon: 'error',
          });
        }
      } catch (e) {
        console.log("Erro: ", e.message);
        swal({
          title: "Erro",
          text: "Erro ao tentar gravar.",
          icon: "error",
        });
      }
    },
  });
}