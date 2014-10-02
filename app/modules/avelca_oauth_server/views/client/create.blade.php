<div class="modal fade" id="create_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Create Client</h4>
			</div>
			<div class="modal-body">
				<form action="{{ URL::to('admin/api/client/create') }}" method="post">

					<div class="form-group">
						{{ Form::label("Name") }}<br>
						{{ Form::text("name", Input::old('name'), array("class" => "form-control")) }}
					</div>

					<div class="form-group">
						{{ Form::label("ID") }}<br>
						<?php $random = str_random(40); ?>
						<p class="static-control">{{ $random }}</p>
						{{ Form::hidden("id", $random) }}
					</div>

					<div class="form-group">
						{{ Form::label("Secret") }}<br>
						<?php $random = str_random(40); ?>
						<p class="static-control">{{ $random }}</p>
						{{ Form::hidden("secret", $random) }}
					</div>
					
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get("general.close") }}</button>
					<button class="btn" type="submit" style="background-color: {{ Setting::meta_data('general', 'theme_color')->value }}; color: #ffffff;">{{ Lang::get("general.confirm") }}</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog modal-sm -->
</div>