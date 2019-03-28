@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-offset-4">
			<h1>Uitslagen invoeren</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6 col-xs-offset-3">
			<div class="alert alert-info alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Belangrijk!</strong> Indien de standen zijn ingevuld en verzonden zijn, kunnen ze niet meer worden aangepast. Je hebt 30 minuten de tijd om de uitslagen in te vullen!
			</div>
			@if(Session::has('flash_message'))
			    <div class="alert alert-success alert-dismissible alert-message" role="alert">
			    	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        {{ Session::get('flash_message') }}
			    </div>
			@endif
			@if($yourMatches != NULL)
				<hr>
				@foreach($yourMatches as $yourMatch)
					<form method="post" action="{{ url('uitslagen/invoeren/' . $yourMatch->id_programma) }}">
						<h3>{{ $yourMatch->team1 }} - {{ $yourMatch->team2 }} | {{ $yourMatch->starttijd }}</h3>
						<div class="form-group">
							<label>Uitslagen</label>
							<input type="hidden" name="_token" value="{!! csrf_token() !!}">
							<input type="hidden" name="id" value="{{ $yourMatch->id_programma }}">
							<input type="text" class="form-control" name="results" @if($yourMatch->uitslagen != NULL) value="{{ $yourMatch->uitslagen}}" disabled @endif  placeholder="Vul hier uw uitslagen in" required>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default" @if($yourMatch->uitslagen != NULL) disabled @endif>Verzenden</button>
						</div>
					</form>
				@endforeach
			@else
				<hr>
				<p>Er zijn op dit moment geen wedstrijden waar een uitslag voor ingevuld kan worden.</p>
			@endif
		</div>
	</div>
</div>

@endsection