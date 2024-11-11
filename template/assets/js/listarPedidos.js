$(".excluir").each(function () {
  $(this)[0].addEventListener("click", excluir);
});

function excluir(evt) {
  evt.preventDefault();
  let id = this.getAttribute("id");

  swal({
    title: "Você tem certeza?",
    text: "Uma vez deletado, você não poderá recuperar!",
    icon: "warning",
    buttons: {
      cancel: "NÃO",
      defeat: "SIM",
    },
    dangerMode: true,
  }).then((willDelete) => {
    if (willDelete) {
      $.ajax({
        url: "/excluirPedido/" + id,
        method: "DELETE",
        dataType: "JSON",
        success: function (result) {
          $("#tr-" + id).fadeOut(500);
          let pedidos = $(".tr-pedidos");

          if (pedidos.length === 0) {
            $("#table-body").html(`
              <tr>
                  <td colspan="9">Nenhum resultado encontrado.</td>
              </tr>`);
          }
        },
        error: function ({ responseText }) {
          try {
            let {
              pedido: { error },
            } = JSON.parse(responseText);
            swal({
              title: "Erro",
              icon: "error",
              text: error,
            });
          } catch (e) {
            console.log(e.message);
            swal({
              title: "Erro",
              icon: "error",
              text: "Erro ao tentar deletar pedido.",
            });
          }
        },
      });
    }
  });
}
