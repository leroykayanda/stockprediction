<html>
    <head>
    </head>

    <body>
        <div id="container" style="width:100%; height:400px;border:1px solid #aaa;"></div>

        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/highchart/highcharts.js"></script>
        <script type="text/javascript">
            $(function () {

                var options={
                    chart: {
                        type: 'spline',
                        renderTo: 'container',
                        inverted: false
                    },
                    title: {
                        text: 'Sin Curve'
                    },
                    xAxis: {
                        reversed: false,
                        title: {
                            enabled: true,
                            text: 'X'
                        },
                        maxPadding: 0.05,
                        showLastLabel: true
                    },
                    yAxis: {
                        title: {
                            text: 'Y'
                        },
                        lineWidth: 2
                    },
                    legend: {
                        enabled: false
                    },
                    tooltip: {
                        headerFormat: '',
                        pointFormat: '<b>X: {point.x}</b> and <b>Y: {point.y}</b>'
                    },
                    plotOptions: {
                        spline: {
                            marker: {
                                enable: false
                            }
                        }
                    },
                    series: [
                        //{ data: [[0, 15], [10, -50], [20, -56.5], [30, -46.5], [40, -22.1],[50, -2.5], [60, -27.7], [70, -55.7], [80, -76.5]] }
                    ]
                }
                
                $.getJSON('data.php',function(data)
                          {
                              options.series[0]=data;
                              var chart = new Highcharts.Chart(options);
                          });
                                
                });
            
            
        </script>
    </body>
</html>