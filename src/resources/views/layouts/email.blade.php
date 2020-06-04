<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <title>MyUpload Submission Response - @yield('response')</title>

    </head>
    <body>
        <header>
            <h1>MyUpload Submission Response - @yield('response')</h1>
        </header>

        <section class='message-section'>
            <h2>The following media has been @yield('response'):</h2>

            @yield('content')
        </section> <!-- message-section -->
        
        <footer>
            &copy; <?= date('Y'); ?> <?= env('APP_NAME'); ?>
        </footer>
    </body>
</html>