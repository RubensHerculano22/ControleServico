var stepper;

$(document).ready(function(){

    $(".tipo_servico").on("change", function(){
        var valor = $("input[name=tipo]")[1];
        if(valor.checked == true)
            $("#aluguel_equipamentos").removeClass("d-none");
        else
            $("#aluguel_equipamentos").addClass("d-none");
    });

    $('.select2bs4').select2({
        theme: 'bootstrap4'
      })

    // BS-Stepper Init
    stepper = new Stepper(document.querySelector('.bs-stepper'))

    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
});

function nextForm()
{
    stepper.next();
}

function previousForm()
{
    stepper.previous();
}