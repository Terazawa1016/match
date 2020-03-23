<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="viewport" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{csrf_token()}}">

  <title>{{config('app.name', 'Laravel')}}</title>

  <!-- Styles -->
  <link rel="stylesheet" href="{{asset('./css/app.css')}}">
</head>
<body>

  @yield('content')

  <!-- Scripts -->
  <script src="{{asset('js/app.js')}}"></script>
</body>
</html>
