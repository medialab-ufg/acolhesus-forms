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

    function create_chart(data, form_name, chart_type = 'pie', where = 'chart') {
        google.charts.load('current', {'packages':['corechart']});
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

        if(chart_type === 'pie')
        {
            chart = new google.visualization.PieChart(document.getElementById(where));
        }

        chart.draw(info, options);
    }

    function create_title(type)
    {
        var title = "Gráfico de ", tail = '';
        tail = type;

        return title+tail;
    }

    function prepare_data(data, chart_type, data_type, data_table) {
        var info = [];
        if(chart_type === 'pie')
        {
            info =[
                ['Task', 'Hours per Day'],
                ['Work',     11],
                ['Eat',      2],
                ['Commute',  2],
                ['Watch TV', 2],
                ['Sleep',    7]
            ];
        }

        return google.visualization.arrayToDataTable(info);
    }

    function set_options(data_type, title) {
        var options = {};
        var width = 900, height = 500;

        options = {
            title: title,
            width: width,
            height: height,
            is3D: true
        };

        return options;
    }
});