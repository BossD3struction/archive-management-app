<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
    <title>Archive Management</title>
</head>
<body class="bg-light">
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->path() == 'files' ? 'active' : '' }}" href="/files">Files</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->path() == 'mp3/table' ? 'active' : '' }}" href="/mp3/table">MP3 table</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')
</div>
</body>
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')
</html>
