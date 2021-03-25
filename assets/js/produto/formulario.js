var stepper;

$(document).ready(function(){

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