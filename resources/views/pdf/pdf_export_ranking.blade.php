@extends("layouts.pdf")

@section("content")

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<div class="container-fluid">
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
								<tr>
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