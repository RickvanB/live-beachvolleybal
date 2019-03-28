@extends('layouts.pdf')

@section('content')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<div class="container-fluid">
	<div class="row">
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
						@if($programma == NULL)
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
</div>

@endsection