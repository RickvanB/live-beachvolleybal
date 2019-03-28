<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f8f8f8" />
    <meta name="description" content="Bekijk live je programma, standen & uitslagen!" />

    <title>Beachvolleybal Bladel - Live</title>

    <!-- Fonts -->
    <link href="/assets/css/font-awesome.min.css" rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet'>

    <!-- Styles -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
    @if(Request::is('login'))
        <link href="/assets/css/bootstrap-social.css" rel="stylesheet">
    @endif
    @if(Request::is('dashboard'))
        <link rel="stylesheet" type="text/css" href="/assets/css/dataTables.bootstrap.min.css">
    @endif
    @if(Request::is('account/settings'))
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-switch.min.css">
    @endif
    @if(Request::is('/') || Request::is('account/settings'))
        <link rel="stylesheet" type="text/css" href="/assets/css/select2.min.css">
    @endif
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    {!! Analytics::render() !!}

    <link rel="manifest" href="/manifest.json">
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(["init", {
          appId: "d6222836-c73e-4d51-80e3-aa5c27903ec4",
          autoRegister: true,
          allowLocalhostAsSecureOrigin: true,
          httpPermissionRequest: true
        }]);
  </script>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default title-heading">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Beach Bladel Live
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Programma Zaterdag<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if($poule_saturday->isEmpty())
                                <li><a href="#">Er zijn helaas nog geen poules beschikbaar</a></li>
                            @else
                                @foreach($poule_saturday as $row)
                                    <li><a href="{{ url('/overview/zaterdag/poule/'.$row->poule.'')}}">Poule {{ $row->poule }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Programma Zondag<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if($poule_sunday->isEmpty())
                                <li><a href="#">Er zijn helaas nog geen poules beschikbaar</a></li>
                            @else
                                @foreach($poule_sunday as $row)
                                    <li><a href="{{ url('/overview/zondag/poule/'.$row->poule.'')}}">Poule {{ $row->poule }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                Jouw wedstrijden <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/uitslagen/invoeren') }}"><i class="fa fa-btn fa-paper-plane" aria-hidden="true"></i>Uitslagen invoeren</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-btn fa-user" aria-hidden="true"></i>{{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                @if($user == 'Administrator')
                                    <li><a href="{{ url('/dashboard') }}"><i class="fa fa-btn fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
                                @endif
                                <li><a href="{{ url('/account/settings')}}"><i class="fa fa-btn fa-cogs" aria-hidden="true"></i>Instellingen</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    @if(Request::is('contact'))
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif

    <!-- JavaScripts -->
    <script src="/assets/js/jquery-2.1.4.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
    <script>
        window.addEventListener("load", function(){
        window.cookieconsent.initialise({
          "palette": {
            "popup": {
              "background": "#ff0000"
            },
            "button": {
              "background": "#ffffff"
            }
          },
          "theme": "edgeless",
          "content": {
            "message": "Deze website maakt gebruikt van cookies.",
            "dismiss": "Akkoord",
            "link": "Lees onze privacy policy",
            "href": "https://www.vcbladel.nl/privacy/"
          }
        })});

        $(document).ready(function(){
          $('.sponsor-slides').slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 2000,
            speed: 300,
            slidesToShow: 3,
            centerMode: true,
            variableWidth: true,
            adaptiveHeight: true,
            touchMove: true,
            responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: false
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: false
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
          });
        });
    </script>

    @if(Request::is('account/settings'))
        <script src="/assets/js/bootstrap-switch.min.js"></script>
        <script type="text/javascript">
            $("[name='automatic_updates']").bootstrapSwitch();
        </script>
    @endif

    @if(Request::is('/') || Request::is('account/settings'))
        <script src="/assets/js/select2.full.min.js"></script>
        <script type="text/javascript">
            $(window).ready(function()
            {
                $("#livesearch").select2();
            });
            @if(Request::is('/'))
                $('select').change(function()
                {
                    var element = $(this).find('option:selected');
                    var team = element.data('team');
                    var poule = element.data('poule'); 
                    var dag =  element.data('dag');
                    
                    $.ajax({
                        url: '/api/insertQuery?team='+team,
                        success: function()
                        {
                            window.location.replace("https://live.vcbladel.nl/overview/"+dag+"/poule/"+poule);
                        }
                    });
                });
            @endif
        </script>
    @endif
    
    @if(Request::is('dashboard'))
        <script type="text/javascript" src="/assets/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="/assets/js/dataTables.bootstrap.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function() 
            {
                $('#status').DataTable();

            });

            if($('#status tr > td > span:contains(Succesvol)').length)
            {
                $('#status tr > td > span:contains(Succesvol)').addClass('label label-success');
            }
            
            if($('#status tr > td > span:contains(Mislukt)').length)
            {
                $('#status tr > td > span:contains(Mislukt)').addClass('label label-warning');
            }
        </script>
    @endif

    @if(!empty(Auth::user()->team))
        <script type="text/javascript">
            $(document).ready(function()
            {
                $('.table tr.selectedteam td').each(function() 
                {
                    if ($(this).text() == '{{ Auth::user()->team }}') 
                    {
                        $(this).closest('tr').css('background-color', '#FFFF00');
                    }
                });
            });
        </script>
    @endif
</body>
</html>
