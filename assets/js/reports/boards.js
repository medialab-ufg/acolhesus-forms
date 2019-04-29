jQuery( function($) {
    let board = new StatusBoard();
    let baseDiv = "#status_board";

    $("#show_status_board").click(function () {
        renderStatusBoard();
    });

    function renderStatusBoard() {
        let i = 1,
            j = 1;
        let _total;

        for (_total = j * i; ( _total <= board.totalCriticalPoints); _total++) {
            var pc = $(".ponto-critico-" + _total + " .trumbowyg-editor").text();
            $(baseDiv + " .pc" + _total).html("<span>Ponto Crítico: </span>" + pc);
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

        if ( $('.at' + index + '-inicio input').val() !== undefined ) {
            init = $('.at' + index + '-inicio input').val();

            if (init.length < 10) {
                init = null;
            } else {
                init = new Date(init).toLocaleDateString("pt-br");    
            }        
        }

        if ($('.at' + index + '-fim input').val() !== undefined) {
            final = $('.at' + index + '-fim input').val();
            
            if (final.length < 10) {
                final = null;
            } else {
                cor = board.getColorByDate(new Date(final), status);
                final = new Date(final).toLocaleDateString("pt-br");
            }
            
            $('.atividade'+index).parent('tr').addClass('status-' + cor);
        }

        if (init && final) {
            return `<div> <i>${init}</i> <strong>até</strong> <i>${final}</i></div>`;            
        }

        return "";
    }

    function appendStatusText(index, status) {
        var sit = ".at" + index + "-situacao";     
        var situacao = $(sit + " .trumbowyg-editor").text();

        $(baseDiv + " .at" + index + "-status").html(`<strong> ${status} </strong><br> ${situacao}`); 
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
    totalCriticalPoints = 3;

    // Numero total de Objetivos acordados
    totalObjectives = 5;

    // Numero total de atividades acordadas
    totalActivities = 5;

    // milisegundos de um dia
    aDay = 1000*60*60*24;

    // O outro utilizado eh "Concluido"
    alertableStatus = ["A iniciar","Em andamento"];

    getColorByDate = (limitDate, currentStatus) => {
        if (limitDate instanceof Date) {
            let color = "ok";

            if (this.alertableStatus.includes(currentStatus)) {
               let today = new Date();
               let dateDiff = this.daysBetween(today, limitDate);

               if (dateDiff < 0) {
                   color = "danger";
               } else if (dateDiff >= 0 && dateDiff <= 7) {
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