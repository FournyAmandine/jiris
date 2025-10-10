<!doctype html>
<html lang="{!! App::getLocale(); !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <h1>Liste des jiris</h1>
    @foreach($jiris as $jiri)
        <a href="">{{ $jiri->name}}</a>
    @endforeach

</body>
</html>
