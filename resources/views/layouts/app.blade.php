<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('theme/favicon.png') }}">

    <!-- App title -->
    <title>@yield('title')</title>

    <!-- App css -->
    <link href="{{asset('theme/default/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('theme/default/assets/css/core.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('theme/default/assets/css/components.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('theme/default/assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('theme/default/assets/css/pages.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('theme/default/assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
<!--     <link href="{{asset('theme/default/assets/css/style.css')}}" rel="stylesheet" type="text/css" /> -->
    <style type="text/css">
        .account-logo-box {
            background-color: #c98c00;
        }
        body {
          background-image: url({{ asset('consentsms.jpg') }});
background-repeat: no-repeat;
background-size: cover;
}
.logo {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
.form-control {
    background-color: #fff;
}

.text-center{
    margin:4% !important;
}

</style>
</head>


<body class="bg-transparent">
    @yield('content')
    <script>
        var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src="{{asset('theme/default/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('theme/default/assets/js/bootstrap.min.js')}}"></script>



</body>

</html>
