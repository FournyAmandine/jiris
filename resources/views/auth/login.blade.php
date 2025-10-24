@component('components.head', ['title' => 'Se connecter'])
@endcomponent
<body class="flex justify-center items-center min-h-screen">
<section class=" shadow-2xl p-10 rounded-2xl">

    @include('svg.student_cap')

    <h1 class="font-bold text-3xl my-5 text-center">{{__('login.identify_yourself')}}</h1>
    <form action="{{route('login.store')}}" method="post">
        @csrf
        <p class="text-red-600 text-xs mb-3">{{__('login.fields_are_required')}}</p>

        <fieldset>

            @component('components.form.fields.input', ['type' => 'email', 'field_name' => 'email', 'placeholder' => 'pedro.pascal@gmail.com', 'required' => 'required'])
                Entrez votre email<small class="text-red-600 ml-1">*</small>
            @endcomponent


            @component('components.form.fields.input', ['type' => 'password', 'field_name' => 'password', 'required' => 'required'])
                Entrez votre mot de passe<small class="text-red-600 ml-1">*</small>
            @endcomponent

            @component('components.form.fields.input_checkbox', ['class_div' => 'flex mt-5 items-center', 'class_input' => 'mr-2', 'field_name' => 'memory', 'class_label' => 'text-s'])
                Se souvenir de moi
                <a class="text-xs pl-20 text-blue-500 " href="#">{{__('login.forget_password')}}</a>
            @endcomponent

            @component('components.form.buttons.button', ['class' => 'text-xl font-semibold bg-blue-500 text-white p-2 rounded-sm mt-5 w-1/1 hover:bg-sky-800', 'text' => 'Se connecter'])
            @endcomponent


            @component('components.form.fields.link', ['text_p' => 'Pas encore de compte?', 'text_a' => 'Enregistrez-vous', 'href' => route('register.store')])
            @endcomponent

        </fieldset>
    </form>
</section>

</body>
@component('components.footer')
@endcomponent
