<!doctype html>
<html lang="{!! App::getLocale(); !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{__('create-contact.heading_create')}} - Jiri</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <h1 class="font-bold text-4xl my-15 text-center flex flex-col mx-auto">{{__('create-contact.heading_create')}}</h1>

    <form enctype="multipart/form-data" method="post" action="{{ route('contacts.store') }}" class="max-w-1/2 mx-auto my-10 shadow-2xl p-10 rounded-2xl">
        @csrf
        <div class="flex flex-col">
            <label for="name">Nom <small>(Requis)</small></label>
            <input type="text" name="name" id="name" value="{{old('name')}}" class="border-2 rounded-lg p-2" placeholder="Pedro Pascal">
            @error('name')
            <p class="text-red-500">{!! $message !!}</p>
            @enderror
        </div>
        <div class="flex flex-col mt-10">
            <label for="email">Email <small>(Requis)</small></label>
            <input type="text" name="email" id="email" value="{{old('email')}}" class="border-2 rounded-lg p-2" placeholder="pedro.pascal@gmail.com">
            @error('email')
            <p class="text-red-500">{!! $message !!}</p>
            @enderror
        </div>
        <div class="flex flex-col mt-10">
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" id="avatar" value="" class="border-2 rounded-lg p-2">
            @error('file')
            <p class="text-red-500">{!! $message !!}</p>
            @enderror
        </div>
        <button type="submit" class="border-2 rounded-lg p-3 my-10 w-1/1 hover:scale-105 bg-blue-950 text-white">{!! __('labels-buttons.create_a_contact') !!}</button>

    </form>
</body>
</html>

