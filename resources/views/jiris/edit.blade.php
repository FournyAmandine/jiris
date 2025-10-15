<!doctype html>
<html lang="{!! App::getLocale(); !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{__('page-title.modify')}} - Jiri </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-1/1">
<div class="flex justify-center items-center mt-15 w-1/3 m-auto">
    <svg  class="m-auto" height="100px" width="100px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          viewBox="0 0 512 512" xml:space="preserve">
        <g>
            <path class="st0" d="M505.837,180.418L279.265,76.124c-7.349-3.385-15.177-5.093-23.265-5.093c-8.088,0-15.914,1.708-23.265,5.093
		L6.163,180.418C2.418,182.149,0,185.922,0,190.045s2.418,7.896,6.163,9.627l226.572,104.294c7.349,3.385,15.177,5.101,23.265,5.101
		c8.088,0,15.916-1.716,23.267-5.101l178.812-82.306v82.881c-7.096,0.8-12.63,6.84-12.63,14.138c0,6.359,4.208,11.864,10.206,13.618
		l-12.092,79.791h55.676l-12.09-79.791c5.996-1.754,10.204-7.259,10.204-13.618c0-7.298-5.534-13.338-12.63-14.138v-95.148
		l21.116-9.721c3.744-1.731,6.163-5.504,6.163-9.627S509.582,182.149,505.837,180.418z"/>
            <path class="st0" d="M256,346.831c-11.246,0-22.143-2.391-32.386-7.104L112.793,288.71v101.638
		c0,22.314,67.426,50.621,143.207,50.621c75.782,0,143.209-28.308,143.209-50.621V288.71l-110.827,51.017
		C278.145,344.44,267.25,346.831,256,346.831z"/>
        </g>
</svg>
    <h1 class="font-bold text-4xl my-4 text-center flex flex-col mx-auto">{{__('editing.title')}}</h1>

</div>
    <form action="{!! route('jiris.store') !!}" method="post" class="max-w-1/2 mx-auto my-10">
        @csrf
        <fieldset class="border-2 p-5 rounded-lg shadow-2xl bg-gray-50">
            <legend class="text-2xl p-2">Informations générales</legend>
            <div class="flex flex-col">
                <label for="name">Nom <small>(Requis)</small></label>
                @error('name')
                <p class="text-red-500">{!! $message !!}</p>
                @enderror
                <input type="text" name="name" id="name" value="{{$jiri->name}}" class="border-2 rounded-lg p-2 bg-white" >
            </div>
            <div class="flex flex-col my-5">
                <label for="date">Date <small>(Requis)</small></label>
                @error('date')
                <p>{!! $message !!}</p>
                @enderror
                <input type="date" name="date" id="date" value="{{$jiri->date}}" class="border-2 rounded-lg p-2  bg-white">
            </div>
            <div class="flex flex-col">
                <label for="date">Description</label>
                <textarea name="description" id="description" cols="25" rows="10" class="border-2 rounded-lg p-2 bg-white" placeholder="Jury des élèves de 2e...">{{$jiri->description}}
                </textarea>
            </div>
        </fieldset>
        <fieldset class="border-2 p-5 my-10 rounded-lg shadow-2xl">
            <legend class="text-2xl p-2">Contacts</legend>
            @foreach($contacts as $contact)
                <div class="border-b-1 p-4 pr-80 mb-3 flex justify-between items-center">
                    <div>
                        <input type="checkbox" name="contacts[1]" id="{{$contact->name}}" value="{{$contact->id}}">
                        <label for="{{$contact->name}}">{{$contact->name}}</label>
                    </div>
                    <select name="roles[1]" id="role1" class="border-1 p-2 rounded-lg">
                        <option selected value="none">Rôle</option>
                        <option value="evalue">Evalué</option>
                        <option value="evaluateur">Evaluateur</option>
                    </select>
                </div>
            @endforeach
        </fieldset>
        <fieldset class="border-2 p-5 my-10 rounded-lg shadow-2xl">
            <legend class="text-2xl p-2">Projets</legend>
            @foreach($projects as $project)
                <div class="mb-4">
                    <input type="checkbox" name="projects[1]" id="{{$project->name}}" value="{{$project->id}}">
                    <label for="{{$project->name}}">{{$project->name}}</label>
                </div>
            @endforeach
        </fieldset>

        <button type="submit" class="shadow-2xl border-2 rounded-lg p-3 my-6 w-1/1 hover:bg-blue-950 hover:text-white hover:scale-105">{!! __('editing.title') !!}</button>
    </form>
</body>
</html>
