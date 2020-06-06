<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <style>


            #borad{
                width: 70%;
                height: 500px;
                margin: auto;
                background-image: url({{ asset('images/background_image.png') }}) ;
                background-size: cover;
            }
            .content {

                width: 100%;
                text-align: center;

            }
            h1{
                margin-top: 5%;
            }
            #numbers{
                font-weight: 600;
                letter-spacing: .1rem;
                margin-top: 15%;
            }
            #countires{
                width: 70%;
                margin: auto;
                margin-bottom: 6%;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div id="borad">
                    <h1><span id="countrynameintitle">World wide</span> COVID-19 cases</h1>
                    <div id="numbers">
                        <ul class="list-group w-25 mx-auto">
                            <li class="list-group-item list-group-item-warning">Confirmed : <span id="Confirmed"></span></li>
                            <li class="list-group-item list-group-item-danger">Deaths : <span id="Deaths" ></span></li>
                            <li class="list-group-item list-group-item-success">Recovered : <span id="Recovered"></span></li>
                        </ul>
                    </div>
                </div>

                <div id="countires" class="row text-center text-lg-left">
                    <input class="form-control m-4 w-30" id="search" type="text" placeholder="Search" aria-label="Search">
                </div>
            </div>
        </div>

            <script>

                $(document).ready(function(){



                    var api_url ="{{url('/api/allapi')}}" //;



                    $("#numbers").ready(function () {
                        // get world wide cases
                        $.get("{{url('/api/world')}}", function(data, status){

                            $("#Confirmed").text(parseInt(data.Confirmed));
                            $("#Deaths").text(parseInt(data.Deaths));
                            $("#Recovered").text(parseInt(data.Recovered));;
                        });
                    });

                    $("#countires").ready(function () {
                        // get all countries listed in csv

                        $.get(api_url, function(data, status){
                          //  alert(status);
                            for(var i = 0; i < data.length; i++) {
                                var obj = data[i];
                                $("#countires").append('<div class="col-lg-3 col-md-4 col-6"><button onclick="countryData(this)" type="button" style="width:80%" class="country btn-primary" >'+obj.Country_Region+'</button></div>');
                            }

                            });
                    });

                });
                // search function
                $('#search').keyup( function () {
                    $('.country').hide()
                    var txt = $('#search').val();
                    $('.country').each(function () {
                        if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1) $(this).show();
                    })
                });

                // on click
                function countryData(btn) {

                    // get a specific country data

                    var countryName= $(btn).text();
                    var get_url = "{{url('/api')}}/"+countryName;
                    $.get(get_url, function(data, status){


                        //insert data

                        $("#countrynameintitle").text(data.Country_Region);
                        $("#Confirmed").text(parseInt(data.Confirmed));
                        $("#Deaths").text(parseInt(data.Deaths));
                        $("#Recovered").text(parseInt(data.Recovered));

                    });
                }
            </script>
    </body>
</html>
