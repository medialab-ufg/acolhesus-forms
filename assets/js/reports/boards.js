jQuery( function($) {

    $("#show_status_board").click(function () {
        monitoramentoPlanoTrabalho();
    });

    function monitoramentoPlanoTrabalho() {
        var pc1 = $(".ponto-critico-1 .trumbowyg-editor").text();
        var atividade1 = $(".atividade-1 .trumbowyg-editor").text();
        var situacao1 = $(".at1-situacao .trumbowyg-editor").text();
        var cronograma1 = $('.at1-inicio input').val() + ' até ' + $('.at1-fim input').val();
        var at1_status = $('.at1-status select').val();

        $("#status_board").toggle();
        $("#the_content").toggle();
        $("#status_board .pc1").html(pc1);
        $("#status_board .atividade1").html(atividade1);
        $("#status_board .at1-cronograma").html(cronograma1);
        $("#status_board .at1-status").html(at1_status);
        $("#status_board .at1-situacao").html(situacao1);
    }
});