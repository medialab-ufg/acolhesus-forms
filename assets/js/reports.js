jQuery( function( $ ) {
    $("#gen_charts").click(function (event) {
        jQuery.post(acolhesus.ajax_url, {
            action: 'acolhesus_reports_chart',
            form: $("#form_type").val()
        }).success(function (r) {
            //var data = JSON.parse(r);
            //create_chart(data, $("#type").val(), $("#form_type").val());
        });

        event.preventDefault();
    });

    function create_chart(data, form_name, chart_type = 'bar', where = 'report-results') {
        google.charts.load('current', {'packages':['corechart', chart_type]});
        var title = create_title(form_name);

        google.charts.setOnLoadCallback(function (){
            var data_table = new google.visualization.DataTable();
            var info = prepare_data(data, chart_type, form_name, data_table);

            var options = set_options(form_name, title);
            drawChart(info, where, chart_type, data_table, options);
        });
    }

    function drawChart(info, where, chart_type, data_table, options) {
        var chart;

        if(chart_type === 'bar')
        {
            chart = new google.visualization.ColumnChart(document.getElementById(where));
        }else if (chart_type === 'line')
        {
            chart = new google.visualization.LineChart(document.getElementById(where));
        }

        chart.draw(data_table, options);
    }

    function create_title(type)
    {
        var title = "Gráfico de ", tail = '';
        tail = type;

        return title+tail;
    }

    function prepare_data(data, chart_type, data_type, data_table) {
        var info = [];
        if(chart_type === 'bar')
        {

        }else if(chart_type === 'line')
        {

        }

        data_table.addRows(info);
        return info;
    }

    function set_options(data_type, title) {
        var options = {};
        var width = 800, height = 750;

        options = {
            title: title,
            width: width,
            height: height,
            vAxis: {
                title: 'Quantidade'
            }
        };

        return options;
    }
});