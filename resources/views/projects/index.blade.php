<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes projets - Jiri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-2/5 m-auto">
<header>
    <div class="flex items-center justify-center mb-10 mt-10">
        <h1 class="text-4xl ml-5 font-bold">Mes projets</h1>
    </div>
</header>

<main>
    @foreach($projects as $project)
        <div class="relative shadow-2xl rounded-2xl mb-8 flex hover:scale-105">
            <a class="absolute top-0 left-0 right-0 bottom-0 w-1/1 inline-block text-lg"
               href="{{route('projects.show', $project->id)}}"></a>
            <div class="p-15">
                <p class="">{{ $project->name}}</p>
            </div>
        </div>
    @endforeach
</main>

</body>
</html>
