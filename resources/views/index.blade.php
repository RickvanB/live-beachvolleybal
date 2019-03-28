@extends('layouts.app') 

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            @if(!Auth::guest())
                <div class="alert alert-info" role="alert">Tof dat je een account aangemaakt hebt! Je hebt nu toegang tot extra features, bijvoorbeeld het highlighten van je eigen team! <a href="{{ url('/account/settings') }}">Klik hier</a> om naar je instellingen te gaan.</div>
            @endif
            <!--<p class="inschrijfbutton"><a href="http://www.vcbladel.nl" class="btn btn-default title-heading" role="button">Schrijf je nu in!</a></p>-->
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading title-heading">
                    <h3 class="panel-title">Weer & zoek je team</h3>
                </div>
                <div class="panel-body">
                    <p><strong>Zoek je team, zodat je snel weet in welke poule je speelt!</strong></p>
                    <select data-placeholder="Kies een team" class="form-control" id="livesearch">
                        @if($query == NULL)
                            <option>Er zijn op dit moment (nog geen) teams</option>
                        @else
                            @foreach($query as $option)
                                <option></option>
                                <option id="team" value="{{ url('/overview/'.$option->dag.'/poule/'.$option->poule)}}" data-team="{{ $option->team1 }}" data-dag="{{ $option->dag }}" data-poule="{{ $option->poule }}">{{ $option->team1 }} - poule {{ $option->poule }} - {{ $option->dag }}</option>
                            @endforeach
                        @endif
                    </select>
                    <hr />
                    <p>Temperatuur: {{ $weather->currently->temperature }} graden</p>
                    <p>Windsnelheid: {{ $weather->currently->windSpeed }} km/u</p>
                    <span class="bold">Weerbericht voor vandaag: </span>
                    <p>{{ $weather->hourly->summary }}</p>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading title-heading">
                    <h3 class="panel-title">Aankomende wedstrijden</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Team 1</th>
                                    <th>Tijd</th>
                                    <th>Team 2</th>
                                    <th>Poule</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($upcoming == NULL)
                                    <td colspan="3">Er zijn helaas nog geen wedstrijden.</td>
                                @else
                                    @foreach($upcoming as $row)
                                        <tr class="selectedteam">
                                            <td>{{ $row->team1 }}</td>
                                            <td>{{ $row->starttijd }}</td>
                                            <td>{{ $row->team2 }}</td>
                                            <td>{{ $row->poule }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading title-heading">
                    <h3 class="panel-title">Sponsoren</h3>
                </div>
                <div class="panel-body">
                    <p>
                        <a href="http://www.kse.nl" target="_blank">KSE Bladel</a> -
                        <a href="https://www.facebook.com/X-sport-FF-nie-1697474433810979/" target="_blank">X-Sport FF Nie</a> -
                        <a href="http://www.topshopbladel.nl/" target="_blank">Top Shop Bladel</a> - 
                        <a href="https://www.piusxcollege.nl/" target="_blank">Pius X - College</a> - 
                        <a href="http://www.dehoutwinkelbladel.nl/" target="_blank">De Houtwinkel Bladel</a> - 
                        <a href="http://www.bakkerijvanheeswijk.nl/" target="_blank">Bakkerij van Heeswijk</a> -
                        <a href="http://www.hems.nl/" target="_blank">Hems BV</a> -
                        <a href="http://www.cafednbel.nl/" target="_blank">Cafe D'n Bel</a> - 
                        <a href="http://www.dendoel.nl/" target="_blank">Den Doel</a> - 
                        <a href="http://www.esso-hapert-eersel.nl/" target="_blank">Kempen Oil</a> - 
                        <a href="http://www.baetsen.com/" target="_blank">Baetsen</a> - 
                        <a href="http://www.wvk-groep.nl/" target="_blank">WVK Groep</a> - 
                        <a href="http://www.fiers.nl/" target="_blank">Zeefdrukkerij Fiers</a> - 
                        <a href="http://www.ford-pvandeven.nl/" target="_blank">P. van de Ven</a> - 
                        <a href="http://www.ah.nl/" target="_blank">Albert Heijn Bladel</a> - 
                        <a href="http://www.sniederspassage.nl/" target="_blank">Snieders passage</a> - 
                        <a href="https://jupiler.nl/" target="_blank">Jupiler</a> -
                        <a href="http://www.jentautolease.nl/" target="_blank">J&T Autolease</a> - 
                        <a href="http://www.verseoogst.nl/telers/aardbeienkwekerij-lavrijsen/" target="_blank">Aardbeienkwekerij Lavrijsen</a> - 
                        <a href="https://www.nummereen.com/informatie/45/index.html" target="_blank">Club Hasta La Pasta</a> -
                        <a href="http://grandcafellamar.nl/" target="_blank">Llamar Grand Cafe</a> - 
                        <a href="https://nl-nl.facebook.com/Cafe-Borreltijd-252016991522362/" target="_blank">Proeverij Borreltijd</a> - 
                        <a href="https://www.heblad.nl/" target="_blank">Heblad</a> - 
                        <a href="http://www.ambiani.nl/" target="_blank">Ambiani</a> - 
                        <a href="http://www.vdhtransport.eu/" target="_blank">Van der Heijden Transport</a> -
                        <a href="http://www.groenengroep.com/" target="_blank">Groenen groep</a>
            
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <a href="https://www.facebook.com/beachvolleybalbladel/" target="_blank"><i class="fa fa-facebook-official big-icon" aria-hidden="true"></i></a> <a href="https://twitter.com/beach_bladel" target="_blank"><i class="fa fa-twitter-square big-icon" aria-hidden="true"></i></a> <a href="https://www.instagram.com/beachvolleybalbladel/" target="_blank"><i class="fa fa-instagram big-icon" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
@endsection