<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Adrian Sobiesierski & Grzegorz Sot">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Multimodalny system identyfikacji biometrycznej</title>

        <link rel="stylesheet" href="/storage/html/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/storage/html/css/style.css">
   
        <script src="/storage/html/js/jquery-3.5.1.min.js"></script>
        <script src="/storage/html/js/custom.js"></script>
        <script src="/storage/html/bootstrap/js/bootstrap.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </head>
    <body>
        <header>
            <p class="title-name">Multimodalny system identyfikacji biometrycznej</p>
        </header>
        <main>
            <div class="image-space"> 
                <div class="image-view">
                    <img id="image" src="/storage/html/img/initial.jpg">
                    <button type="button" class="bottom-button btn-danger">
                        <span class="glyphicon glyphicon-fullscreen"></span>
                    </button>
                </div>    
            </div>
            <div class="about">
                <div></div>
                <div>Projekt został wykonany w ramach realizacji pracy inżynierskiej</div><br>
                <div><b>Autorzy</b></div>
                <div>Adrian Sobiesierski, Grzegorz Sot</div><br>
                <div><b>Promotor</b></div>
                <div>dr inż. Tomasz Marciniak</div>
            </div>
        </main>  
        <footer>
            <div class="footer-logo">
                <img id="logo" src="/storage/html/img/PP_logo_nowysygnet_PL.png">
            </div>
        </footer>  

    </body>
    
</html>
