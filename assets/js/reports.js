jQuery( function($) {
    $(".chart_type").click(function () {
        $("#chart_type").val($(this).data('value'));
        $("#gen_charts").click();
    });

    $("#gen_report").click(function (event) {
        var post_id = $("input[name=_cf_cr_pst]").val();

        $.post(acolhesus.ajax_url, {
            action: 'acolhesus_reports_report',
            form: $("#form_type").val(),
            post_id: post_id
        }).success(function (r) {
            $("#the_content").hide();
            $("#show_form").toggle();

            $("#gen_report").toggle();
            $("#charts_set").show();

            var data = JSON.parse(r);
            $("#chart").html(data);
        });
    });

    $("#gen_charts").click(function (event) {
        var post_id = $("input[name=_cf_cr_pst]").val();
        $.post(acolhesus.ajax_url, {
            action: 'acolhesus_reports_chart',
            form: $("#form_type").val(),
            post_id: post_id
        }).success(function (r) {
            if(!post_id)
            {
                $("table.table").hide();
                $(".report-footer").hide();
            }else {
                $("#the_content").hide();
            }

            var data = JSON.parse(r);

            prepare_divs(Object.size(data));

            var i = 1;
            for(var index in data)
            {
                var chart_div = $('div[id="chart"]');
                create_chart(data[index], $("#form_type").val(), index, $('#chart_type').val(), 'chart'+i++);
            }
        });

        $("#gen_charts").toggle();
        $("#show_form").toggle();

        $("#charts_set").show();
        event.preventDefault();
    });

    $("#show_form").click(function () {
        $("#the_content").show();
        $("#charts_set").hide();

        $("#gen_charts").toggle();
        $("#gen_report").toggle();
        $("#show_form").toggle();
    });

    function create_chart(data, form_name, title = '', chart_type = 'bar', where = 'chart') {
        var to_import = ['corechart'];

        if(chart_type === 'bar')
        {
            to_import.push(chart_type);
        }

        google.charts.load('current', {'packages': to_import});

        if(title.length === 0)
        {
            title = create_title(form_name);
        }

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
            var view = new google.visualization.DataView(info);

            view.setColumns([0,
                1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
                2,
                {
                    calc: "stringify",
                    sourceColumn: 2,
                    type: "string",
                    role: "annotation"
                }]);

            var columnWrapper = new google.visualization.ChartWrapper({
                chartType: 'ColumnChart',
                containerId: where,
                dataTable: view,
                options: options
            });

            columnWrapper.draw();
        }else if(chart_type === 'pie')
        {
            chart = new google.visualization.PieChart(document.getElementById(where));
            chart.draw(info, options);
        }
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
            info.push(["Avaliação", "Total", "Porcentagem"] );
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
                height: height,
                colors: ['#00b4b4', '#134074']
            };
        }else if(chart_type === 'pie')
        {
            options = {
                title: title,
                width: width,
                height: height,
                is3D: true,
                colors: ['#00b4b4', '#134074', 'green', 'red', 'gold']
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