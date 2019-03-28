@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-10"><h1>{{ Auth::user()->name }}</h1></div>
		</div>
		<div class="row">
			<div class="col-sm-3"><!--left col-->
				<ul class="list-group">
					<li class="list-group-item text-muted">Profile</li>
					<li class="list-group-item text-right"><span class="pull-left"><strong>Geregistreerd</strong></span> {{ Auth::user()->created_at}}</li>
					@if(Auth::user()->team)
						<li class="list-group-item text-right"><span class="pull-left"><strong>Jouw team </strong></span> {{ Auth::user()->team}}</li>
					@endif
					@if($user == 'Administrator')
						<li class="list-group-item text-right"><span class="pull-left"><strong>Rol </strong></span> {{ $user }}</li>
					@endif
				</ul>
			</div>
			<div class="col-sm-9">
				<ul class="nav nav-tabs" id="tabs">
				  	<li class="active"><a data-toggle="tab" href="#settings">Instellingen</a></li>
				  	@if($user == 'Administrator')
				  		<li><a data-toggle="tab" href="#roles">Rechten beheren</a></li>
				  		<li><a data-toggle="tab" href="#backend">Backend</a></li>
				  	@endif
				    <li><a data-toggle="tab" href="#delete">Account verwijderen</a></li>
				</ul>

				<div class="tab-content">
					<hr/>
					<div class="tab-pane fade in active" id="settings">
						<form class="form" action="{{ Auth::user()->id }}/settings/save" method="post">
							<input type="hidden" name="_token" value="{!! csrf_token() !!}">
							<div class="form-group">
								<div class="col-xs-6">
									<label><h4>Naam: </h4></label>
									<input type="text" name="naam" class="form-control" placeholder="Uw naam" value="{{ Auth::user()->name}}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6">
									<label><h4>Email: </h4></label>
									<input type="email" name="email" class="form-control" placeholder="Uw emailadres" value="{{ Auth::user()->email }}">
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6">
									<label><h4>Uw team: </h4></label>
									<select data-placeholder="Kies een team" class="form-control" id="livesearch">
										<option></option>
										@foreach($teams as $team)
											<option>{{ $team->team1 }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<button type="submit" class="btn btn-default save-button" name="submit"><i class="fa fa-btn fa-floppy-o" aria-hidden="true"></i>Opslaan</button>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade in" id="roles">
						<form action="{{ Auth::user()->id }}/settings/assignrole" method="post">
							<input type="hidden" name="_token" value="{!! csrf_token() !!}">
							<div class="form-group">
								<div class="col-xs-6">
									<label><h4>Gebruiker: </h4></label>
									<select class="form-control" name="account">
										<option></option>
										@foreach($users as $user)
											@if(!empty($user->provider))
												<option>{{ $user->name }} - {{ $user->provider }} account</option>
											@else
												<option>{{ $user->name }}</option>
											@endif
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-6">
									<label><h4>Rol toevoegen: </h4></label>
									<select class="form-control" name="role">
										<option></option>
										@foreach($roles as $role)
											<option>{{ $role->name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<button type="submit" class="btn btn-default save-button" name="submit-role"><i class="fa fa-btn fa-floppy-o" aria-hidden="true"></i>Opslaan</button>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade in" id="backend">
						<form action="/account/settings/backendsettings" method="post">
							<input type="hidden" name="_token" value="{!! csrf_token() !!}">
							<div class="form-group">
								<div class="col-xs-6">
									<label><h4>Automagisch updaten: </h4></label>
									@if($ischecked == '1')
										<br /><input type="checkbox" name="automatic_updates" checked>
									@else
										<br /><input type="checkbox" name="automatic_updates">
									@endif
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<button type="submit" class="btn btn-default save-button" name="submit-role"><i class="fa fa-btn fa-floppy-o" aria-hidden="true"></i>Opslaan</button>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade in" id="delete">
						<form action="{{ Auth::user()->id }}/settings/delete" method="post">
							<input type="hidden" name="_token" value="{!! csrf_token() !!}">
							<div class="alert alert-warning alert-dismissible fade in" role="alert"> 
								<h4>Weet je zeker dat je je account wilt verwijderen?</h4> 
								<p>Alle opgeslagen gegevens & instellingen gaan verloren.</p> 
								<p> 
									<button type="submit" name="delete" class="btn btn-warning">Verwijder account</button> 
								</p> 
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-offset-3 col-md-6">
				@if(Session::has('flash_message'))
				    <div class="alert alert-success alert-dismissible alert-message" role="alert">
				    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        {{ Session::get('flash_message') }}
				    </div>
				@endif
			</div>
		</div>
	</div>
@endsection