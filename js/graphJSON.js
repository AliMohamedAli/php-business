function renderGraphConf(subject,keys){

    var num_items = keys.length;
    var cats = getCats(keys);
    var values = getValues(keys);

    $('#container').css('display','auto');  
    $('#container').highcharts({
        chart: {
        },
        title: {
            text: 'AdWords '+subject
        },
        xAxis: {
            categories: cats
        },
        tooltip: {
            formatter: function() {
                var s;
                if (this.point.name) { // the pie chart
                    s = ''+
                        this.point.name +': '+ this.y +' euros';
                } else {
                    s = ''+
                        this.x  +': '+ this.y;
                }
                return s;
            }
        },
        labels: {
            items: [{
                html: 'Total costs',
                style: {
                    left: '40px',
                    top: '8px',
                    color: 'black'
                }
            }]
        },
        series: [{
            type: 'column',
            name: 'Jane',
            data: [3, 2, 1, 3, 4]
        }, {
            type: 'column',
            name: 'John',
            data: [2, 3, 5, 7, 6]
        }, {
            type: 'column',
            name: 'Joe',
            data: [4, 3, 3, 9, 0]
        }, {
            type: 'spline',
            name: 'Average',
            data: [3, 2.67, 3, 6.33, 3.33],
            marker: {
            	lineWidth: 2,
            	lineColor: Highcharts.getOptions().colors[3],
            	fillColor: 'white'
            }
        }, {
            type: 'pie',
            name: 'Total consumption',
            data: [{
                name: 'Jane',
                y: 13,
                color: Highcharts.getOptions().colors[0] // Jane's color
            }, {
                name: 'John',
                y: 23,
                color: Highcharts.getOptions().colors[1] // John's color
            }, {
                name: 'Joe',
                y: 19,
                color: Highcharts.getOptions().colors[2] // Joe's color
            }],
            center: [100, 80],
            size: 100,
            showInLegend: false,
            dataLabels: {
                enabled: false
            }
        }]
    });

    function getCats(keys){
        var cats=[];
        for(y in keys){
            cats[y] = keys[y][0];
            if(y<keys.length)
                cats[y] = keys[y][0];
        }
        return cats;
    }

    function getValues(keys){
        var values=[];

        for(x in keys){
            values[x] = keys[x][1];
        }

        var obj = $.parseJSON( '{ "type": "column","name":'+keys[y][1]+',"data":"" }' );
    }
}