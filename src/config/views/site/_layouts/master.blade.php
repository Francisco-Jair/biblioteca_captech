<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Justified Nav Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
          integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
          crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 20px;
        }

        .footer {
            padding-top: 40px;
            padding-bottom: 40px;
            margin-top: 40px;
            border-top: 1px solid #eee;
        }

        /* Main marketing message and sign up button */
        .jumbotron {
            text-align: center;
            background-color: transparent;
        }

        .jumbotron .btn {
            padding: 14px 24px;
            font-size: 21px;
        }

        /* Customize the nav-justified links to be fill the entire space of the .navbar */

        .nav-justified {
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .nav-justified > li > a {
            padding-top: 15px;
            padding-bottom: 15px;
            margin-bottom: 0;
            font-weight: bold;
            color: #777;
            text-align: center;
            background-color: #e5e5e5; /* Old browsers */
            background-image: -webkit-gradient(linear, left top, left bottom, from(#f5f5f5), to(#e5e5e5));
            background-image: -webkit-linear-gradient(top, #f5f5f5 0%, #e5e5e5 100%);
            background-image: -o-linear-gradient(top, #f5f5f5 0%, #e5e5e5 100%);
            background-image: linear-gradient(to bottom, #f5f5f5 0%, #e5e5e5 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f5f5f5', endColorstr='#e5e5e5', GradientType=0); /* IE6-9 */
            background-repeat: repeat-x; /* Repeat the gradient */
            border-bottom: 1px solid #d5d5d5;
        }

        .nav-justified > .active > a,
        .nav-justified > .active > a:hover,
        .nav-justified > .active > a:focus {
            background-color: #ddd;
            background-image: none;
            -webkit-box-shadow: inset 0 3px 7px rgba(0, 0, 0, .15);
            box-shadow: inset 0 3px 7px rgba(0, 0, 0, .15);
        }

        .nav-justified > li:first-child > a {
            border-radius: 5px 5px 0 0;
        }

        .nav-justified > li:last-child > a {
            border-bottom: 0;
            border-radius: 0 0 5px 5px;
        }

        @media (min-width: 768px) {
            .nav-justified {
                max-height: 52px;
            }

            .nav-justified > li > a {
                border-right: 1px solid #d5d5d5;
                border-left: 1px solid #fff;
            }

            .nav-justified > li:first-child > a {
                border-left: 0;
                border-radius: 5px 0 0 5px;
            }

            .nav-justified > li:last-child > a {
                border-right: 0;
                border-radius: 0 5px 5px 0;
            }
        }

        /* Responsive: Portrait tablets and up */
        @media screen and (min-width: 768px) {
            /* Remove the padding we set earlier */
            .masthead,
            .marketing,
            .footer {
                padding-right: 0;
                padding-left: 0;
            }
        }

    </style>

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"
          integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"
            integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ=="
            crossorigin="anonymous"></script>
</head>

<body>

<div class="container">

    <!-- The justified navigation menu is meant for single line per list item.
         Multiple lines will require custom code not provided by Bootstrap. -->
    <div class="masthead">
        <h3 class="text-muted">Project name</h3>
        <nav>
            <ul class="nav nav-justified">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Projects</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Downloads</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </div>

    @yield('content')

            <!-- Site footer -->
    <footer class="footer">
        <p>&copy; Company 2015</p>
    </footer>

</div>
<!-- /container -->
</body>
</html>
