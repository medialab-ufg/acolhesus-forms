jQuery( function($) {
    //Defines chart type
    $("#chart_type").val($(".chart_type").first().data('value'));

    $(".chart_type").click(function () {
        $("#chart_type").val($(this).data('value'));
        $("#gen_charts").click();
    });

    $(".report_type").click(function () {
        $("#report_type").val($(this).data('value'));
        $("#gen_report").click();
    });

    $("#gen_report").click(function (event) {
        var post_id = $("input[name=_cf_cr_pst]").val();
        var state = $("#form-title").text().match(/\((.*)\)/);
        if (state)
        {
            state = state[1];
        }

        $.post(acolhesus.ajax_url, {
            action: 'acolhesus_report_one',
            form: $("#form_type").val(),
            post_id: post_id,
            report_type: $("#report_type").val(),
            state: state
        }).success(function (r) {
            $("#the_content").hide();
            $("#show_form").toggle();

            $(".gen-report").toggle();
            $("#gen_report").toggle();
            $("#charts_set").show();

            var data = JSON.parse(r);
            $("#chart").html(data);
        });
    });

    $("#gen_charts").click(function (event) {
        var post_id = $("input[name=_cf_cr_pst]").val();
        var form = $("#form_type").val();

        var campo_atuacao = $("select[name='campo']").val();
        var fase = $("select[name='fase']").val();

        $.post(acolhesus.ajax_url, {
            action: 'acolhesus_reports_chart',
            form: form,
            chart_type: $("#chart_type").val(),
            field: campo_atuacao,
            phase: fase,
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

            var divs_count = 1;
            if(form === 'matriz_cenario'){
                divs_count = Object.size(data[1]) + Object.size(data[2]) + Object.size(data[3]) + Object.size(data[4]);
                prepare_divs(divs_count);
                var i = 1;
                for(var index in data)
                {
                    for(var i_index in data[index])
                    {
                        var chart_div = $('div[id="chart"]');
                        var int = parseInt(index, 10);
                        if(Number.isInteger(int))
                        {
                            create_chart(data[index][i_index], $("#form_type").val(), i_index, $('#chart_type').val(), 'chart'+i++);
                        }
                    }
                }
            }else{
                divs_count = Object.size(data);
                prepare_divs(divs_count);
                var i = 1;
                for(var index in data)
                {
                    var chart_div = $('div[id="chart"]');
                    create_chart(data[index], $("#form_type").val(), index, $('#chart_type').val(), 'chart'+i++);
                }
            }
        });

        if(post_id)
        {
            $("#gen_charts").toggle();
            $("#show_form").toggle();
        }

        $("#charts_set").show();
        event.preventDefault();
    });

    $("#show_form").click(function () {
        $("#the_content").show();
        $("#charts_set").hide();

        $("#gen_charts").toggle();
        $(".gen-report").toggle();
        $("#gen_report").toggle();
        $("#show_form").toggle();
    });

    $(document).on( 'scroll', function(){
        if ($(window).scrollTop() > 100) {
            $('.smoothscroll-top').addClass('show');
        } else {
            $('.smoothscroll-top').removeClass('show');
        }
    });
    $('.smoothscroll-top').on('click', scrollToTop);

    /*------------------------------Functions------------------------------*/


    function scrollToTop() {
        verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
        element = $('body');
        offset = element.offset();
        offsetTop = offset.top;
        $('html, body').animate({scrollTop: offsetTop}, 600, 'linear').animate({scrollTop:25},200).animate({scrollTop:0},150) .animate({scrollTop:0},50);
    }

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
            var info = prepare_data(data, chart_type, form_name);

            var options = set_options(chart_type, title);
            drawChart(info, where, chart_type, data_table, options);
        });
    }

    function prepare_data(data, chart_type, form_type) {
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
            if(form_type === 'matriz_cenario')
            {
                for(var index in data)
                {
                    info.push([index, data[index]]);
                }
            }
            else {
                for(var index in data)
                {
                    info.push([index, data[index].percent]);
                }
            }
        }else if(chart_type === 'line')
        {
            var indexes = [];

            indexes.push("Data");
            for(var index in data[0])
            {
                if(index > 1)
                {
                    indexes.push(data[0][index].title);
                }
            }
            info.push(indexes);

            for(var i in data)
            {
                data.sort(function (a, b) {
                    var year_a = parseInt(a[1].value), year_b = parseInt(b[1].value);

                    if(year_a < year_b) return -1;
                    else if(year_b < year_a) return 1;
                    else {
                        var months = {
                            "Janeiro": 1,
                            "Fevereiro": 2,
                            "Março": 3,
                            "Abril": 4,
                            "Maio": 5,
                            "Junho": 6,
                            "Julho": 7,
                            "Agosto": 8,
                            "Setembro": 9,
                            "Outubro": 10,
                            "Novembro": 11,
                            "Dezembro": 12
                        };

                        var mes_a = a[0].value, mes_b = b[0].value;

                        mes_a = months[mes_a];
                        mes_b = months[mes_b];

                        if(mes_a < mes_b) return -1;
                        else if(mes_b < mes_a) return 1
                        else return 0;
                    }
                });

                var mes, line = [];
                for(var j in data[i])
                {
                    if(j == 0)
                    {
                        mes = data[i][j].value;
                    }else if(j == 1)
                    {
                        line.push(mes + "/"+ data[i][j].value);
                    }else {
                        line.push(parseInt(data[i][j].value));
                    }
                }

                info.push(line);
            }
        }

        return google.visualization.arrayToDataTable(info);
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
        }else if(chart_type === 'line')
        {
            chart = new google.visualization.LineChart(document.getElementById(where));

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
        }else if(chart_type === 'line')
        {
            options = {
                title: title,
                curveType: 'function',
                width: 1100,
                height: 500,
                legend: { position: 'bottom' },
                vAxis: {format: '0'}
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