jQuery( function($) {
    let board = new StatusBoard();

    $("#show_status_board").click(function () {
        renderStatusBoard();
    });

    function renderStatusBoard() {
        var baseDiv = "#status_board";
        var i = 1,
            j = 1;

        for(j; j < board.totalCriticalPoints; j++) {
            var pc = $(".ponto-critico-" + j + " .trumbowyg-editor").text();
            $(baseDiv + " .pc" + j).html("<span>Ponto Critico: </span>" + pc);
        }

        for (i; i < board.totalActivities; i++) {
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
        var cor = "black";

        if ( $('.at' + index + '-inicio input').val() != undefined )
            init = $('.at' + index + '-inicio input').val();

        if ($('.at' + index + '-fim input').val() != undefined) {
            final = $('.at' + index + '-fim input').val();
            cor = board.getColorByDate(new Date(final));

            $('.atividade'+index).parent('tr').addClass('status-' + cor);
        }

        return `<div> ${init} / ${final} </div>`;
    }

    function cronMarkupTemplate(index, identifier) {
        return ".at" + index + "-" + identifier + " input";
    }

    function formInteractions() {
        $("#status_board").toggle();
        $("#the_content").toggle();
    }
});

class StatusBoard {
    // Numero total de Pontos Criticos acordados
    totalCriticalPoints = 5;

    // Numero total de atividades acordadas
    totalActivities = 10;

    // milisegundos de um dia
    aDay = 60*60*24;

    getColorByDate = (limitDate) => {
        if (limitDate instanceof Date) {
            let color = "ok";
            let today = new Date();
            let dateDiff = this.daysBetween(today, limitDate);

            if (dateDiff < 0) {
                color = "danger";
            } else if (dateDiff > 0 && dateDiff <= 7) {
                color = "warning";
            }

            return color;
        }
    };

    daysBetween = (currentDate, limitDate) => {
        if ((currentDate - limitDate) < 0) {
            return currentDate.getUTCDate() - limitDate.getUTCDate();
        }
        let res = Math.abs(currentDate - limitDate) / 1000;
        return Math.floor(res/ this.aDay);
    };

} // StatusBoard