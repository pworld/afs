$(document).ready(function(){
  var default_q = parseInt(FilterSelect.default_question);
  var default_cat = parseInt(FilterSelect.default_category);
  var default_cy = parseInt(FilterSelect.default_cycle);
  $('.cross-question #cross-alert').hide();
  /*Define select2*/
  $(function(){
      $('.select-cycle, .select-category, .select-question, .cross-select-category, .cross-select-question').select2({});
  });
  
  $('.cross-question').hide();
  $('.chart-flag').show();
  

  $('.show-cross').click(function(e){
    e.preventDefault();

    // $('html, body').animate({scrollTop: $(".survey-question").offset().top}, 1000);
    $('.cross-question').show();
    $('.chart-flag').hide();
  });

  $('.cross-select-question').change(function(){
      $('.submit-cross').data('question_id', $(this).val()); //send data-question_id to button
  });

  function numAttrs(obj) {
    var count = 0;
    for(var key in obj) {
      if (obj.hasOwnProperty(key)) {
        ++count;
      }
    }
    return count;
  }

  $('.submit-cross').click(function(){  
    var question_row = $(this).data('question_id');

    $('.cross-table').html("");

    $.ajax({
      type : 'post',
      url : 'cross',
      data : {
        'question_header' : FilterSelect.question,
        'question_row' : question_row
      },
      success : function(data){
        var count_array = Object.keys(data.question_headers).length;
        
        if(Object.keys(data.question_rows[1]).length != 0){
          $('.cross-question #cross-alert').hide();
          
          for(var a=0;a<count_array;a++){
            var count_value = 0; //inisiate variable for question header count
            
            //show question header  
            var $table = $($('#get-cross-table').html().trim()); //inisiate js template
            $('#question_header', $table).append(data.question_headers[a][0]['question']);
            $.each(data.question_headers[a], function(index, value){
              $('#answer_header', $table).append('<th>'+ value['answer'] +'</th>');
              count_value++;
            });

            $('#question_header', $table).attr('colspan',count_value);

            //show question row
            $.each(data.question_rows[a], function(index, value){
              result = '<tr><td width="20%">'+ value['answer'] +'</td>'; //create html for showing question row data
              for(i=0;i<count_value;i++){
                result += '<td align="center">'+ value['result'+i] +'</td>';
              }
              result += '</tr>';

              $('#answer_row', $table).append(result); //append html to tempate

            });
            
            $('.cross-table').append($table); //append template to cross-table class
          }  
        }else{
          $('.cross-question #cross-alert').show();
        }
      }

    });
  }); 

  $('.cross-back').click(function(e){
    e.preventDefault();
    
    // $('html, body').animate({scrollTop: $(".survey-question").offset().top}, 1000);
    $('.cross-question').hide().css('display', 'none').fadeOut('slow');
    $('.chart-flag').show();
    find_survey();
  });

  $('.select-category').change(function(){
    
    var value = $(this).val();

    clear_all_filter_nosurvey();
    disable_anchor($('.clear-all'),'#AA6071', 0);

    $.get( "filter-select", { SelectedFilter:"loadcategory", survey_id: FilterSelect.survey, category: $(this).val(), cycle : FilterSelect.cycle} )
    .done(function(data){
      /* Switch selected option to pilih pertanyaan */
      $('#select-question').val(0);
      $('.select-question .select2-chosen').text(data[1][0]);  

      /* clear chart and create warning */
      $(".notification").html('<div class="alert alert-info"><div><h4>' + data[1][1] + '</h4></div></div>');
      $("#chart_canvas").hide();
      $(".chart-pagination").hide();
      $("#filter-by-label").text("");

      $('.header-select #select-question option').remove();
      $('.header-select #select-question').append($("<option></option>").attr("value","0").text(data[1][0]))
      $.each(data[0], function(index, obj){
        $('.header-select #select-question').append($("<option></option>").attr("value",obj.id).text(obj.question))
      });

    });
  });

  $('.cross-select-category').change(function(){
    var value = $(this).val();
    $.get( "filter-select", { SelectedFilter:"loadcategory", category: $(this).val(), cycle : FilterSelect.cycle} )
    .done(function(data){
      $('#cross-select-question option').remove()
      $.each(data[0], function(index, obj){
        $('#cross-select-question').append($("<option></option>").attr("value",obj.id).text(obj.question))
      });
    });
  });

  $('#select-question').change(function(e){
    // $('html, body').animate({scrollTop: $(".survey-question").offset().top}, 1000);
    // $('.header-select #select-question option[value="0"]').remove();
    if(FilterSelect.empty_question == 0){
      FilterSelect.empty_question = 0;
    }
    if($(this).val() == 0){
      FilterSelect.question = default_q;
      FilterSelect.category = default_cat;
      FilterSelect.cycle = default_cy;
      find_survey();
    }else{
      FilterSelect.question = parseInt($(this).val());
      FilterSelect.category = parseInt($('#select-category').val());
      FilterSelect.cycle = parseInt($('#select-cycle').val());

      find_survey();  
    }
    
  });

  $('.select-cycle').change(function(){
    clear_all_filter_nosurvey();
    FilterSelect.cycle = parseInt($(this).val());

    disable_anchor($('.clear-all'),'#AA6071', 0);

    $.ajax({
      type : 'post',
      url : 'cycleLang',
      data : {},
      success : function(data){

        if($('#select-question option:first-child').val() == 0){
          $('#select-question option:first-child').remove();
          $('#select-category option:first-child').remove();  
        }

        $('#select-question').prepend("<option value='0'>"+ data[0] +"</option>");
        $('#select-category').prepend("<option value='0'>"+ data[1] +"</option>");


        $('#select-question').val(0);
        $('.select-question .select2-chosen').text(data[1]);  

        $('#select-category').val(0);
        $('.select-category .select2-chosen').text(data[0]);

        $(".notification").html('<div class="alert alert-info"><div><h4> '+ data[2] +' </h4></div></div>');
        $("#chart_canvas").hide();
        $(".chart-pagination").hide();
        $("#filter-by-label").text("");
      }

    })
   
  });


  $('.compare-all').click(function(){
    
    $('.arrowright').removeAttr('onclick');
    $('.arrowleft').removeAttr('onclick');

    $('.arrowright').attr('onclick', 'compare_cycle(2)');
    $('.arrowleft').attr('onclick', 'compare_cycle(1)');

    compare_cycle(2)
  });
  // $('#lang-en').tooltip('show');

  // $('#select-region').change(function(){
  //   if($(this).val() != null){
  //     FilterSelect.region = parseInt($(this).val());
  //     find_survey_dynamic();
  //   }else{
  //     FilterSelect.region = "";
  //     find_survey();
  //   }
  // });
})