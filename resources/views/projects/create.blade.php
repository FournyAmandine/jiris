<!doctype html>
<html lang="{!! App::getLocale() !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{__('create-project.heading_title_project')}} - Jiri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <h1 class="font-bold text-4xl my-4 text-center flex flex-col mx-auto">{{__('create-project.heading_title_project')}}</h1>
</body>
</html>
