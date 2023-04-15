var base_url;
function baseurl(enlace)
{
    base_url = enlace;
}

function cargartabla()
{
    var enlace = base_url + "funcionario/cargartablas";
    $('#idFuncionario').DataTable({
        destroy: true,
        "aLengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        "iDisplayLength": 10,
        "ajax": {
            type: "GET",
            url: enlace
        },
    });

}

function abrirDialogFubcionario()
{
  $('#registroFuncionarioModal').modal({backdrop: 'static', keyboard: false})
  $('#registroFuncionarioModal').modal('show');
}
