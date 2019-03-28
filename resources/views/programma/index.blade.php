@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
					<div class="panel-body">
						<h1>Poule {{ $poule }}</h1>
						<hr/>
						<p>Dit is het programma op {{ $dag }}, maak hieronder een keuze naar welk overzicht u wilt.</p>
						@if(!empty($lastupdate))
							<h5>Laatste update: <?php echo date('H:i:s', strtotime($lastupdate));?></h5>
						@endif
					</div>
			</div>
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
		<div class="col-xs-12 col-sm-4">
			<div class="panel panel-default">
				  <div class="panel-heading title-heading">
				    <h3 class="panel-title">Stand</h3>
				  </div>
				  <div class="panel-body">
				  	<div class="table-responsive">
				  		<table class="table">
					  		<thead>
					  			<tr>
					  				<th>Team</th>
					  				<th>Punten</th>
					  				<th>Plaats</th>
					  			</tr>
					  		</thead>
					  		<tbody>
						  		@if($ranking == NULL)
						  			<td colspan="3">Er zijn helaas nog geen scores voor jouw team.</td>
						  		@else
								    @foreach($ranking as $row)
										<tr class="selectedteam">
											<td>{{ $row->teams }}</td>
											<td>{{ $row->punten }}</td>
											<td>{{ $row->plaats }}</td>
										</tr>
								    @endforeach
							    @endif
						    </tbody>
					    </table>
					    <p><i class="fa fa-long-arrow-right"></i><a href="{{ url('/ranking/'. $dag . '/poule/'. $poule) }}"> Volledige ranking</a></p>
				    </div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4">
			<div class="panel panel-default">
			  <div class="panel-heading title-heading">
			    <h3 class="panel-title">Uitslagen | Ochtend</h3>
			  </div>
			  <div class="panel-body">
			    <div class="table-responsive">
			  		<table class="table">
				  		<thead>
				  			<tr>
				  				<th>Team 1</th>
				  				<th>Uitslagen</th>
				  				<th>Team 2</th>
				  			</tr>
				  		</thead>
				  		<tbody>
					  		@if($ochtend_uitslagen == NULL)
								<td colspan="3">Er zijn helaas nog geen uitslagen beschikbaar.</td>
					  		@else
							    @foreach($ochtend_uitslagen as $row)
									<tr class="selectedteam">
										<td>{{ $row->team1 }}</td>
										<td>{{ $row->uitslagen }}</td>
										<td>{{ $row->team2 }}</td>
									</tr>
							    @endforeach
							@endif
					    </tbody>
				    </table>
				    <p><i class="fa fa-long-arrow-right"></i><a href="{{ url('/uitslagen/'. $dag .'/ochtend/poule/'. $poule) }}"> Volledig programma & uitslagen</a></p>
			    </div>
			  </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4">
			<div class="panel panel-default">
			  <div class="panel-heading title-heading">
			    <h3 class="panel-title">Uitslagen | Middag</h3>
			  </div>
			  <div class="panel-body">
			    <div class="table-responsive">
			  		<table class="table">
				  		<thead>
				  			<tr>
				  				<th>Team 1</th>
				  				<th>Uitslagen</th>
				  				<th>Team 2</th>
				  			</tr>
				  		</thead>
				  		<tbody>
					  		@if($middag_uitslagen == NULL)
								<td colspan="3">Er zijn helaas nog geen uitslagen beschikbaar.</td>
					  		@else
							    @foreach($middag_uitslagen as $row)
									<tr class="selectedteam">
										<td>{{ $row->team1 }}</td>
										<td>{{ $row->uitslagen }}</td>
										<td>{{ $row->team2 }}</td>
									</tr>
							    @endforeach
							@endif
					    </tbody>
				    </table>
				    <p><i class="fa fa-long-arrow-right"></i><a href="{{ url('/uitslagen/'. $dag .'/middag/poule/'. $poule) }}"> Volledig programma & uitslagen</a></p>
			    </div>
			  </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-4">
			<div class="panel panel-default">
			  <div class="panel-heading title-heading">
			    <h3 class="panel-title">Programma | Ochtend</h3>
			  </div>
			  <div class="panel-body">
			  	<div class="table-responsive">
			  		<table class="table">
				  		<thead>
				  			<tr>
				  				<th>Team 1</th>
				  				<th>Starttijd</th>
				  				<th>Team 2</th>
				  			</tr>
				  		</thead>
				  		<tbody>
					  		@if($ochtendprogramma == NULL)
					  			<td colspan="3">Er is helaas nog geen programma beschikbaar.</td>
					  		@else
							    @foreach($ochtendprogramma as $row)
									<tr class="selectedteam">
										<td>{{ $row->team1 }}</td>
										<td>{{ $row->starttijd }}</td>
										<td>{{ $row->team2 }}</td>
									</tr>
							    @endforeach
							@endif
					    </tbody>
				    </table>
				    <p><i class="fa fa-long-arrow-right"></i><a href="{{ url('/vprogramma/'. $dag .'/ochtend/poule/'. $poule) }}"> Volledig programma</a></p>
			    </div>
			  </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4">
			<div class="panel panel-default">
			  <div class="panel-heading title-heading">
			    <h3 class="panel-title">Programma | Middag</h3>
			  </div>
			  <div class="panel-body">
			  	<div class="table-responsive">
			  		<table class="table">
				  		<thead>
				  			<tr>
				  				<th>Team 1</th>
				  				<th>Starttijd</th>
				  				<th>Team 2</th>
				  			</tr>
				  		</thead>
				  		<tbody>
					  		@if($middagprogramma == NULL)
					  			<td colspan="3">Er is helaas nog geen programma beschikbaar.</td>
					  		@else
							    @foreach($middagprogramma as $row)
									<tr class="selectedteam">
										<td>{{ $row->team1 }}</td>
										<td>{{ $row->starttijd }}</td>
										<td>{{ $row->team2 }}</td>
									</tr>
							    @endforeach
							@endif
					    </tbody>
				    </table>
				    <p><i class="fa fa-long-arrow-right"></i><a href="{{ url('/vprogramma/'. $dag .'/middag/poule/'. $poule) }}"> Volledig programma</a></p>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</div>

@endsection