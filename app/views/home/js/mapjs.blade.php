  <script type="text/javascript">
    /*
     * -----------------------------------------Map JS--------------------------
     */
    // Containing province id from click event
    var FilterSelect = {
      region:"",
      category:{{ $default_question->id_question_categories }},
      default_category:{{ $default_question->id_question_categories }},
      question: {{ $default_question->id_question }},
      default_question: {{ $default_question->id_question }},
      question_code: {{ $default_question->question_code }},
      empty_question: 0,
      cycle:{{ $default_question->id_cycle }},
      default_cycle:{{ $default_question->id_cycle }},
      answers:[
        @foreach ($question as $key_answers => $answer)
          { id: {{ $answer->id_answer }} ,answer: "{{ $answer->answer }}"},
        @endforeach
      ]
    };

    var DefaultSelect = {
      region:"",
      category:{{ $default_question->id_question_categories }},
      question: {{ $default_question->id_question }},
      question_code: {{ $default_question->question_code }},
      cycle:{{ $default_question->id_cycle }},
      answers:[
        @foreach ($question as $key_answers => $answer)
          { id: {{ $answer->id_answer }} ,answer: "{{ $answer->answer }}"},
        @endforeach
      ]
    };

    var dynamicRegions = [];

    // Re assign Default Filter Select
    function DefaultSelectAssign(data) {
      DefaultSelect = {
        region: data.region,
        category: data.category,
        question: data.question,
        question_code: data.question_code,
        cycle: data.cycle,
        answers:data.answers
      };
    }

    // Removed last clicked area
    var lastClickedLayer;
    // Map Centering
    var map = L.map('map');

    L.tileLayer('https://{s}.tiles.mapbox.com/v3/{id}/{z}/{x}/{y}.png', {
      maxZoom: 18,
      zoomControl:false,
      id: 'examples.map-20v6611k'
    }).addTo(map);

    // get color depending on highest maximum vote
    function getColor(provinsi,dapil) {
      var color = 'white';
      @foreach ($regions as $key_region => $region)
        if (provinsi === '{{ $region["name"] }}' || dapil === '{{ $region["name"] }}')
        {
          color = '{{ $region["color"] }}';
        }
      @endforeach
      return color;
    }
    function getColorDynamic(d) {
      var color = 'white';

      for (i = 0; i < dynamicRegions.length; i++) {
        if (dynamicRegions[i].name == d) 
        {
          color = dynamicRegions[i].color;
        }
      };

      return color;
    }
    function style(feature) {
      return {
        weight: 2,
        opacity: 0.7,
        color: '#8E73F1',
        dashArray: '3',
        fillOpacity: 0.7,
        fillColor: getColor(feature.properties.nm_provinsi, feature.properties.nm_dapil)
      };
    }
    function styleDynamic(feature) {
      return {
        weight: 2,
        opacity: 0.7,
        color: '#8E73F1',
        dashArray: '3',
        fillOpacity: 0.7,
        fillColor: getColorDynamic(feature.properties.nm_provinsi)
      };
    }
    function highlightDynamic(feature) {
      return {
        weight: 3,
        opacity: 1,
        fillColor: '#B2B0B8',
        dashArray: '1',
        fillOpacity: 0.7
      };
    }
    function highlightFeature(e) {
      var layer = e.target;

      layer.setStyle({
        weight: 3,
        opacity: 1,
        dashArray: '1',
        fillOpacity: 0.7,
        fillColor: "#B2B0B8"
      });

      if (!L.Browser.ie && !L.Browser.opera) {
        layer.bringToFront();
      }
    }

    var geojson;
    var popupRegion;

    function resetHighlight(e) {
      FilterSelect.region = "";
      geojson.resetStyle(e.target);
      $("#select_region_label").html("");

      find_survey();
    }

    function AddHighlight(e) {
      // Reser selected area map
      if(lastClickedLayer){
         geojson.resetStyle(lastClickedLayer);
         resetHighlight(e);
         lastClickedLayer = layer;
         return false;
      }

      var layer = e.target;
      
      FilterSelect.region = "";
      FilterSelect.region = layer.feature.properties.nm_provinsi;
      lastClickedLayer = layer;

      highlightFeature(e);
      LoadDataHighligtArea(layer);
      $("#select_region_label").html(layer.feature.properties.nm_provinsi);

      // Remove tooltip
      map.removeLayer(popupRegion);
      // Load new data 
      find_survey_dynamic();
    }

    // Load Queston and Categories based on Area
    function LoadDataHighligtArea(e) {
      $.get( "filter-select", { SelectedFilter:"area", region: FilterSelect.region, category: FilterSelect.category,question: FilterSelect.question, cycle: FilterSelect.cycle} )
          .done(function( response ) {

            var data = response.split(";");
            $("#div-filter-category").html(data[0]);
            $("#div-filter-question").html(data[1]);
          });
    }

    function hoverHightlight(e){
      var layer = e.target;

      popupRegion = L.marker([e.latlng.lat, e.latlng.lng], { icon: L.popupIcon(layer.feature.properties.nm_provinsi), clickable: false }).addTo(map);
    }

    function outHightlight(e){
      map.removeLayer(popupRegion);
    }

    function onEachFeature(feature, layer) {
      layer.on({
        mouseover: hoverHightlight,
        mouseout: outHightlight,
        click: AddHighlight
      });
    }

    geojson = L.geoJson(statesData, {
      style: style,
      onEachFeature: onEachFeature,
    }).addTo(map);


    map.attributionControl.addAttribution('Asia Foundation Survey');
    // Auto Center
    map.fitBounds(geojson.getBounds());
    // Disable drag and zoom handlers.
    map.touchZoom.disable();
    map.doubleClickZoom.disable();
    map.scrollWheelZoom.disable();
    /*
     * -----------------------------------------End Map JS-----------------------------------------
     */
  </script>
