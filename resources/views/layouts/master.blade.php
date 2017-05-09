<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        header, main, footer {
            padding-left: 300px;
        }

        @media only screen and (max-width : 992px) {
            header, main, footer {
                padding-left: 0;
            }
        }
    </style>
</head>

<body>
<main class="main">
<nav class="grey darken-4">
    <div class="nav-wrapper">
        <a href="/" class="center brand-logo grey-text">Admin</a>
        {{--<ul id="nav-mobile" class="right hide-on-med-and-down">--}}
            {{--<li><a href="sass.html">Sass</a></li>--}}
            {{--<li><a href="badges.html">Components</a></li>--}}
            {{--<li><a href="collapsible.html">JavaScript</a></li>--}}
        {{--</ul>--}}
    </div>
    <ul id="slide-out" class="side-nav fixed">
        <li><a href="{{route('container.index')}}">Quản lý website</a></li>
        <li><a href="{{route('vps.index')}}">Quản lý VPS</a></li>
    </ul>
    <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
</nav>

<div class="container-fluid">
    @yield('content')
</div>
</main>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
@yield('page_script')
</body>
</html>
