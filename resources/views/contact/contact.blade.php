@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<h1 class="col-md-offset-3">Contact</h1>
			<hr />
			<ul class="errors col-md-offset-3">
				@foreach($errors->all() as $message)
					<li>{{ $message }}</li>
				@endforeach
			</ul>
			<form class="form-horizontal" action="/contact/send" method="post">
				<input type="hidden" name="_token" value="{!! csrf_token() !!}">
				<div class="form-group">
					<label for="Naam" class="col-sm-3 control-label">Naam: </label>
					<div class="col-sm-5">
						<input type="text" name="name" class="form-control" placeholder="Naam">
					</div>
				</div>
				<div class="form-group">
					<label for="Email" class="col-sm-3 control-label">Emailadres: </label>
					<div class="col-sm-5">
						<input type="email" name="email" class="form-control" placeholder="Emailadres">
					</div>
				</div>
				<div class="form-group">
					<label for="Message" class="col-sm-3 control-label">Bericht: </label>
					<div class="col-sm-5">
						<textarea class="form-control" name="message" placeholder="Uw bericht"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-sm-5">
						<div class="g-recaptcha" data-sitekey="6Le2IyATAAAAAPElpCq2G4RqwPttRMFArcsKSCle"></div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-sm-5">
						<input type="submit" name="submit" class="btn btn-default" value="Verzenden">
					</div>
				</div>
			</form>
			<div class="col-md-offset-3 col-sm-5">
				@if(Session::has('flash_message'))
				    <div class="alert alert-success alert-dismissible alert-message" role="alert">
				    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        {{ Session::get('flash_message') }}
				    </div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection