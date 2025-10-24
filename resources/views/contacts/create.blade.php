@component('components.head', ['title' => 'Création d‘un contact'])
@endcomponent
<body>
@component('components.menu')
@endcomponent

<h1 class="font-bold text-4xl my-15 text-center flex flex-col mx-auto">{{__('create-contact.heading_create')}}</h1>

<form enctype="multipart/form-data" method="post" action="{{ route('contacts.store') }}"
      class="max-w-1/2 mx-auto my-10 shadow-2xl p-10 rounded-2xl">
    @csrf
    <fieldset class="border-2 p-5 my-10 rounded-lg shadow-2xl">
        <legend class="text-2xl p-2">Informations générales</legend>
    @component('components.form.fields.input', ['type' => 'text', 'field_name' => 'name', 'placeholder' => 'pedro pascal', 'required' => 'required'])
        Entrez un nom<small class="text-red-600 ml-1">*</small>
    @endcomponent
    @component('components.form.fields.input', ['type' => 'email', 'field_name' => 'email', 'placeholder' => 'pedro.pascal@gmail.com', 'required' => 'required'])
        Entrez votre email<small class="text-red-600 ml-1">*</small>
    @endcomponent
    @component('components.form.fields.input', ['type' => 'file', 'field_name' => 'avatar'])
        Choisissez votre avatar
    @endcomponent
    </fieldset>



    <fieldset class="border-2 p-5 my-10 rounded-lg shadow-2xl">
        <legend class="text-2xl p-2">Jiri</legend>
        @foreach($jiris as $jiri)
            {{--       @component('components.form.fields.input_checkbox', ['class_div' => 'mb-4', 'field_name' => 'projects[{!! $jiri->id !!}]', 'id'=>$jiri->id])
                       {{$jiri->name}}
                   @endcomponent--}}
            <div class="mb-4">
                <input type="checkbox" name="projects[{!! $jiri->id !!}]" id="{{$jiri->name}}" value="{{$jiri->id}}">
                <label for="{{$jiri->name}}">{{$jiri->name}}</label>
            </div>
        @endforeach
    </fieldset>

    @component('components.form.buttons.button', ['text' => 'Créez le contact'])
    @endcomponent

</form>
</body>
@component('components.footer')
@endcomponent

