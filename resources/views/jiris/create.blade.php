@component('components.head', ['title' => 'Création d‘un jiri'])
@endcomponent
<body class="p-6">
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
        <fieldset class="border-2 p-5 my-10 rounded-lg shadow-2xl">
            <legend class="text-2xl p-2">Contacts</legend>
            @foreach($contacts as $contact)
                <div class="border-b-1 p-4 pr-80 mb-3 flex justify-between items-center">
                    <div>
                        <input type="checkbox" name="contacts[{{$contact->id}}][checked]" id="{{$contact->name}}" value="{{$contact->id}}">
                        <label for="{{$contact->name}}">{{$contact->name}}</label>
                    </div>
                    <select name="contacts[{{$contact->id}}][role]" id="role1" class="border-1 p-2 rounded-lg">
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
</body>
@component('components.footer')
@endcomponent
