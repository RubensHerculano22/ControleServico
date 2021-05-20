
$(document).ready(function(){

    $("#submit").submit(function(e){
        e.preventDefault(); 
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));
        $.ajax({
            type: "post",
            url: BASE_URL+"Servico/insere_imagem",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: data,
            success: function(data)
            {
                if(data.rst == true)
                {
                    Swal.fire({
                        title: 'Sucesso',
                        text: data.msg,
                        icon: 'success',
                        confirmButtonText: `Ok`,
                        }).then((result) => {
                        if (result.isConfirmed)
                        {
                            $("#id_imagem").val("");
                            $(".principal_input").removeClass("d-none");
                            $("#titulo_modal").html("Cadastrar uma nova Imagem");
                            window.location.reload();
                        }
                            
                    });
                }
                else
                {
                    showNotification("error", data.msg, "Ocorreu um problema ao realizar a inserção da imagem.", "toast-top-center", "15000");
                }
            }
        });
    });

    $("#modalImagem").on("hide.bs.modal", function(){
        $("#id_imagem").val("");
        $(".principal_input").removeClass("d-none");
        $("#titulo_modal").html("Cadastrar uma nova Imagem");
    });
});

function editaImagem(id)
{
    $(".principal_input").addClass("d-none");
    $("#titulo_modal").html("Editar Imagem");
    $("#id_imagem").val(id);

    $("#modalImagem").modal("show");
}

function trocaPrincipal(tipo, id_imagem)
{
    var data = {"ativo": tipo, "id_imagem":id_imagem, "id_servico": $("#id_servico").val()};

    Swal.fire({
        title: 'Aviso',
        text: "Deseja realmente definir está imagem como principal?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: `Sim`,
        cancelButtonText: `Não`,
        }).then((result) => {
        if (result.isConfirmed)
        {
            $.post(BASE_URL+"Servico/trocaPrincipal", data, function(data) {
                console.log(data)
                if(data.rst == true)
                {
                    Swal.fire({
                        title: 'Sucesso',
                        text: data.msg,
                        icon: 'success',
                        confirmButtonText: `Ok`,
                        }).then((result) => {
                        if (result.isConfirmed)
                        {
                            window.location.reload();
                        }
                            
                    });
                }
                else
                {
                    showNotification("error", data.msg, "Ocorreu um problema ao definir a imagem como principal.", "toast-top-center", "15000");
                }
            }, "json");
        }
            
    })
}