jQuery( function($) {
    let board = new StatusBoard();
    let baseDiv = "#status_board";

    $("#show_status_board").click(function () {
        renderStatusBoard();
    });

    function renderStatusBoard() {
        var i = 1,
            j = 1;

        for(j; j < board.totalCriticalPoints; j++) {
            var pc = $(".ponto-critico-" + j + " .trumbowyg-editor").text();
            $(baseDiv + " .pc" + j).html("<span>Ponto Crítico: </span>" + pc);
        }

        for (i; i <= board.totalActivities; i++) {
            var atv = ".atividade" + i;
            var atividade = $(atv + " .trumbowyg-editor").text();
            $(baseDiv + " " + atv).html(atividade);
            var status = getStatus(i);
            var cronograma = ".at" + i + "-cronograma";
            var cron = getSchedule(i, status);
            $(baseDiv + " " + cronograma).html(cron);

            appendStatusText(i, status);
        }

        formInteractions();
    }

    function getStatus(index) {
        var stat = ".at" + index + "-status";
        var status = $(stat + " select").val(); 

        return status;
    }

    function getSchedule(index, status) {
        var init = "";
        var final = "";
        var cor = "black";

        if ( $('.at' + index + '-inicio input').val() != undefined )
            init = $('.at' + index + '-inicio input').val();

        if ($('.at' + index + '-fim input').val() != undefined) {
            final = $('.at' + index + '-fim input').val();
            cor = board.getColorByDate(new Date(final), status);

            $('.atividade'+index).parent('tr').addClass('status-' + cor);
        }

        if (init.length < 1 || final.length < 1)
            return "";

        return `<div> <i>${init}</i> <br> <strong>até</strong> <br> <i>${final}</i></div>`;
    }

    function appendStatusText(index, status) {
        var sit = ".at" + index + "-situacao";     
        var situacao = $(sit + " .trumbowyg-editor").text();

        $(baseDiv + " .at" + index + "-status").html(`<strong>${status} </strong><br> ${situacao}`); 
    }

    function cronMarkupTemplate(index, identifier) {
        return ".at" + index + "-" + identifier + " input";
    }

    function formInteractions() {
        $("#status_board").toggle();
        $("#the_content").toggle();
        $("#show_status_board .form").toggle();
        $("#show_status_board .board").toggle();
    }
});

class StatusBoard {
    // Numero total de Pontos Criticos acordados
    totalCriticalPoints = 5;

    // Numero total de atividades acordadas
    totalActivities = 5;

    // milisegundos de um dia
    aDay = 1000*60*60*24;

    alertableStatus = ["A iniciar","Em andamento"];

    getColorByDate = (limitDate, currentStatus) => {
        if (limitDate instanceof Date) {
            let color = "ok";

            if (this.alertableStatus.includes(currentStatus)) {
               let today = new Date();
               let dateDiff = this.daysBetween(today, limitDate);

               if (dateDiff < 0) {
                   color = "danger";
               } else if (dateDiff > 0 && dateDiff <= 7) {
                   color = "warning";
               }
            }

            return color;
        }
    };

    daysBetween = (currentDate, limitDate) => {
        let diff = limitDate.getTime() - currentDate.getTime();

        return Math.ceil(diff / this.aDay);
    };

} // StatusBoard