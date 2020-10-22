<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>
    <link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body>
    <main id="book_store">
        <navigation></navigation>
        <router-view></router-view>
    </main>
    <script src="/js/app.js"></script>
</body>
</html>