function sortCol(){
  var upArrow = "&uarr;";
  var downArrow = "&darr;";

  $('.tSortable tr:eq(0) td').click(function(){
  var table = $('.tSortable');
  var rows = table.find("tr:not(:first)").toArray().sort(comparer($(this).index()));
  this.asc = !this.asc;
  if (!this.asc){rows = rows.reverse();
    removeChildren($(this));      
    $(this).append('<span class="arrow">' + upArrow +'</span>');
  }else{      
    removeChildren($(this));
    $(this).append('<span class="arrow">' + downArrow +'</span>');
  }
  for (var i = 0; i < rows.length; i++){table.append(rows[i]);}
  });

  function comparer(index) {
    return function(a, b) {
      var valA = getCellValue(a, index), valB = getCellValue(b, index);
      return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
    }
  }
  function getCellValue(row, index){ return $(row).children('td').eq(index).html(); }
  
  function removeChildren(sortCell){
    sortCell.siblings().children().remove();
    if(sortCell.children().size()>0){
      sortCell.children().remove();
    }
  }
}

function writeTest(){
    try
    {
        var nItems = $('.tSortable tr').length-1;
        var keys = [];
        for(var i=1;i<nItems;i++){
          keys.push([
            $('.tSortable tr:eq('+i+') td').eq(1).text(),
            $('.tSortable tr:eq('+i+') td').eq(6).text(),
            $('.tSortable tr:eq('+i+') td').eq(7).text(),
            $('.tSortable tr:eq('+i+') td').eq(8).text()
          ]);
        }
        keys.push([
          $('#rowTable tr:eq(0) td').eq(0).text(),
          $('#rowTable tr:eq(0) td').eq(6).text(),
          $('#rowTable tr:eq(0) td').eq(7).text(),
          $('#rowTable tr:eq(0) td').eq(8).text()
          ]);

        var str1 = "<table border=\"1\"><tr><td>Keyword</td><th>Impressions</th><th>Clicks</th><th>Costs</th></tr>";
        var str2 = "";
        for(y in keys){
          str2 = str2.concat("<tr><th>"
                            +keys[y][0]+"</th><td>"
                            +keys[y][1]+"</td><td>"
                            +keys[y][2]+"</td><td>"
                            +keys[y][3]+"</tr>");
        }
        var res = str1.concat(str2);
        var new_table = res.concat("</table>");
        var div = document.createElement("div");
        div.setAttribute("id", "table_xml");
        div.innerHTML = new_table;        
        $('#table_mini').text("");
        $('#table_mini').append(div);
        $('#table_mini').css({
          "float": "left",
          "margin": "50px 0px 0px -110px"
        });
        var $table2 = $('#table_mini').clone();
        $table2.insertAfter('#chart_div');
        $('#table_mini').remove();

        return keys;
    }
    catch(Err)
    {
        alert("Error: " + Err.description);
    }
}

function lastRow(){
  var lastRow = $('.tSortable tr').last();
  var lastRowClon = lastRow.clone();    
  var rowTable = $('<table/>').attr("id","rowTable").addClass("sortRow");

  lastRow.remove();
  rowTable.append(lastRowClon);
  rowTable.insertAfter(".tSortable");
}