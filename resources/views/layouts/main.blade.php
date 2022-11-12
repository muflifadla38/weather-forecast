<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Weather Forecast</title>
   <link rel="icon" href="/img/favicon.png">

   <link rel="stylesheet" href="/css/bootstrap.min.css">
   <link rel="stylesheet" href="/css/main.css">
</head>
<body>
   @include('layouts.navbar')
   <div class="container">
      @yield('container')
   </div>
   @include('layouts.footer')

   <script src="/js/jquery-3.6.0.min.js"></script>
   <script src="/js/bootstrap.min.js"></script>
   <script src="/js/feather-icon.min.js"></script>
   <script src="/js/main.js"></script>
</body>
</html>