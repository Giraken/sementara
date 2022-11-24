<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    @routes
    <script src="{{ mix('js/app.js') }}" defer></script>
    @inertiaHead

    <!-- TODO: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-WIi9CZS0XzioWHCO"></script>
</head>

<body class="font-sans antialiased">
    <script src="https://www.paypal.com/sdk/js?client-id=AWrOyi03BYk-AM9k82JEyfNOsHUvoxoGLK8V5PfR7O6Vzpuj_3ibI_u9uoPu3urYyKEzEZwzcS7tcvwh&vault=true&intent=subscription">
    </script>


    @inertia

    @env ('local')
    <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
    @endenv
</body>

</html>