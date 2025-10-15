<!doctype html>
    <html lang="{!! app()->getLocale() !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-6">
    <h1 class="font-bold text-4xl my-4 text-center flex flex-col mx-auto">{!! __('headings.create_your_jiri') !!}</h1>

    <form action="{!! route('jiris.store') !!}" method="post" class="max-w-1/2 mx-auto my-10">
        @csrf
        <fieldset class="border-2 p-5 rounded-lg">
            <legend class="text-2xl p-2">Informations générales</legend>
            <div class="flex flex-col">
                <label for="name">Nom <small>(Requis)</small></label>
                @error('name')
                <p class="text-red-500">{!! $message !!}</p>
                @enderror
                <input type="text" name="name" id="name" value="{{old('name')}}" class="border-2 rounded-lg p-2" placeholder="Design Web">
            </div>
            <div class="flex flex-col my-5">
                <label for="date">Date <small>(Requis)</small></label>
                @error('date')
                <p>{!! $message !!}</p>
                @enderror
                <input type="date" name="date" id="date" value="{{old('date')}}" class="border-2 rounded-lg p-2">
            </div>
            <div class="flex flex-col">
                <label for="date">Description</label>
                <textarea name="description" id="description" cols="25" rows="10" class="border-2 rounded-lg p-2" placeholder="Jury des élèves de 2e..."></textarea>
            </div>
        </fieldset>
        <fieldset class="border-2 p-5 my-10 rounded-lg">
            <legend class="text-2xl p-2">Contacts</legend>
            <div class="border-b-1 p-2">
                <input type="checkbox" name="contacts[1]" id="JM" value="1">
                <label for="JM">Jean-Michel</label>
                <select name="roles[1]" id="role1" class="mx-15 border-1 p-2 rounded-lg">
                    <option selected value="none">Rôle</option>
                    <option value="evalue">Evalué</option>
                    <option value="evaluateur">Evaluateur</option>
                </select>
            </div>
            <div class="border-b-1 p-2 my-5">
                <input type="checkbox" name="contacts[2]" id="JP" value="2">
                <label for="JP">Jean-Paul</label>
                <select name="roles[2]" id="role2" class="mx-19 border-1 p-2 rounded-lg">
                    <option selected value="none">Rôle</option>
                    <option value="evaluated">Evalué</option>
                    <option value="evaluator">Evaluateur</option>
                </select>
            </div>
            <div class="border-b-1 p-2 my-5">
                <input type="checkbox" name="contacts[3]" id="J" value="3">
                <label for="J">Jean</label>
                <select name="roles[3]" id="role3" class="mx-29 border-1 p-2 rounded-lg">
                    <option selected value="none">Rôle</option>
                    <option value="evaluated">Evalué</option>
                    <option value="evaluator">Evaluateur</option>
                </select>
            </div>
        </fieldset>
        <fieldset class="border-2 p-5 my-10 rounded-lg">
            <legend class="text-2xl p-2">Projets</legend>
            <div>
                <input type="checkbox" name="projects[1]" id="cv" value="1">
                <label for="cv">CV</label>
            </div>
            <div class="my-3">
                <input type="checkbox" name="projects[2]" id="client" value="2">
                <label for="client">Client</label>
            </div>
            <div>
                <input type="checkbox" name="projects[3]" id="portfolio" value="Portfolio">
                <label for="portfolio">Portfolio</label>
            </div>
        </fieldset>

        <button type="submit" class="border-2 rounded-lg p-3 my-6 w-1/1 hover:bg-blue-950 hover:text-white">{!! __('labels-buttons.create_a_jiri') !!}</button>
    </form>
</body>
</html>
