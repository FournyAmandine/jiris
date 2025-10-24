@component('components.head', ['title' => 'Modification d‘un projet'])
@endcomponent
<body>
@component('components.menu')
@endcomponent
<h1 class="font-bold text-4xl my-10 text-center flex flex-col mx-auto">Modifiez votre projet</h1>
<form method="post" action="{{ route('projects.store') }}" class="max-w-1/2 mx-auto my-10 shadow-2xl p-10 rounded-2xl">
    @csrf
    @component('components.form.fields.input', ['type' => 'text', 'field_name' => 'name', 'placeholder' => 'Portfolio', 'required' => 'required'])
        Nom<small class="text-red-600 ml-1">*</small>
    @endcomponent
    @component('components.form.buttons.button', ['text' => 'Modifiez le projet'])
    @endcomponent

</form>
</body>
@component('components.footer')
@endcomponent

