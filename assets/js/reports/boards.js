jQuery( function($) {
    var totalPC = 5;
    var totalActivities = 10;

    $("#show_status_board").click(function () {
        monitoramentoPlanoTrabalho();
    });

    function monitoramentoPlanoTrabalho() {
        var baseDiv = "#status_board";
        var i = 1,
            j = 1;

        for(j; j < totalPC; j++) {
            var pc = $(".ponto-critico-" + j + " .trumbowyg-editor").text();
            $(baseDiv + " .pc" + j).html(pc);
        }

        for (i; i < totalActivities; i++) {
            var atv = ".atividade" + i;
            var atividade = $(atv + " .trumbowyg-editor").text();
            $(baseDiv + " " + atv).html(atividade);

            var cronograma = ".at" + i + "-cronograma";
            var cron = getCronString(i);
            $(baseDiv + " " + cronograma).html(cron);

            var stat = ".at" + i + "-status";
            var status = $(stat + " select").val();
            $(baseDiv + " " + stat).html(status);

            var sit = ".at" + i + "-situacao";
            var situacao = $(sit + " .trumbowyg-editor").text();
            $(baseDiv + " " + sit).html(situacao);
        }

        formInteractions();
    }

    function getCronString(index) {
        var init = "";
        var final = "";

        if ( $('.at' + index + '-inicio input').val() != undefined )
            init = $('.at' + index + '-inicio input').val();

        if ( $('.at' + index + '-fim input').val() != undefined )
            final = $('.at' + index + '-fim input').val();

        return init + " - " + final;
    }

    function cronMarkupTemplate(index, identifier) {
        return ".at" + index + "-" + identifier + " input";
    }

    function formInteractions() {
        $("#status_board").toggle();
        $("#the_content").toggle();
    }
});