<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.landing.seo')
    @include('layouts.landing.css')
</head>
<body>
    @include('layouts.landing.topbar')
    @include('layouts.landing.navbar')
    <!-- Content -->
        @yield('content')
    <!--/ Content -->
    @include('layouts.landing.footer')
    @include('layouts.landing.js')
    <!-- Custom JS -->
        @yield('js')
    <!--/ Custom JS -->
</body>

</html>