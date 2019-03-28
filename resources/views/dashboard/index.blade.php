@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6 col-lg-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Geregistreerde gebruikers</h3>
			  </div>
			  <div class="panel-body">
			    {{ $default_users }} accounts hebben zich geregistreerd
			  </div>
			</div>
		</div>
		<div class="col-sm-6 col-lg-3">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Aantal gekoppelde Facebook accounts</h3>
			  </div>
			  <div class="panel-body">
			  	@if($facebookaccounts >= 0)
			    	{{ $facebookaccounts }} Facebook account is er op dit moment gekoppeld
			    @else
			    	{{ $facebookaccounts }} Facebook accounts zijn er op dit moment gekoppeld
			    @endif
			  </div>
			</div>
		</div>
		<div class="col-sm-6 col-lg-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Google Analytics</h3>
				</div>
				<div class="panel-body" id="googleanalytics">
					Coming soon...
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title">Laatste updates programma & ranking</h3>
			  </div>
			  <div class="panel-body">
			    <div class="table-responsive">
			    	<table class="table table-striped table-bordered" id="status">
						<thead>
							<tr>
								<th>Programma</th>
								<th>Ranking</th>
								<th>Tijd</th>
							</tr>
						</thead>
						<tbody>
							@foreach($updates as $update)
								<tr>
									<td><span>{{ $update->programma }}</span></td>
									<td><span>{{ $update->ranking }}</span></td>
									<td><?php echo date('H:i:s', strtotime($update->timestamp)); ?></td>
								</tr>
							@endforeach
						</tbody>
			    	</table>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</div>

@endsection