jQuery( function($) {
    $(".chart_type").click(function () {
        $("#chart_type").val($(this).data('value'));
        $("#gen_charts").click();
    });

    $("#gen_charts").click(function (event) {
        $.post(acolhesus.ajax_url, {
            action: 'acolhesus_reports_chart',
            form: $("#form_type").val()
        }).success(function (r) {
            $("table.table").hide();
            $(".report-footer").hide();

            var data = JSON.parse(r);

            prepare_divs(Object.size(data));

            var i = 1;
            for(var index in data)
            {
                var chart_div = $('div[id="chart"]');
                create_chart(data[index], $("#form_type").val(), index, $('#chart_type').val(), 'chart'+i++);
            }
        });

        event.preventDefault();
    });

    function create_chart(data, form_name, title = '', chart_type = 'bar', where = 'chart') {
        if(chart_type === 'bar')
            google.charts.load('current', {'packages':['corechart', chart_type]});
        else google.charts.load('current', {'packages':['corechart']});

        if(title.length === 0)
            title = create_title(form_name);

        google.charts.setOnLoadCallback(function (){
            var data_table = new google.visualization.DataTable();
            var info = prepare_data(data, chart_type, form_name, data_table);

            var options = set_options(chart_type, title);
            drawChart(info, where, chart_type, data_table, options);
        });
    }

    function drawChart(info, where, chart_type, data_table, options) {
        var chart;

        if(chart_type === 'bar')
        {
            chart = new google.charts.Bar(document.getElementById(where));
            options = google.charts.Bar.convertOptions(options);
        }else if(chart_type === 'pie')
        {
            chart = new google.visualization.PieChart(document.getElementById(where));
        }

        chart.draw(info, options);
    }

    function create_title(form_name)
    {
        var title = "Gráfico de ", tail = '';
        if(form_name = 'avalicao_oficina')
        {
            tail = "Avaliação de Oficina Local";
        }else if(form_name = 'avaliacao_grupo')
        {
            tail = "Avaliação de Grupo";
        }

        return title+tail;
    }

    function prepare_data(data, chart_type, data_source, data_table) {
        var info = [], titles = [], lines = [];
        if(chart_type === 'bar')
        {
            info.push(["Avaliação", "Total", "Porcentagem"]);
            for(var index in data)
            {
                info.push([index, data[index].total, data[index].percent]);
            }
        }else if(chart_type === 'pie')
        {
            info.push(["Classificação", "Porcentagem"]);
            for(var index in data)
            {
                info.push([index, data[index].percent]);
            }
        }

        return google.visualization.arrayToDataTable(info);
    }

    function set_options(chart_type, title) {
        var options = {};
        var width = 1000, height = 500;

        if(chart_type === 'bar')
        {
            options = {
                title: title,
                width: width,
                height: height
            };
        }else if(chart_type === 'pie')
        {
            options = {
                title: title,
                width: width,
                height: height,
                is3D: true
            };
        }


        return options;
    }

    Object.size = function(obj) {
        var size = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key)) size++;
        }
        return size;
    };

    function prepare_divs(data_size) {
        for(var i = 1; i < data_size + 1; i++)
        {
            $('#chart'+i).remove();
        }
        for(var i = 1; i < data_size + 1; i++)
        {
            var $div = $('div[id^="chart"]:last');
            var $klon = $div.clone().prop('id', 'chart'+i );
            $div.after( $klon );
        }
    }
});