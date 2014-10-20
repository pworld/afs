@extends('layouts/default')

@section('content')

  @include('partial/homeasset')

  <section class="map">
    <a class="logo" href="#"><img src="{{ Theme::asset('img/logo.png') }}"></a>
    <div class="border-top"></div>
    <div class="top-nav">
      <div class="left-side">
        <p id="select_region_label"></p>
      </div>
      <div class="right-side">
        <p id="select_cycle_label">{{ $default_question->cycle }}</p>
        <div class="dropdown">
          <a href="#" data-toggle="dropdown" class="hamburger"></a>
          <ul class="dropdown-menu">
            @foreach ($cycles as $cycle)
            <li><a href="#" onclick='cycle_select({{ $cycle->id }})' id="cycle_select_{{ $cycle->id }}">{{ $cycle->name }}</a></li>
            @endforeach
        </ul>
        </div>
      </div>
    </div>
    <div class="dropshadow">
      <img src="{{ Theme::asset('img/dropshadow.png') }}">
      <div class="search-wrp">
        <div class="col-md-3">
          <a href="#" id="category" data-toggle="dropdown">
            <img src="{{ Theme::asset('img/add.png') }}" />
            <span id="select_category_label">{{ $default_question->question_categories }}</span>
          </a>
          <div class="dropdown-path" id="div-filter-category">
            @include('home/filter_category')
          </div>
        </div>

        <div class="col-md-6">
          <a href="#" id="question">
            <img src="{{ Theme::asset('img/add.png') }}" />
            <span id="select_question_label">{{$default_question->question}}</span>
          </a>
          <div class="dropdown-path" id="div-filter-question">
            @include('home/filter_question')
          </div>
        </div>

        <div class="col-md-3"><a class="find-surveys" href="#" onclick='find_survey()'>{{Lang::get('frontend.find_surveys')}} <img src="{{ Theme::asset('img/arrow.png') }}"></a></div>
      </div>
    </div>
    <div id="map" class="map-canvas" style="position: absolute; right: 0px; top: 0px; width: 100%; height: 670px"></div>
  </section>

  <section class="filter">
    <div class="container">
      <div class="col-md-12">
        <ul>
          @foreach ($filters as $key_filters => $filter)
          <li>
            <select class="select-control">
              <option>{{ $key_filters }}</option>
              @foreach ($filter as $filter_items)
              <option value="{{ $filter_items['category_item_id'] }}">{{ $filter_items['category_item_name'] }}</option>
              @endforeach
            </select><!-- Custom Select -->
          </li>
          @endforeach
          <li>
						<a class="clear-all" onclick='clear_all_filter()' href="#">{{Lang::get('frontend.clear_all')}}</a>
          </li>
        </ul>
      </div>
    </div>
  </section>

  <section class="survey-pemilu">
    <div class="container center">
      <div class="col-md-12">
        <h1>{{ $survey->name }}</h1>
        <h3>{{Lang::get('frontend.survey_question')}}</h3>
        <p id="question-name">{{ $default_question->question }}</p>
        <div class="chart">
          <div id="chart_canvas">
            <div class="col-md-5"><div id="chartContainerPie" style="height: 300px; width: 100%;"></div></div>
            <div class="col-md-7"><div id="chartContainer" style="height: 300px; width: 100%;"></div></div>
          </div>
          <div class="col-md-12">
            <ul class="chart-pagination">
              <li><a href="#" class="orange-bg"><img src="{{ Theme::asset('img/arrow-l.png') }}"></a></li>
              <li><a class="orange-bg" onclick="compare_cycle()">{{Lang::get('frontend.compare_this_survey')}}</a></li>
              <li><a href="#" class="orange-bg"><img src="{{ Theme::asset('img/arrow.png') }}"></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="compare-survey">
    <div class="container">
      <div class="col-md-6">
        <h4>Lorem ipsum dolor sit amet, consectet</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ipsum risus, dignissim vel arcu sit amet, sodales dignissim nibh. Suspendisse lobortis neque sed est sollicitudin ornare.<br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ipsum risus, dignissim vel arcu sit amet, sodales dignissim nibh. Suspendisse lobortis neque sed est sollicitudin ornare.</p>
      </div>
      <div class="col-md-6">
        <div class="extras">
          <img src="{{ Theme::asset('img/compare.png') }}">
          <div>
            <h4>Compare Survey Results</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ipsum risus</p>
            <a href="#" class="orange-bg">COMPARE SURVEY</a>
          </div>
        </div>
        <div class="extras">
          <img src="{{ Theme::asset('img/variable.png') }}">
          <div>
            <h4>Cross by Another Variable</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ipsum risus</p>
            <a href="#" class="orange-bg">Cross by another variable</a>
          </div>
        </div>
      </div>
    </div>
  </section>

@include('partial/homefooter')

@stop