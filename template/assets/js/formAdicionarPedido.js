let btnAdicionar = $("#btn-adicionar")[0];

btnAdicionar.addEventListener("click", validar);

function validar(evt) {
  evt.preventDefault();

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
      clienteId,
      dataAbertura,
      dataRealizacao,
      marca,
      modelo,
      placa,
      servicos: servicos.join(", "),
      total
    };

    adicionar(pedido);
  }
}

function adicionar(data) {
  $.ajax({
    url: "/pedido",
    method: "POST",
    dataType: "json",
    data,
    beforeSend: function () {
      $("#btn-adicionar")
        .val("")
        .toggleClass("btn btn-outline-primary spinner-border text-primary");
    },
    success: function () {
        swal({
          title: "Sucesso",
          text: "Pedido cadastrado com sucesso.",
          icon: "success",
        });
        
        $("#dataAbertura").val("");
        $("#dataRealizacao").val("");
        $("#marca").val("");
        $("#modelo").val("");
        $("#placa").val("");
        $("#servicos").val([]);
        $("#total").val("");
    },
    complete: function () {
      $("#btn-adicionar")
        .val("Cadastrar")
        .toggleClass("btn btn-outline-primary spinner-border text-primary");
    },
    error: function (response) {
      try{
        let { pedido } = JSON.parse(response.responseText);

        if(pedido.error){
          swal({
            title: pedido.error,
            icon: 'error',
          });
        }
      }catch(e){
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