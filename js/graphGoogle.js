function loadGoogleCharts(){  
  var keys = writeTest();
  keys.pop();
  var chartData = $('select option:selected').val();
  drawChart(keys,chartData);
}

function drawChart(keys,chartData) {

  var codes = newCodes(keys,chartData);
  var data = codes.data;
  var options = codes.options;

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}

var newCodes = function(keys,chartData){
    var data = dataColumns(keys,chartData);

    var options = {'title':chartData+' Adwords',
             'width':400,
             'height':300};       
    return {
        data: data,
        options: options
    };  
};

function dataColumns(keys,chartData){  
  var data = selectChart(keys,chartData);
  return data;
}

function selectChart(keys,chartData){
  switch(chartData){
    case "Costs":
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Keyword');
          data.addColumn('number', chartData);
          var values = [];
          for(i in keys){
            values[i]=keys[i][0];            
            data.addRows([
              [values[i], parseFloat(keys[i][3])]
            ]);
          }
          return data;
    break;

    case "Clicks":
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Keyword');
          data.addColumn('number', chartData);
          var values = [];
          for(i in keys){
            values[i]=keys[i][0];            
            data.addRows([
              [values[i], parseFloat(keys[i][2])]
            ]);
          }
          return data;
    break;

    case "Impressions":
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Keyword');
          data.addColumn('number', chartData);
          var values = [];
          for(i in keys){
            values[i]=keys[i][0];            
            data.addRows([
              [values[i], parseFloat(keys[i][1])]
            ]);
          }
          return data;
    break;
  }
}