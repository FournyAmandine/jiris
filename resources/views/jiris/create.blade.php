@component('components.head', ['title' => 'Création d‘un jiri'])
@endcomponent
<body class="p-6">
<x-menu></x-menu>
@include('svg.student_cap')
    <h1 class="font-bold text-4xl my-4 text-center flex flex-col mx-auto">{!! __('headings.create_your_jiri') !!}</h1>

    <form action="{!! route('jiris.store') !!}" method="post" class="max-w-1/2 mx-auto my-10">
        @csrf
        <fieldset class="border-2 p-5 rounded-lg shadow-2xl">
            <legend class="text-2xl p-2">Informations générales</legend>
            @component('components.form.fields.input', ['type' => 'text', 'field_name' => 'name', 'placeholder' => 'Design Web', 'required' => 'required'])
                Nom<small class="text-red-600 ml-1">*</small>
            @endcomponent
            @component('components.form.fields.input', ['type' => 'date', 'field_name' => 'date', 'required' => 'required'])
                Date<small class="text-red-600 ml-1">*</small>
            @endcomponent

            @component('components.form.fields.textarea', ['field_name' => 'description', 'placeholder' => 'Jury des 2eme...'])
                Description
            @endcomponent

        </fieldset>
        {{-- Contacts --}}
        <fieldset class="border border-gray-200 p-6 rounded-2xl">
            <legend class="text-2xl font-semibold px-2">Contacts</legend>
            <div class="flex flex-col gap-3 mt-3">
                @foreach($contacts as $contact)
                    <div class="flex items-center justify-between border-b border-gray-100 py-2">
                        <div class="flex items-center gap-2">
                            <input class="contact" value="{!! $contact->id !!}" type="checkbox"
                                   name="contacts[{!! $contact->id !!}]" id="contact{!! $contact->id !!}">
                            <label for="contact{!! $contact->id !!}" class="font-medium">{{ $contact->name }}</label>
                        </div>
                        <select id="role{!! $contact->id !!}" name="contacts[{!! $contact->id !!}][role]"
                                class="border border-gray-300 rounded-xl p-2 disabled:opacity-50"
                                disabled>
                            <option value="evaluated">Evalué</option>
                            <option value="evaluator">Evaluateur</option>
                        </select>
                    </div>
                @endforeach
            </div>
        </fieldset>
        <fieldset class="border-2 p-5 my-10 rounded-lg shadow-2xl">
            <legend class="text-2xl p-2">Projets</legend>
            @foreach($projects as $project)
         {{--       @component('components.form.fields.input_checkbox', ['class_div' => 'mb-4', 'field_name' => 'projects[{!! $project->id !!}]', 'id'=>$project->id])
                    {{$project->name}}
                @endcomponent--}}
                <div class="mb-4">
                    <input type="checkbox" name="projects[{!! $project->id !!}]" id="{{$project->name}}" value="{{$project->id}}">
                    <label for="{{$project->name}}">{{$project->name}}</label>
                </div>
            @endforeach
        </fieldset>

        @component('components.form.buttons.button', ['text' => 'Créez le jiri'])
        @endcomponent

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
@component('components.footer')
@endcomponent
