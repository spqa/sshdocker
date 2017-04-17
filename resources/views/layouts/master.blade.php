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
</head>

<body>
<nav class="transparent">
    <div class="nav-wrapper">
        <a href="#" class="brand-logo grey-text">Admin</a>
        {{--<ul id="nav-mobile" class="right hide-on-med-and-down">--}}
            {{--<li><a href="sass.html">Sass</a></li>--}}
            {{--<li><a href="badges.html">Components</a></li>--}}
            {{--<li><a href="collapsible.html">JavaScript</a></li>--}}
        {{--</ul>--}}
    </div>
</nav>

<div class="container-fluid">
    @yield('content')
</div>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.2/js/materialize.min.js"></script>
</body>
</html>