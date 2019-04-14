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

class StatusBoard {
    // Numero total de Pontos Criticos acordados
    totalCriticalPoints = 5;

    // Numero total de atividades acordadas
    totalActivities = 10;

    // milisegundos de um dia
    aDay = 60*60*24;

    getColor = (cronDate) => {
        if (cronDate instanceof Date) {
            let today = new Date();
            let hoje = today.getUTCDate();
            let data = cronDate.getUTCDate();
            let dateDiff = this.daysBetween(today, cronDate);

            let color = "green";

            if (dateDiff < 0) {
                color = "red";
            } else if (dateDiff > 0 && dateDiff <= 7) {
                color = "yellow";
            }

            return color;
        }
    };

    daysBetween = (currentDate, limitDate) => {
        // console.log(limitDate > currentDate)
        // console.log(currentDate > limitDate)
        if ( (currentDate - limitDate) < 0 ) {
            return currentDate.getUTCDate() - limitDate.getUTCDate();
        }

        var r = Math.abs(currentDate - limitDate) / 1000;
        var dias = Math.floor(r/ this.aDay);

        return dias;
    }
}