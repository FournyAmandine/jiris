<!doctype html>
<html lang="{!! app()->getLocale() !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$contact->name}} - Jiri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-1/2 m-auto">
    <h1 class="font-bold text-4xl my-15 text-center flex flex-col mx-auto">{{$contact->name}}</h1>
    <section class="mb-15 shadow-2xl p-10 rounded-2xl flex items-center">
        <h2 class="text-2xl font-medium">Email :</h2>
        <p class="text-m ml-5 mt-1">{{$contact->email}}</p>
    </section>
    @isset($contact->avatar)
    <section class="mb-15 shadow-2xl p-10 rounded-2xl flex items-center">
        <h2 class="text-2xl font-medium">Avatar :</h2>
        <img class="pl-10" src="{!!  asset('storage/images/contacts/variants/300x300/'.$contact->avatar)!!}" alt="Avatar du contact {{$contact->name}}">
    </section>
    @endisset
    <div class="flex justify-end">
        <a class="mb-20 inline-block px-10 py-5 rounded-xl bg-blue-900 text-white" href="{{route('contacts.edit', $contact->id)}}">Modifier</a>
    </div>
</body>
</html>
