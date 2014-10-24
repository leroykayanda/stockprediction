
function displayRt()
{ 

    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    var options={
        chart: {
            type: 'spline',
            renderTo: 'rt-chart',
            animation: Highcharts.svg, // don't animate in old IE
            marginRight: 10,
            events: {
                load: function () {

                    // set up the updating of the chart each second
                    var series = this.series[0];
                    setInterval(function () {
                        var x = (new Date()).getTime(), // current time
                            //y = Math.random();
                            y=getPrice(); 
                        series.addPoint([x, y], true, true); 
                    }, 1000);
                }
            }
        },
        title: {
            text: 'Live Stock Data'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,
            title: {
                text: 'Time',
                style:{ "color": "#5F6F81", "fontSize": "15px","font-weight":"normal" },
                margin:20
            },
        },
        yAxis: {
            title: {
                text: 'Price',
                style:{ "color": "#5F6F81", "fontSize": "15px","font-weight":"normal" }
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' + "<b>At</b> "+
                    Highcharts.dateFormat('%H:%M:%S', this.x)  +" <b>Price</b> "+
                    Highcharts.numberFormat(this.y, 2);
            }
        },
        legend: {
            enabled: false
        },
        exporting: {
            enabled: false
        },

        series:[{
            name:'Stock data',
            data:[]
        }]

    }//options object

    $.getJSON('driver.php?call=getYAxis',function(resp)
              {                  
        options.series[0].data=resp;
        var chart = new Highcharts.Chart(options);
        //console.log(resp);
    }); 

}

function getPrice()
{  
    return ( parseFloat( $('#price').text() ));
}

var flag=false;

setInterval(function(){
    $.get('driver.php?call=getStockPrice',function(resp)
          { 
        if(resp!="")
        {

            $('#price').html(resp);

            if(flag)
            {
                displayRt();
                flag=false;
            }

            var date = new Date();
            var time = date.toLocaleTimeString();

            //console.log("Price updated at : "+time);
        }
        else
        { 
            if(!flag)
            {
                $('#price').html("");
                displayRt3();
                flag=true;
            }
        }

    });
}, 3000);


function displayRt3()
{ 

    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    var options={
        chart: {
            type: 'spline',
            renderTo: 'rt-chart',
            animation: Highcharts.svg, // don't animate in old IE
            marginRight: 10,
            events: {
                load: function () {

                    // set up the updating of the chart each second
                    var series = this.series[0];
                    setInterval(function () {
                        var x = (new Date()).getTime(), // current time
                            y = Math.random();
                        //y=getPrice(); 
                        series.addPoint([x, y], true, true); 
                    }, 1000);
                }
            }
        },
        title: {
            text: 'Live Stock Data'
        },
        xAxis: {
            type: 'datetime',
            tickPixelInterval: 150,
            title: {
                text: 'Time',
                style:{ "color": "#5F6F81", "fontSize": "15px","font-weight":"normal" },
                margin:20
            },
        },
        yAxis: {
            title: {
                text: 'Price',
                style:{ "color": "#5F6F81", "fontSize": "15px","font-weight":"normal" }
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' + "<b>At</b> "+
                    Highcharts.dateFormat('%H:%M:%S', this.x)  +" <b>Price</b> "+
                    Highcharts.numberFormat(this.y, 2);
            }
        },
        legend: {
            enabled: false
        },
        exporting: {
            enabled: false
        },

        series: [{
            name: 'Stock data',
            data: (function () {
                // generate an array of random data
                var data = [],
                    time = (new Date()).getTime(),
                    i;

                for (i = -19; i <= 0; i += 1) {
                    data.push({
                        x: time + i * 1000,
                        y: Math.random()
                    });
                }
                return data;
            }())
        }]

    }//options object                

    var chart = new Highcharts.Chart(options);

}

//prediction_graph();
function prediction_graph(period)
{

    var options = {
        chart: {
            renderTo: 'predict-graphs'
        },
        title: {
            text: 'Predicted Stock Prices'
        },
        xAxis: {
            type: 'datetime'
        },
        yAxis: {
            title: {
                text: 'PRICE',
                style:{"font-size":"16px","font-family":"lato"}
            }
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            area: {
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                threshold: null
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' + "<b>On</b> "+
                    Highcharts.dateFormat('%d %b %Y', this.x)  +" <b>Price</b> "+
                    Highcharts.numberFormat(this.y, 2);
            }
        },
        series: [{
            type: 'area',
            name: 'Date - Price',
            pointInterval: 24 * 3600 * 1000,
            pointStart: Date.UTC(2006, 0, 1),
            data: [
                0.8446, 0.8445, 0.8444, 0.8451,    0.8418, 0.8264,    0.8258
            ]
        }] //end of series
    };



    $.getJSON('driver.php?call=getPredictData',{time:period},function(resp)
              {  //console.log(resp[1]);            
        options.series[0].pointStart=parseInt( resp[0] );
        options.series[0].data=resp[1];
        var chart = new Highcharts.Chart(options);
        $('#predict-graphs').css({"border":"1px solid #aaa"});
    });

}




