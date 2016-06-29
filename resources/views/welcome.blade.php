<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' rel='stylesheet' type='text/css'>

  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <style>
            html, body {
                height: 100%;
            }

            body {
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
            }

            .content {
                text-align: center;
                display: inline-block;
                width: 100%;
            }

            .title {
                font-size: 22px;
            }
            .text-center{
                text-align:center;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <?php
                $person = new App\Myclasses\person;

                $name = $person->getName('niall');

                $conflicts = App\Models\Conflict::take(10)->get()->toJson();

                //dd($conflicts);
            ?>
             @yield('content')                

        </div>
    </body>
</html>
