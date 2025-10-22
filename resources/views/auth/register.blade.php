@component('components.head', ['title' => 'Créez un espace Jiri -Jiri'])
@endcomponent
<body class="flex justify-center items-center min-h-screen">
<section class=" shadow-2xl p-10 rounded-2xl">

    @include('svg.student_cap')

    <h1 class="font-bold text-3xl my-5 text-center">{{__('register.identify_yourself')}}</h1>
    <form action="{{route('register.store')}}" method="post">
        @csrf
        <p class="text-red-600 text-xs mb-3">{{__('register.fields_are_required')}}</p>
    <fieldset>
        <div  class="flex flex-col flex-1 mb-4">
            <label for="name">{{__('register.name')}}<small class="text-red-600 ml-1">*</small></label>
            <input class="border-1 border-gray-300 rounded-md p-1 mt-1" type="text" id="name" name="name"  value="{{ old('name') }}">
            @error('name')
            <p class=
                   "error text-red-600 text-xs">{{ $message }}</p>
            @enderror
        </div>
        @component('components.form.fields.input', ['type' => 'email', 'field_name' => 'email', 'placeholder' => 'pedro.pascal@gmail.com', 'required' => 'required'])
            Entrez votre email<small class="text-red-600 ml-1">*</small>
        @endcomponent

        @component('components.form.fields.input', ['type' => 'password', 'field_name' => 'password', 'required' => 'required'])
            Entrez un mot de passe<small class="text-red-600 ml-1">*</small>
        @endcomponent

        @component('components.form.fields.input_checkbox', ['class_div' => 'flex mt-5 items-center', 'class_input' => 'mr-2', 'field_name' => 'memory', 'class_label' => 'text-s'])
            Se souvenir de moi
        @endcomponent

        @component('components.form.buttons.button', ['class' => 'text-xl font-semibold bg-blue-500 text-white p-2 rounded-sm mt-5 w-1/1 hover:bg-sky-800', 'text' => 'Créez l’espace'])
        @endcomponent

        @component('components.form.fields.link', ['text_p' => 'Déjà un compte?', 'text_a' => 'Connecter-vous', 'href' => route('login.store')])
        @endcomponent
    </fieldset>
    </form>

</section>
</body>

@component('components.footer')
@endcomponent
