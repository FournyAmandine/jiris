<!doctype html>
<html lang="{!! App::getLocale(); !!}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{__('page-title.modify')}} - Jiri </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-1/1">
<x-menu></x-menu>
<div class="flex justify-center items-center mt-15 w-1/3 m-auto">
    @include('svg.student_cap')
    <h1 class="font-bold text-4xl my-4 text-center flex flex-col mx-auto">{{__('editing.title')}}</h1>

</div>
    <form action="{!! route('jiris.update', $jiri->id) !!}" method="post" class="max-w-1/2 mx-auto my-10">
        @method('PATCH')
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
        <fieldset class="border-2 p-5 rounded-lg shadow-2xl bg-gray-50 mt-10">
            <legend class="text-2xl p-2">Contacts</legend>
            <div class="flex flex-col gap-2 mt-2">
                @foreach($contacts as $contact)
                    @php
                        $attendance = \App\Models\Attendance::where('contact_id', $contact->id)
                            ->where('jiri_id', $jiri->id)
                            ->first();
                    @endphp
                    <div class="flex items-center justify-between border-b border-gray-100 py-2">
                        <div class="flex items-center gap-2">
                            <input class="contact" type="checkbox" value="{{ $contact->id }}"
                                   name="contacts[{{ $contact->id }}]" id="contact{{ $contact->id }}"
                                {{ $attendance ? 'checked' : '' }}>
                            <label for="contact{{ $contact->id }}" class="font-medium">{{ $contact->name }}</label>
                        </div>
                        <select id="role{{ $contact->id }}" name="contacts[{{ $contact->id }}][role]"
                                class="border border-gray-300 rounded-xl p-2 disabled:opacity-50"
                            {{ $attendance ? '' : 'disabled' }}>
                            @foreach(\App\Enums\ContactRoles::cases() as $role)
                                <option value="{{ $role->value }}" {{ $attendance && $attendance->role === $role->value ? 'selected' : '' }}>
                                    {{ $role->value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const checkboxes = document.querySelectorAll('.contact');

        checkboxes.forEach(checkbox => {
            const id = checkbox.value;
            const select = document.getElementById(`role${id}`);

            checkbox.checked ? select.disabled = false : select.disabled = true;

            checkbox.addEventListener('change', () => {
                checkbox.checked ? select.disabled = false : select.disabled = true;
            });
        });
    });
</script>
</body>
</html>
