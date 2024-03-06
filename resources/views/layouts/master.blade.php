<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.header')

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('layouts.nav_bar')
        @include('layouts.sidebar')
        @include('layouts.content')
        @include('layouts.footer')
    </div>
    @include('layouts.scripts')
</body>

</html>
