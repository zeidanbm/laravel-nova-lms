<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <script src="https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit" async defer>
    </script> --}}
    {{-- @if(App::environment('production')) --}}
    <link rel="stylesheet" href="{!! env('APP_URL') !!}/{{ mix('app.css') }}" />
    {{-- @endif --}}

</head>
<body>
    @include('partials.header')
    
    @yield('content')
    
    @include('partials.footer')
    
    <script src="{!! env('APP_URL') !!}/{{ mix('chunk-vendors.js') }}"></script>
    <script src="{!! env('APP_URL') !!}/{{ mix('app.js') }}"></script>
</body>
</html>