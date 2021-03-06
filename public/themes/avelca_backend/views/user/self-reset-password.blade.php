<!DOCTYPE html>
<html id="newhome" lang="en">


  <head>

    <meta charset="utf-8">
    <title>Asia Foundation Survey - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ HTML::style(Theme::asset('css/login.css')) }}
    {{ HTML::style(Theme::asset('css/bootstrap.min.css')) }}
    {{ HTML::style(Theme::asset('css/custom.css')) }}
    {{ HTML::style(Theme::asset('font-awesome/css/font-awesome.css')) }}

    {{ HTML::script(Theme::asset('js/jquery-1.10.2.js')) }}

    <!--script src="js/modernizr-2.7.1.min.js"></script--> 
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
  <div class="float-container">
  {{ Form::open(array('url' => 'reset-password', 'method' => 'post')) }}
  {{ Widget::get('form-validation') }}
  <h6>Reset Password</h6>
  	<div class="form-group">
      <input type="email" class="form-control" placeholder="Email Address" name="email" required autofocus>
    </div>
    <input type="submit" value="Reset Password" class="btn btn-lg btn-block" style="background-color: {{ Setting::meta_data('general', 'theme_color')->value }}; color: #ffffff;">
    <div class="form-group">
      <div class="half-control">
        {{ HTML::link('signin', 'Sign In') }} 
      </div>
    </div>
  </div>
	{{ HTML::script(Theme::asset('js/bootstrap.min.js')) }}
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
  <script type="text/javascript">
  </script>

</body>
</html>
