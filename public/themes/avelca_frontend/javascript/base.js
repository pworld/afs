/*
* -----------------------------------------Chart JS--------------------------
*/
function chartjs(color_set,data_points,data_points_pie)
{
  // PIE CHART
  CanvasJS.addColorSet("greenShades",color_set);

  var chart = new CanvasJS.Chart("chartContainerPie",
  {
    colorSet: "greenShades",
    
    legend: {
      verticalAlign: "bottom",
      horizontalAlign: "center"
    },
    theme: "theme1",
    data: [
    {        
      type: "doughnut",
      indexLabelFontFamily: "DINNextLTPro-Regular",       
      indexLabelFontSize: 0,
      startAngle:0,
      indexLabelFontColor: "#ffffff",       
      indexLabelPlacement: "inside", 
      toolTipContent: "{label}: {y} - <strong>#percent%</strong>",
      showInLegend: false,
      indexLabel: " ", 
      dataPoints: data_points_pie
    }
    ]
  });
  chart.render();

  // BAR CHART
  var total_participant = 0;
  for (i = 0; i < data_points.length; i++) {
    total_participant = data_points[i].y >= total_participant ? data_points[i].y : total_participant;
  };

  CanvasJS.addColorSet("greenShades",color_set);
  var chartbar = new CanvasJS.Chart("chartContainer", {
      colorSet: "greenShades",
      axisY: {
        maximum: total_participant,
        minimum:0,
        tickLength: 0,
        gridThickness: 1
      },
      axisX: {
          tickThickness: 1,
          lineThickness: 1,
          labelFontSize: 10,
      },
      data: [
      {
          indexLabelFontSize: 12,
          labelFontFamily: "DINNextLTPro-Regular",
          indexLabelOrientation: "horizontal",
          labelFontColor: "gray",
          indexLabelFontColor: "gray",
          indexLabelFontFamily: "DINNextLTPro-Regular",
          indexLabelPlacement:"inside",
          type: "bar",
          click: function(e){
            detail_chart(e.dataPoint.answer_id,0,0)
           },
          dataPoints: data_points
      }
      ]
  });

  chartbar.render();
}

function compare_chart(first_list, end_list, colorSet, baseline_text,endline_text)
{
  CanvasJS.addColorSet("greenShades",colorSet);

  var chart = new CanvasJS.Chart("compareChart",
  {
      title:{
        text: 'Compare "'+baseline_text+'" dan "'+endline_text+'"'
      },
      axisY: {
        valueFormatString: " ",
        tickLength: 0
      },
      legend: {
        fontSize: 24,
      },
      colorSet: "greenShades",
      data: [
      {
        type: "bar",
        showInLegend: true,
        legendText: baseline_text,
        dataPoints: first_list
      },
      {
        type: "bar",
        showInLegend: true,
        legendText: endline_text,
        dataPoints: end_list
      }
      ]
  });

  chart.render();
}

function detail_chart_js(data)
{
  var data_list = [];
  var total_participant = 0;

  for (i = 0; i < data.length; i++) {
    // Cut String
    var data_text = data[i].category_name;
    var label = data[i].category_item_name;

    if (label.length > 12){
      label = label.substr(0, 12);
      label = label+" ...";
    }
    total_participant += parseInt(data[i].amount); 
    data_list.push({ y: parseInt(data[i].amount), indexLabel: data[i].indexlabel+"%", label: label});
  }

  CanvasJS.addColorSet("hellowYellow",
  [//colorSet Array
    "#ffe87a"              
  ]);

  var chart = new CanvasJS.Chart("detailChart",
  {
    theme: "theme1",
    title:{
      text: data_text,
      fontSize: 24,
      fontWeight: "lighter",
      margin: 30,
      padding: 0
    },
    axisY: {
      maximum: total_participant,
      interval: 100,
      tickLength: 0,
      gridThickness: 1
    },
    axisX: {
      labelFontSize: 12,
      tickLength: 10
    },
    colorSet: "hellowYellow",
    data: [
    {        
      type: "column",  
      showInLegend: false, 
      indexLabelPlacement: "outside",  
      labelFontFamily: "DINNextLTPro-Regular",
      dataPoints: data_list
    }   
    ]
  });

  chart.render();
}
/*
* -----------------------------------------End Chart JS--------------------------
*/
/*
* -----------------------------------------Filter Category JS--------------------------
*/
function select_question(question_id)
{
  var question_text = $("#select_question_id_"+question_id).text();
  FilterSelect.question = question_id;
  $("#select_question_label").html(question_text.slice(0,40)+" ...");
}

function select_category(category_id)
{
  FilterSelect.category = category_id;
  var question_text = "Select Category";
  FilterSelect.question = 0;
  var category_text = $("#select_category_id_"+category_id).text();
  $("#select_category_label").html(category_text.slice(0,15)+" ...");
  $("#select_question_label").html(question_text);
  change_category();
}

function clear_all_filter()
{
  var option_filters = [];
  $(".dropdown-filter .selected_filter_option").each(function(){
    if ($(this).attr("data-type") === 'region') {
      FilterSelect.region = $(this).attr("data-value") == 0 ? FilterSelect.region : $(this).attr("data-value");
    }else{
      var data_value = $(this).attr("data-value");
      if(data_value % 1 === 0){
        filter_text = $('.title-filters',$(this).parent('ul')).html();

        $('#custom-text-title-'+filter_text.toLowerCase()).html("");
        $('#custom-text-title-'+filter_text.toLowerCase()).html(filter_text);
        find_survey();
      }
    }
  });
}
/*
* -----------------------------------------END Filter Category  JS--------------------------
*/

$('.search-wrp > div > a').click(function(){
$(this).siblings('.dropdown-path').show();
return false;
})

$('body').click(function(){
$('.dropdown-path').hide();
})

$('.search-wrp > div > a#question').click(function(){
$('.search-wrp > div > a#category + .dropdown-path').hide();
})

$('.search-wrp > div > a#category').click(function(){
$('.search-wrp > div > a#question + .dropdown-path').hide();
})

$('.dropdown-scroll').alternateScroll({ 'vertical-bar-class': 'styled-v-bar', 'hide-bars': false });