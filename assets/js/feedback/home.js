$(document).ready(function(){

    $("#submit").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
        data = new FormData($("#submit").get(0));
        $.ajax({
            type: "post",
            url: BASE_URL+"Feedback/cadastra_feedback",
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: data,
            success: function(data)
            {
                if(data.rst === true)
                {
                    Swal.fire({
                        title: 'Sucesso',
                        text: data.msg,
                        icon: 'success',
                        confirmButtonText: `Ok`,
                        }).then((result) => {
                        if (result.isConfirmed)
                            window.location.href = BASE_URL+"Servico";
                    })
                }
                else if(data.rst === false)
                {
                    showNotification("warning", "Erro", data.msg, "toast-top-center", "15000");
                }
            }
        });
    })

});