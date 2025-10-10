<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    <h1>Liste des projets</h1>

    @foreach($projects as $project)
        {{ $project }}
    @endforeach
</body>
</html>
