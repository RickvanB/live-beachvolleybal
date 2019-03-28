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
							<th>Uitslagen</th>
							<th>Team 2</th>
						</tr>
					</thead>
					<tbody>
						@if($uitslagen == NULL)
							<tr>
								<td colspan="4">Er zijn helaas nog geen uitslagen in deze poule.</td>
							</tr>
						@else
							@foreach($uitslagen as $row)
								<tr>
									<td>{{ $row->ronde }}</td>
									<td>{{ $row->team1 }}</td>
									<td>{{ $row->uitslagen }}</td>
									<td>{{ $row->team2 }}</td>
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