@extends('layouts.app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h1>Poule {{ $poule }}</h1>
					<hr/>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<a href="{{ url('/vmprogramma/'.$dag.'/poule/'.$poule.'/export') }}" class="btn btn-default pull-right export-pdf" role="button">Exporteer als PDF</a>
		</div>
	</div>
	<div class="row" style="padding-top: 20px;padding-bottom: 20px;">
		<div class="col-xs-9">
			<div class="sponsor-slides">
			  @foreach($sponsors as $image)
				<img style="padding-left: 10px;padding-right: 10px;" src="{{ $image }}" alt="sponsors" />
			  @endforeach
			</div>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Ronde</th>
						<th>Team 1</th>
						<th>Tijd</th>
						<th>Team 2</th>
						<th>Scheidsrechter</th>
					</tr>
				</thead>
				<tbody>
					@if($programma->isEmpty())
						<tr>
							<td colspan="5">Er is helaas nog geen programma beschikbaar voor uw team.</td>
						</tr>
					@else
						@foreach($programma as $row)
							<tr>
								<td>{{ $row->ronde }}</td>
								<td>{{ $row->team1 }}</td>
								<td>{{ $row->starttijd }}</td>
								<td>{{ $row->team2 }}</td>
								<td>{{ $row->scheidsrechter }}</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>

@endsection