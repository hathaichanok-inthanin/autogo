<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AUTOGO - FAST FIT CAR SERVICE</title>
    @include('frontend/layouts/css')
    @include('backend/layouts/css')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <div class="app-wrapper">
        <main class="app-main" style="background-color: #ffcb10 !important;">
            @yield('content')
        </main>
    </div>
    @include('backend/layouts/js')
</body>

</html>
