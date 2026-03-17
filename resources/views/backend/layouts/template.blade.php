<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AUTOGO - FAST FIT CAR SERVICE</title>
    @include('backend/layouts/css')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open">
    <div class="app-wrapper">
        @include('backend/layouts/topbar')
        @include('backend/layouts/navbar')
        <main class="app-main mt-5">
            <div class="app-content">
                @yield('content')
            </div>
        </main>
    </div>
    @include('backend/layouts/js')
</body>

</html>
