@extends("layouts.app")

@section("content")

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<h1>Poule {{ $poule }}</h1>
					<hr/>
					@if(!empty($lastupdate))
						<h5>Laatste update: <?php echo date('H:i:s', strtotime($lastupdate));?></h5>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<a href="{{ url('/ranking/'.$dag.'/poule/'.$poule.'/export') }}" class="btn btn-default pull-right export-pdf" role="button">Exporteer als PDF</a>
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
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Team</th>
							<th>Saldo</th>
							<th>Punten</th>
							<th>Plaats</th>
						</tr>
					</thead>
					<tbody>
						@if($ranking == NULL)
							<td colspan="4">Er zijn helaas nog geen uitslagen, waardoor er nog geen overzicht is van uw team.</td>
						@else
							@foreach($ranking as $row)
								<tr class="selectedteam">
									<td>{{ $row->teams }}</td>
									<td>{{ $row->saldo }}</td>
									<td>{{ $row->punten }}</td>
									<td>{{ $row->plaats }}</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection